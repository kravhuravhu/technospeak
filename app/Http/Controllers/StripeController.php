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
use App\Models\ServicePlan;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function checkout($clientId, $planId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Parse plan type and ID
        list($planType, $planDbId) = explode('_', $planId);
        
        $plan = ServicePlan::findOrFail($planDbId);
        $user = Auth::user();
        
        // Verify the requesting user matches the clientId
        if ($user->id !== $clientId) {
            abort(403, 'Unauthorized action.');
        }

        // Get the correct price based on user type
        $price = $user->userType === 'Student' ? $plan->rate_student : $plan->rate_business;
        
        // Create payment record
        $payment = Payment::create([
            'client_id' => $user->id,
            'amount' => $price,
            'payment_method' => 'stripe',
            'payable_type' => 'subscription',
            'payable_id' => $plan->id,
            'status' => 'pending'
        ]);

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'zar',
                        'product_data' => [
                            'name' => $plan->name,
                            'description' => $plan->description,
                        ],
                        'unit_amount' => $price * 100, // Convert to cents
                        'recurring' => $plan->is_subscription ? [
                            'interval' => 'month',
                            'interval_count' => 3 // Quarterly
                        ] : null,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => $plan->is_subscription ? 'subscription' : 'payment',
                'success_url' => route('stripe.subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url()->previous(),
                'client_reference_id' => $payment->id,
                'metadata' => [
                    'payment_id' => $payment->id,
                    'plan_id' => $plan->id,
                    'client_id' => $user->id
                ]
            ]);

            // Update payment with Stripe session ID
            $payment->update(['stripe_session_id' => $session->id]);

            return redirect($session->url);

        } catch (\Exception $e) {
            \Log::error('Stripe checkout error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error processing payment');
        }
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

        public function subscriptionSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            // Find and update payment
            $payment = Payment::find($session->client_reference_id);
            if ($payment) {
                $payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'transaction_id' => $session->payment_intent
                ]);

                // Update user subscription
                $user = Auth::user();
                $user->update([
                    'subscription_type' => 'premium',
                    'subscription_expiry' => now()->addMonths(3)
                ]);
                
                $plan = ServicePlan::find($payment->payable_id);
                return view('success-subscription', [
                    'payment' => $payment,
                    'plan' => $plan
                ]);
            }

            return redirect()->route('dashboard')->with('error', 'Payment record not found');

        } catch (\Exception $e) {
            \Log::error('Stripe success error: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Error verifying payment');
        }
    }

}