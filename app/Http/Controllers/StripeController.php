<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use App\Models\Payment;
use App\Models\Client;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\TrainingRegistration;
use App\Notifications\PaymentProcessed;

class StripeController extends Controller
{
    public function checkout($clientId, $planId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $client = Client::findOrFail($clientId);
        $isStudent = $client->userType === 'Student';

        if (str_starts_with($planId, 'training_')) {
            return $this->handleTrainingPayment($client, $planId);
        }

        if (str_starts_with($planId, 'subscription_')) {
            return $this->handleSubscriptionPayment($client, $planId);
        }

        if (str_starts_with($planId, 'service_')) {
            return $this->handleServicePayment($client, $planId);
        }

        return redirect()->back()->with('error', 'Invalid payment type');

        // other methods later
    }

    protected function handleTrainingPayment(Client $client, string $planId)
    {
        $sessionId = str_replace('training_', '', $planId);
        $session = TrainingSession::with('type')->findOrFail($sessionId);
        
        $price = $session->type->getPriceForUserType($client->userType);
        $description = "Training: " . $session->title;

        $stripeSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'zar',
                    'product_data' => [
                        'name' => $description,
                    ],
                    'unit_amount' => $price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&checkout_complete=true',
            'cancel_url' => url()->previous(),
            'customer_email' => $client->email,
            'metadata' => [
                'client_id' => $client->id,
                'training_session_id' => $session->id,
                'user_type' => $client->userType
            ]
        ]);

        return redirect($stripeSession->url);
    }

    protected function handleSubscriptionPayment(Client $client, string $planId)
    {
        $planId = str_replace('subscription_', '', $planId);
        $plan = TrainingType::findOrFail($planId);
        
        $price = $plan->getPriceForUserType($client->userType);
        $description = "Subscription: " . $plan->name;

        $stripeSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'zar',
                    'product_data' => [
                        'name' => $description,
                    ],
                    'unit_amount' => $price * 100,
                    'recurring' => [
                        'interval' => 'month',
                        'interval_count' => 3 // Quarterly
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&checkout_complete=true',
            'cancel_url' => url()->previous(),
            'customer_email' => $client->email,
            'metadata' => [
                'client_id' => $client->id,
                'plan_id' => $plan->id,
                'user_type' => $client->userType
            ]
        ]);

        return redirect($stripeSession->url);
    }

    protected function handleServicePayment(Client $client, string $planId)
    {
        $parts = explode('_', str_replace('service_', '', $planId));
        $serviceId = $parts[0];
        $hours = $parts[1] ?? 1;
        
        $service = ServicePlan::findOrFail($serviceId);
        $price = $client->userType === 'Student' ? $service->rate_student : $service->rate_business;
        $totalAmount = $service->is_hourly ? $price * $hours : $price;
        
        $description = $service->name . ($service->is_hourly ? " ($hours hours)" : '');

        $stripeSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'zar',
                    'product_data' => [
                        'name' => $description,
                    ],
                    'unit_amount' => $totalAmount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&checkout_complete=true',
            'cancel_url' => url()->previous(),
            'customer_email' => $client->email,
            'metadata' => [
                'client_id' => $client->id,
                'service_id' => $service->id,
                'user_type' => $client->userType,
                'hours' => $hours
            ]
        ]);

        return redirect($stripeSession->url);
    }

    public function success(Request $request)
    {
        if (!$request->has('checkout_complete')) {
            return redirect('/');
        }

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripeSession = Session::retrieve($request->get('session_id'));

            if (isset($stripeSession->metadata->training_session_id)) {
                return $this->handleTrainingPaymentSuccess($stripeSession);
            }

            return redirect('/')->with('error', 'Invalid payment session');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error processing payment: ' . $e->getMessage());
        }
    }

    protected function handleTrainingPaymentSuccess($stripeSession)
    {
        try {
            $existingPending = Payment::where([
                'client_id' => $stripeSession->metadata->client_id,
                'payable_type' => 'training',
                'payable_id' => $stripeSession->metadata->training_session_id,
                'status' => 'pending'
            ])->first();

            if ($existingPending) {
                $existingPending->update([
                    'transaction_id' => $stripeSession->payment_intent,
                    'payment_method' => 'stripe',
                    'status' => 'completed',
                    'amount' => $stripeSession->amount_total / 100
                ]);

                $payment = $existingPending;
            } else {
                $payment = Payment::create([
                    'transaction_id' => $stripeSession->payment_intent,
                    'client_id' => $stripeSession->metadata->client_id,
                    'amount' => $stripeSession->amount_total / 100,
                    'payment_method' => 'stripe',
                    'status' => 'completed',
                    'payable_type' => 'training',
                    'payable_id' => $stripeSession->metadata->training_session_id
                ]);
            }

            // Update registration status
            TrainingRegistration::updateOrCreate(
                [
                    'session_id' => $stripeSession->metadata->training_session_id,
                    'client_id' => $stripeSession->metadata->client_id
                ],
                [
                    'payment_status' => 'completed',
                    'payment_id' => $payment->id
                ]
            );

            if ($payment->wasRecentlyCreated || $payment->wasChanged('status')) {
                $client = Client::find($stripeSession->metadata->client_id);
                $status = $payment->status === 'completed' ? 'success' : 'failed';
                // send mail
                $client->notify(new PaymentProcessed($payment, $status));
            }

            $trainingSession = TrainingSession::find($stripeSession->metadata->training_session_id);

            // Premium subscription handling
            if ($stripeSession->mode === 'subscription') {
                $client = Client::find($stripeSession->metadata->client_id);
                $client->update([
                    'subscription_type' => 'premium',
                    'subscription_expiry' => now()->addYear() // or add months based on your plan
                ]);
            }

            return response()->view('/success-payment', [
                'payment' => $payment,
                'trainingSession' => $trainingSession ?? null
            ]);

        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error processing payment: ' . $e->getMessage());

            

        }
    }

}