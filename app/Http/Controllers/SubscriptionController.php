<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Client;
use App\Models\TrainingType;
use Illuminate\Http\Request;
use App\Models\ServicePlan;
use App\Models\YocoPaymentAttempt;
use App\Models\Course;
use App\Models\ClientCourseSubscription;
use App\Notifications\PaymentProcessed;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:training_types,id',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $plan = TrainingType::findOrFail($request->plan_id);
        
        if ($plan->id == 7) { // Tech Teasers (free)
            return redirect()->route('subscription.subscribe.free');
        }

        // For Stripe 
        // return redirect()->route('stripe.checkout', [
        //     'clientId' => auth()->id(),
        //     'planId' => 'subscription_' . $plan->id
        // ]);

        // For Yoco payment links
        return $this->handleYocoPaymentWithPolling($plan, auth()->user());
    }

    protected function handleYocoPaymentWithPolling($plan, $client)
    {
        $price = $plan->getPriceForUserType($client->userType);
        
        // Create payment attempt record
        $paymentAttempt = \App\Models\YocoPaymentAttempt::create([
            'client_id' => $client->id,
            'plan_id' => $plan->id,
            'amount' => $price,
            'status' => 'pending',
            'metadata' => json_encode([
                'user_type' => $client->userType,
                'plan_name' => $plan->name
            ])
        ]);

        // Determine which payment link to use based on user type
        $paymentLink = $this->getPaymentLink($client->userType);
        
        // Add metadata to identify this payment
        $redirectUrl = $paymentLink . 
            '?metadata[client_id]=' . $client->id . 
            '&metadata[plan_id]=' . $plan->id . 
            '&metadata[payment_attempt_id]=' . $paymentAttempt->id .
            '&amount=' . ($price * 100) . // Yoco expects amount in cents
            '&redirectUrl=' . urlencode(route('yoco.payment.verify', ['attempt' => $paymentAttempt->id]));

        return redirect($redirectUrl);
    }

    public function redirectToYoco(Request $request)
    {
        $user = auth()->user();
        $premiumPlan = TrainingType::where('name', 'Premium')->firstOrFail();
        
        return $this->handleYocoPaymentWithPolling($premiumPlan, $user);
    }

    public function verifyPayment(Request $request, $attemptId)
    {
        $paymentAttempt = YocoPaymentAttempt::findOrFail($attemptId);
        $client = Client::findOrFail($paymentAttempt->client_id);
        $plan = TrainingType::findOrFail($paymentAttempt->plan_id);

        // Check if payment was already processed
        if ($paymentAttempt->status === 'completed') {
            return $this->showSuccessPage($client, $plan, $paymentAttempt->amount, $paymentAttempt->yoco_payment_id);
        }

        // Try to verify payment with Yoco API
        $verificationResult = $this->verifyYocoPayment($paymentAttempt);

        if ($verificationResult['status'] === 'completed') {
            // Payment was successful
            return $this->processSuccessfulPayment($paymentAttempt, $client, $plan, $verificationResult);
        } elseif ($verificationResult['status'] === 'pending') {
            // Payment is still pending, show waiting page
            return view('payment.pending', [
                'paymentAttempt' => $paymentAttempt,
                'plan' => $plan,
                'pollingUrl' => route('yoco.payment.status', ['attempt' => $paymentAttempt->id])
            ]);
        } else {
            // Payment failed
            return $this->processFailedPayment($paymentAttempt, $client, $plan);
        }
    }

    protected function verifyYocoPayment($paymentAttempt)
    {
        // If we have a Yoco payment ID, check its status via API
        if ($paymentAttempt->yoco_payment_id) {
            return $this->checkYocoPaymentStatus($paymentAttempt->yoco_payment_id);
        }

        // If no Yoco payment ID yet, check if we can find it
        // This would require storing additional data or using Yoco's API to search for payments
        return ['status' => 'pending'];
    }

    protected function checkYocoPaymentStatus($yocoPaymentId)
    {
        try {
            $secretKey = env('YOCO_SECRET_KEY');
            $response = Http::withBasicAuth($secretKey, '')
                ->get("https://api.yoco.com/v1/payments/{$yocoPaymentId}");

            if ($response->successful()) {
                $paymentData = $response->json();
                
                if ($paymentData['status'] === 'succeeded') {
                    return [
                        'status' => 'completed',
                        'amount' => $paymentData['amount'] / 100,
                        'currency' => $paymentData['currency'],
                        'payment_method' => $paymentData['paymentMethod'] ?? 'card'
                    ];
                } elseif ($paymentData['status'] === 'pending') {
                    return ['status' => 'pending'];
                } else {
                    return ['status' => 'failed'];
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error checking Yoco payment status: ' . $e->getMessage());
        }

        return ['status' => 'pending'];
    }

    protected function processSuccessfulPayment($paymentAttempt, $client, $plan, $paymentData)
    {
        // Update payment attempt
        $paymentAttempt->update([
            'status' => 'completed',
            'yoco_payment_id' => $paymentData['id'] ?? $paymentAttempt->yoco_payment_id
        ]);

        // Create payment record
        $payment = Payment::create([
            'transaction_id' => $paymentData['id'] ?? $paymentAttempt->yoco_payment_id,
            'client_id' => $client->id,
            'amount' => $paymentAttempt->amount,
            'payment_method' => $paymentData['payment_method'] ?? 'yoco',
            'status' => 'completed',
            'payable_type' => 'subscription',
            'payable_id' => $plan->id
        ]);

        // Update client subscription
        $client->update([
            'subscription_type' => strtolower($plan->name),
            'subscription_paid_at' => now(),
            'subscription_expiry' => now()->addQuarter()
        ]);

        // Update client course subscriptions
        $this->updateClientCourseSubscription($client, $plan);

        // Send notification
        $client->notify(new PaymentProcessed($payment, 'success'));

        return $this->showSuccessPage($client, $plan, $paymentAttempt->amount, $payment->transaction_id);
    }

    protected function processFailedPayment($paymentAttempt, $client, $plan)
    {
        $paymentAttempt->update(['status' => 'failed']);

        // Create failed payment record
        $payment = Payment::create([
            'transaction_id' => $paymentAttempt->yoco_payment_id,
            'client_id' => $client->id,
            'amount' => $paymentAttempt->amount,
            'payment_method' => 'yoco',
            'status' => 'failed',
            'payable_type' => 'subscription',
            'payable_id' => $plan->id
        ]);

        $client->notify(new PaymentProcessed($payment, 'failed'));

        return view('payment.failed', [
            'plan' => $plan,
            'paymentAttempt' => $paymentAttempt
        ]);
    }

    public function checkPaymentStatus(Request $request, $attemptId)
    {
        $paymentAttempt = YocoPaymentAttempt::findOrFail($attemptId);
        
        // Check payment status
        $verificationResult = $this->verifyYocoPayment($paymentAttempt);
        
        if ($verificationResult['status'] === 'completed') {
            $client = Client::findOrFail($paymentAttempt->client_id);
            $plan = TrainingType::findOrFail($paymentAttempt->plan_id);
            
            $this->processSuccessfulPayment($paymentAttempt, $client, $plan, $verificationResult);
            
            return response()->json([
                'status' => 'completed',
                'redirect' => route('yoco.payment.success', ['attempt' => $paymentAttempt->id])
            ]);
        } elseif ($verificationResult['status'] === 'failed') {
            $paymentAttempt->update(['status' => 'failed']);
            
            return response()->json([
                'status' => 'failed',
                'redirect' => route('yoco.payment.failed', ['attempt' => $paymentAttempt->id])
            ]);
        }
        
        // Still pending
        return response()->json(['status' => 'pending']);
    }

    protected function showSuccessPage($client, $plan, $amount, $transactionId)
    {
        return view('success-subscription', [
            'plan' => $plan,
            'payment_amount' => $amount,
            'transaction_id' => $transactionId
        ]);
    }

    protected function getPaymentLink($userType)
    {
        // Determine which payment link to use based on user type
        if (strtolower($userType) === 'student') {
            return 'https://pay.yoco.com/r/2BojJr';
        }
        
        return 'https://pay.yoco.com/r/2DeZrp';
    }

    protected function updateClientCourseSubscription($client, $plan)
    {
        // For premium subscription, update all premium course subscriptions
        if (strtolower($plan->name) === 'premium') {
            $premiumCourses = Course::where('plan_type', 'premium')->get();
            
            foreach ($premiumCourses as $course) {
                ClientCourseSubscription::updateOrCreate(
                    [
                        'client_id' => $client->id,
                        'course_id' => $course->id
                    ],
                    [
                        'payment_status' => 'paid',
                        'subscribed_at' => now(),
                        'updated_at' => now()
                    ]
                );
            }
        }
    }

    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:training_types,id',
        ]);

        $user = auth()->user();
        $plan = TrainingType::findOrFail($request->plan_id);

        // Don't allow unsubscribing from free plan
        if ($plan->id == 7) {
            return back()->with('error', 'Cannot unsubscribe from free plan');
        }

        // Remove payment records for this subscription
        Payment::where('client_id', $user->id)
            ->where('payable_type', 'subscription')
            ->where('payable_id', $plan->id)
            ->delete();

        // Update client's subscription status if this was their active subscription
        if ($user->subscription_type == strtolower($plan->name)) {
            $user->update([
                'subscription_type' => null,
                'subscription_paid_at' => null,
                'subscription_expiry' => null
            ]);
        }

        return back()->with('success', 'Successfully unsubscribed from ' . $plan->name);
    }


    public function subscribeFree()
    {
        $client = auth()->user();
        $client->update([
            'subscription_type' => 'free',
            'subscription_paid_at' => null,
            'subscription_expiry' => null
        ]);
        
        return redirect()->route('dashboard', ['section' => 'usr_alltrainings'])
            ->with('success', 'Free subscription activated!');
    }

    protected function handlePayment($plan, $client)
    {
        $price = $plan->getPriceForUserType($client->userType);
        
        $payment = Payment::create([
            'client_id' => $client->id,
            'amount' => $price,
            'payment_method' => 'pending',
            'payable_type' => 'subscription',
            'payable_id' => $plan->id,
            'status' => 'pending'
        ]);

        return redirect()->route('stripe.checkout', [
            'clientId' => $client->id,
            'planId' => 'subscription_' . $plan->id
        ]);
    }

    public function subscriptionSuccess(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionId = $request->get('session_id');
            $stripeSession = Session::retrieve($sessionId);

            $trainingType = TrainingType::findOrFail($stripeSession->metadata->training_type_id);
            $client = Client::findOrFail($stripeSession->metadata->client_id);

            // Create payment record
            $payment = Payment::create([
                'transaction_id' => $stripeSession->payment_intent,
                'client_id' => $client->id,
                'amount' => $stripeSession->amount_total / 100,
                'payment_method' => 'stripe',
                'status' => 'completed',
                'payable_type' => 'subscription',
                'payable_id' => $trainingType->id
            ]);

            // Update client's subscription status
            $client->update([
                'subscription_type' => strtolower($trainingType->name),
                'subscription_paid_at' => now(), 
                'subscription_expiry' => now()->addQuarter()
            ]);

            return view('success-subscription', [
                'plan' => $trainingType,
                'payment_amount' => $stripeSession->amount_total / 100,
                'transaction_id' => $stripeSession->payment_intent
            ]);

        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error processing payment: ' . $e->getMessage());
        }
    }

    public function yocoSuccess(Request $request)
    {
        // Handles the success redirect from Yoco
        $clientId = $request->get('client_id');
        $planId = $request->get('plan_id');
        $transactionId = $request->get('transaction_id');

        $client = Client::findOrFail($clientId);
        $plan = TrainingType::findOrFail($planId);

        // Show success page
        return view('success-subscription', [
            'plan' => $plan,
            'payment_amount' => $plan->getPriceForUserType($client->userType),
            'transaction_id' => $transactionId
        ]);
    }
}