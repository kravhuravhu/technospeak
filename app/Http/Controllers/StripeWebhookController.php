<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use Stripe\Webhook;
 
class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $secret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe webhook error - invalid payload');
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe webhook error - invalid signature');
            return response('Invalid signature', 400);
        }

        Log::info('Stripe webhook received: ' . $event->type);

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            // Handle subscription payments
            if (isset($session->metadata->training_type_id)) {
                $trainingType = TrainingType::find($session->metadata->training_type_id);
                $client = Client::find($session->metadata->client_id);

                if ($client && $trainingType) {
                    // Update client subscription
                    $client->update([
                        'subscription_type' => strtolower($trainingType->name),
                        'subscription_expiry' => now()->addQuarter()
                    ]);

                    // Create or update payment record
                    Payment::updateOrCreate(
                        ['transaction_id' => $session->payment_intent],
                        [
                            'client_id' => $client->id,
                            'amount' => $session->amount_total / 100,
                            'payment_method' => 'stripe',
                            'status' => 'completed',
                            'payable_type' => 'subscription',
                            'payable_id' => $trainingType->id
                        ]
                    );
                }
            }
        }

        return response('Webhook received', 200);
    }
}