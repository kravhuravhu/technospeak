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
            // Verify the webhook came from Stripe
            $event = Webhook::constructEvent($payload, $sig_header, $secret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe webhook error - invalid payload');
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe webhook error - invalid signature');
            return response('Invalid signature', 400);
        }
 
        // Log receipt of event
        Log::info('Stripe webhook received: ' . $event->type);
 
        // Handle checkout session completion
        if ($event->type === 'checkout.session.completed') {
            $sessionId = $event->data->object->id;
            $customerId = $event->data->object->customer;
 
            // Find matching payment in your DB
            $payment = Payment::where('stripe_session_id', $sessionId)->first();
 
            if ($payment) {
                $payment->status = 'paid';
                $payment->paid_at = now();
                $payment->stripe_customer_id = $customerId;
                $payment->save();
 
                Log::info('Payment updated successfully for session: ' . $sessionId);
            } else {
                Log::warning('No matching payment found for session: ' . $sessionId);
            }
        }
 
        return response('Webhook received', 200);
    }
}