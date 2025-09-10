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
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public static function getSubscriptionStatus($client)
    {
        if (!$client->subscription_type) {
            return 'none';
        }
        
        if ($client->subscription_type === 'premium') {
            if ($client->subscription_expiry && $client->subscription_expiry->isFuture()) {
                return 'active';
            } else {
                return 'expired';
            }
        }
        
        return 'free';
    }

    public static function getAvailablePlans($client, $allTrainingTypes)
    {
        $subscriptionStatus = self::getSubscriptionStatus($client);
        
        return $allTrainingTypes->filter(function($plan) use ($client, $subscriptionStatus) {
            // Free plan is always available
            if ($plan->id == 7) {
                return true;
            }
            
            // Premium plan - only show if not already active
            if ($plan->id == 6) {
                return $subscriptionStatus !== 'active';
            }
            
            // Other plans are always available
            return true;
        });
    }

    public static function hasActiveSubscription($client, $plan)
    {
        // Check if user already has an active subscription for this plan
        if ($plan->id == 6 && $client->subscription_type === 'premium') {
            return $client->subscription_expiry && $client->subscription_expiry->isFuture();
        }
        
        return false;
    }

    public static function getPriceForUser($client, $plan)
    {
        if ($client->userType === 'Student') {
            return $plan->student_price;
        } elseif ($client->userType === 'Professional') {
            return $plan->professional_price;
        }
        
        // Default to professional price if user type not set
        return $plan->professional_price;
    }

    public function showSubscriptionForm()
    {
        $plan = TrainingType::where('name', 'Premium')->firstOrFail();
        $client = Auth::user();
        
        // Get price based on user type
        $price = self::getPriceForUser($client, $plan);
        
        return view('subscription.yoco-payment', compact('plan', 'price', 'client'));
    }

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

        // Show the Yoco payment form 
        return $this->showYocoPaymentForm($plan);
    }

    protected function showYocoPaymentForm($plan)
    {
        $client = Auth::user();
        $price = self::getPriceForUser($client, $plan);
        
        return view('subscription.yoco-payment', compact('plan', 'price', 'client'));
    }

    public function processYocoPayment(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:training_types,id',
            'token' => 'required|string',
        ]);

        $client = Auth::user();
        $plan = TrainingType::findOrFail($request->plan_id);
        
        // Check for existing active subscription
        if (self::hasActiveSubscription($client, $plan)) {
            return back()->with('error', 'You already have an active subscription. Your current subscription expires on ' . $client->subscription_expiry->format('M d, Y'));
        }
        
        // Check for pending payments for the same plan
        $pendingPayment = Payment::where('client_id', $client->id)
            ->where('payable_type', 'subscription')
            ->where('payable_id', $plan->id)
            ->where('status', 'pending')
            ->first();
            
        if ($pendingPayment) {
            return back()->with('error', 'You already have a pending payment for this subscription. Please wait for it to be processed.');
        }
        
        $amount = self::getPriceForUser($client, $plan);

        Log::info("Subscription payment attempt for client {$client->id}, plan {$plan->id}, amount R$amount, status pending");

        try {
            // Process payment with Yoco
            $response = Http::withHeaders([
                'X-Auth-Secret-Key' => env('YOCO_TEST_SECRET_KEY'),
            ])->post('https://online.yoco.com/v1/charges/', [
                'token' => $request->token,
                'amountInCents' => intval($amount * 100),
                'currency' => 'ZAR',
            ]);

            $data = $response->json();

            if (isset($data['error'])) {
                Log::error("Yoco error for client {$client->id}: " . $data['error']['message']);
                return back()->with('error', $data['error']['message']);
            }

            // Create payment record after successful charge
            $payment = Payment::create([
                'transaction_id' => $data['id'],
                'client_id' => $client->id,
                'amount' => $amount,
                'payment_method' => 'card',
                'status' => $data['status'] === 'successful' ? 'completed' : 'failed',
                'payable_type' => 'subscription',
                'payable_id' => $plan->id,
                'metadata' => json_encode([
                    'user_type' => $client->userType,
                    'plan_name' => $plan->name,
                    'payment_processor' => 'yoco',
                    'yoco_response' => $data,
                    'calculated_price' => $amount
                ])
            ]);

            if ($payment->status === 'completed') {
                // Update client subscription with proper expiry
                $client->update([
                    'subscription_type' => strtolower($plan->name),
                    'subscription_paid_at' => now(),
                    'subscription_expiry' => now()->addQuarter(), // 3 months
                    'updated_at' => now()
                ]);

                // Update client course subscriptions
                $this->updateClientCourseSubscription($client, $plan);

                Log::info("Subscription payment successful for client {$client->id}, transaction {$payment->transaction_id}");

                return redirect()->route('yoco.payment.success', ['payment' => $payment->id])
                    ->with('success', 'Payment successful! Your subscription is now active.');
            } else {
                Log::warning("Subscription payment failed for client {$client->id}");
                return redirect()->route('yoco.payment.failed', ['payment' => $payment->id])
                    ->with('error', 'Payment failed. Please try again.');
            }

        } catch (\Exception $e) {
            Log::error("Subscription payment failed for client {$client->id}: " . $e->getMessage());
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function redirectToYoco(Request $request)
    {
        $user = Auth::user();
        $plan = TrainingType::where('name', 'Premium')->firstOrFail();
        
        return $this->showYocoPaymentForm($plan);
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

        return view('success-payment', [
            'plan' => $plan,
            'payment' => $payment,
            'client' => $client
        ]);
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
        $price = self::getPriceForUser($client, $plan);
        
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
            'payment_amount' => self::getPriceForUser($client, $plan),
            'transaction_id' => $transactionId
        ]);
    }
}