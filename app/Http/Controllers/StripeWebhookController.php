<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Initialize Stripe with your secret key
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

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
            $session = $event->data->object;
            
            // Find matching payment in your DB
            $payment = Payment::where('stripe_session_id', $session->id)->first();

            if ($payment) {
                $payment->status = 'paid';
                $payment->paid_at = now();
                $payment->stripe_customer_id = $session->customer ?? null;
                $payment->save();

                Log::info('Payment updated successfully for session: ' . $session->id);
            } else {
                Log::warning('No matching payment found for session: ' . $session->id);
            }
        }

        return response('Webhook received', 200);
    }
}