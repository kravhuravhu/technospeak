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
use Illuminate\Support\Facades\Log;

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

    protected function handleYocoPayment($plan, $client)
    {
        $price = $plan->getPriceForUserType($client->userType);
        
        // Create payment record in the main payments table
        $payment = Payment::create([
            'client_id' => $client->id,
            'amount' => $price,
            'payment_method' => 'yoco',
            'status' => 'pending',
            'payable_type' => 'subscription',
            'payable_id' => $plan->id,
            'metadata' => json_encode([
                'user_type' => $client->userType,
                'plan_name' => $plan->name,
                'payment_processor' => 'yoco'
            ])
        ]);

        $paymentLink = $this->getPaymentLink($client->userType);
        
        // Build URL with proper redirect parameters
        $successUrl = route('yoco.payment.verify', ['payment' => $payment->id]);
        $cancelUrl = route('yoco.payment.cancel', ['payment' => $payment->id]);
        
        $yocoUrl = $paymentLink . 
            '?metadata[payment_id]=' . $payment->id . 
            '&metadata[client_id]=' . $client->id . 
            '&metadata[plan_id]=' . $plan->id .
            '&amount=' . ($price * 100) . // Yoco expects amount in cents
            '&redirectUrl=' . urlencode($successUrl) .
            '&cancelUrl=' . urlencode($cancelUrl);

        Log::info('Yoco payment initiated', [
            'payment_id' => $payment->id,
            'client_id' => $client->id,
            'plan_id' => $plan->id,
            'amount' => $price,
            'yoco_url' => $yocoUrl
        ]);

        return redirect($yocoUrl);
    }

    public function redirectToYoco(Request $request)
    {
        $user = auth()->user();
        $premiumPlan = TrainingType::where('name', 'Premium')->firstOrFail();
        
        return $this->handleYocoPayment($premiumPlan, $user);
    }

    public function verifyPayment(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        // Check if payment was already processed
        if ($payment->status === 'completed') {
            return $this->showSuccessPage($payment);
        }

        // Check payment status via Yoco API
        $verificationResult = $this->verifyYocoPayment($payment);

        if ($verificationResult['status'] === 'completed') {
            return $this->processSuccessfulPayment($payment, $verificationResult);
        } elseif ($verificationResult['status'] === 'pending') {
            return view('payment.pending', [
                'payment' => $payment,
                'pollingUrl' => route('yoco.payment.status', ['payment' => $payment->id])
            ]);
        } else {
            return $this->processFailedPayment($payment);
        }
    }

    protected function verifyYocoPayment($payment)
    {
        // Check if we have a Yoco transaction ID
        if ($payment->transaction_id) {
            return $this->checkYocoPaymentStatus($payment->transaction_id);
        }

        // If no transaction ID yet, payment is still pending
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
                        'yoco_payment_id' => $yocoPaymentId,
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
            Log::error('Error checking Yoco payment status: ' . $e->getMessage());
        }

        return ['status' => 'pending'];
    }

    protected function processSuccessfulPayment($payment, $paymentData)
    {
        $client = Client::findOrFail($payment->client_id);
        $plan = TrainingType::findOrFail($payment->payable_id);

        // Update payment record
        $payment->update([
            'transaction_id' => $paymentData['yoco_payment_id'] ?? null,
            'status' => 'completed',
            'metadata' => json_encode(array_merge(
                json_decode($payment->metadata, true) ?? [],
                [
                    'processed_at' => now()->toDateTimeString(),
                    'yoco_response' => $paymentData
                ]
            ))
        ]);

        // Update client subscription
        $client->update([
            'subscription_type' => strtolower($plan->name),
            'subscription_paid_at' => now(),
            'subscription_expiry' => now()->addQuarter(),
            'updated_at' => now()
        ]);

        // Update client course subscriptions
        $this->updateClientCourseSubscription($client, $plan);

        // Send notification
        $client->notify(new PaymentProcessed($payment, 'success'));

        Log::info('Yoco payment completed successfully', [
            'payment_id' => $payment->id,
            'client_id' => $client->id,
            'transaction_id' => $payment->transaction_id
        ]);

        return $this->showSuccessPage($payment);
    }

    protected function processFailedPayment($payment)
    {
        $payment->update([
            'status' => 'failed',
            'metadata' => json_encode(array_merge(
                json_decode($payment->metadata, true) ?? [],
                ['failed_at' => now()->toDateTimeString()]
            ))
        ]);

        $client = Client::findOrFail($payment->client_id);
        $client->notify(new PaymentProcessed($payment, 'failed'));

        Log::warning('Yoco payment failed', ['payment_id' => $payment->id]);

        return view('payment.failed', [
            'payment' => $payment
        ]);
    }

    public function checkPaymentStatus(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        $verificationResult = $this->verifyYocoPayment($payment);
        
        if ($verificationResult['status'] === 'completed') {
            $this->processSuccessfulPayment($payment, $verificationResult);
            
            return response()->json([
                'status' => 'completed',
                'redirect' => route('yoco.payment.success', ['payment' => $payment->id])
            ]);
        } elseif ($verificationResult['status'] === 'failed') {
            $this->processFailedPayment($payment);
            
            return response()->json([
                'status' => 'failed',
                'redirect' => route('yoco.payment.failed', ['payment' => $payment->id])
            ]);
        }
        
        return response()->json(['status' => 'pending']);
    }

    protected function showSuccessPage($payment)
    {
        $client = Client::findOrFail($payment->client_id);
        $plan = TrainingType::findOrFail($payment->payable_id);

        return view('success-subscription', [
            'plan' => $plan,
            'payment_amount' => $payment->amount,
            'transaction_id' => $payment->transaction_id,
            'client' => $client
        ]);
    }

    protected function getPaymentLink($userType)
    {
        if (strtolower($userType) === 'student') {
            return 'https://pay.yoco.com/r/2BojJr';
        }
        
        return 'https://pay.yoco.com/r/2DeZrp';
    }

    protected function updateClientCourseSubscription($client, $plan)
    {
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