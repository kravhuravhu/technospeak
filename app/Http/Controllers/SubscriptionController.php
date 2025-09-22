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

    public static function getAvailablePlans($user, $allTrainingTypes)
    {
        $availablePlans = collect();
        
        foreach ($allTrainingTypes as $plan) {
            // Skip free plan (ID 7) as it should never be in available plans
            if ($plan->id == 7) {
                continue;
            }
            
            // For premium plan (ID 6), only show if user doesn't have active premium
            if ($plan->id == 6) {
                if ($user->subscription_type !== 'premium') {
                    $availablePlans->push($plan);
                }
                continue;
            }
            
            // For other plans, use existing logic
            $availablePlans->push($plan);
        }
        
        return $availablePlans;
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
        
        // Check for duplicate subscription
        if ($this->hasDuplicateSubscriptionPayment($client, $plan->id)) {
            $errorMessage = $this->getDuplicateSubscriptionPaymentMessage($client, $plan->id);
            return redirect()->route('dashboard')->with('error', $errorMessage);
        }
        
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
        
        // Enhanced duplicate payment check
        if ($this->hasDuplicateSubscriptionPayment($client, $plan->id)) {
            $errorMessage = $this->getDuplicateSubscriptionPaymentMessage($client, $plan->id);
            
            Log::warning("Duplicate subscription payment attempt prevented", [
                'client_id' => $client->id,
                'plan_id' => $plan->id,
                'message' => $errorMessage
            ]);
            
            return back()->with('error', $errorMessage);
        }
        
        $amount = self::getPriceForUser($client, $plan);

        Log::info("Subscription card payment attempt for client {$client->id}, plan {$plan->id}, amount R$amount, status pending");

        try {
            // Process card payment with Yoco charges API
            $response = Http::withHeaders([
                'X-Auth-Secret-Key' => env('YOCO_TEST_SECRET_KEY'),
            ])->post('https://online.yoco.com/v1/charges/', [
                'token' => $request->token,
                'amountInCents' => intval($amount * 100),
                'currency' => 'ZAR',
            ]);

            Log::debug('Yoco Card API Response:', [
                'response' => $response->json(),
                'status_code' => $response->status(),
                'client_id' => $client->id,
                'plan_id' => $plan->id
            ]);

            if (!$response->successful()) {
                Log::error("Yoco API request failed", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'client_id' => $client->id
                ]);
                
                return back()->with('error', 'Payment service temporarily unavailable. Please try again.');
            }

            $data = $response->json();

            if (isset($data['error'])) {
                Log::error("Yoco error for client {$client->id}: " . $data['error']['message']);
                return back()->with('error', $data['error']['message']);
            }

            if (!isset($data['id']) || !isset($data['status'])) {
                Log::error("Yoco response missing required fields", [
                    'response' => $data,
                    'client_id' => $client->id
                ]);
                return back()->with('error', 'Payment processing error: Invalid response format.');
            }

            // Create payment record
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
                    'calculated_price' => $amount,
                    'payment_type' => 'card'
                ])
            ]);

            return $this->handlePaymentResult($payment, $client, $plan);

        } catch (\Exception $e) {
            Log::error("Subscription card payment failed for client {$client->id}: " . $e->getMessage());
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function processYocoEftPayment(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:training_types,id',
        ]);

        $client = Auth::user();
        $plan = TrainingType::findOrFail($request->plan_id);
        
        // Enhanced duplicate payment check
        if ($this->hasDuplicateSubscriptionPayment($client, $plan->id)) {
            $errorMessage = $this->getDuplicateSubscriptionPaymentMessage($client, $plan->id);
            
            Log::warning("Duplicate subscription EFT payment attempt prevented", [
                'client_id' => $client->id,
                'plan_id' => $plan->id,
                'message' => $errorMessage
            ]);
            
            return back()->with('error', $errorMessage);
        }
        
        $amount = self::getPriceForUser($client, $plan);

        Log::info("Subscription EFT payment attempt for client {$client->id}, plan {$plan->id}, amount R$amount, status pending");

        try {
            // Create EFT checkout with Yoco payments API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('YOCO_TEST_SECRET_KEY'),
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])->post('https://payments.yoco.com/api/checkouts', [
                'amount' => intval($amount * 100),
                'currency' => 'ZAR',
                'successUrl' => route('subscription.yoco.eft.success', ['plan_id' => $plan->id, 'client_id' => $client->id]),
                'cancelUrl' => route('subscription.yoco.eft.cancel'),
                'paymentMethods' => ['eft'],
                'processingMode' => 'test',
                'customer' => [
                    'email' => $client->email,
                    'name'  => $client->name,
                ],
                'metadata' => [
                    'plan_id' => $plan->id,
                    'client_id' => $client->id,
                    'plan_name' => $plan->name,
                    'user_type' => $client->userType
                ]
            ]);

            $data = $response->json();
            Log::info('Yoco EFT checkout response: ', $data);

            if (!isset($data['redirectUrl'])) {
                Log::error("Yoco EFT checkout failed - no redirect URL", [
                    'response' => $data,
                    'client_id' => $client->id
                ]);
                return back()->with('error', 'Failed to create EFT payment link. Please try again.');
            }

            // Create pending payment record
            $payment = Payment::create([
                'transaction_id' => $data['id'] ?? 'pending_' . uniqid(),
                'client_id' => $client->id,
                'amount' => $amount,
                'payment_method' => 'eft',
                'status' => 'pending',
                'payable_type' => 'subscription',
                'payable_id' => $plan->id,
                'metadata' => json_encode([
                    'user_type' => $client->userType,
                    'plan_name' => $plan->name,
                    'payment_processor' => 'yoco',
                    'yoco_response' => $data,
                    'calculated_price' => $amount,
                    'payment_type' => 'eft',
                    'checkout_id' => $data['id'],
                    'redirect_url' => $data['redirectUrl']
                ])
            ]);

            Log::info("EFT payment initiated for client {$client->id}, checkout ID: {$data['id']}");

            // Redirect to Yoco EFT payment page
            return redirect()->away($data['redirectUrl']);

        } catch (\Exception $e) {
            Log::error("Subscription EFT payment failed for client {$client->id}: " . $e->getMessage());
            return back()->with('error', 'EFT payment failed: ' . $e->getMessage());
        }
    }

    public function handleEftSuccess(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:training_types,id',
            'client_id' => 'required|exists:clients,id',
            'checkoutId' => 'nullable|string',
        ]);

        $client = Client::findOrFail($request->client_id);
        $plan = TrainingType::findOrFail($request->plan_id);

        try {
            // Find the pending payment
            $payment = Payment::where('client_id', $client->id)
                ->where('payable_type', 'subscription')
                ->where('payable_id', $plan->id)
                ->where('status', 'pending')
                ->where('payment_method', 'eft')
                ->latest()
                ->first();

            if (!$payment) {
                Log::error("No pending EFT payment found for client {$client->id}, plan {$plan->id}");
                return redirect()->route('subscription.form')
                    ->with('error', 'Payment record not found. Please contact support.');
            }

            // Verify payment status with Yoco
            $paymentStatus = $this->verifyYocoEftPayment($payment);

            if ($paymentStatus['status'] === 'completed') {
                // Update payment status to completed
                $payment->update([
                    'status' => 'completed',
                    'transaction_id' => $paymentStatus['transaction_id'] ?? $payment->transaction_id,
                    'metadata' => json_encode(array_merge(
                        json_decode($payment->metadata, true) ?? [],
                        [
                            'processed_at' => now()->toDateTimeString(),
                            'yoco_verification' => $paymentStatus
                        ]
                    ))
                ]);

                // Update client subscription
                $client->update([
                    'subscription_type' => strtolower($plan->name),
                    'subscription_paid_at' => now(),
                    'subscription_expiry' => now()->addQuarter(),
                ]);

                // Update client course subscriptions
                $this->updateClientCourseSubscription($client, $plan);

                // Send notification
                try {
                    $client->notify(new PaymentProcessed($payment, 'success'));
                } catch (\Exception $e) {
                    Log::error("Failed to send EFT payment notification: " . $e->getMessage());
                }

                Log::info("EFT subscription payment successful for client {$client->id}, transaction {$payment->transaction_id}");

                return $this->showSuccessPage($payment);

            } else {
                // Payment still pending or failed
                $payment->update([
                    'status' => $paymentStatus['status'],
                    'metadata' => json_encode(array_merge(
                        json_decode($payment->metadata, true) ?? [],
                        [
                            'verification_attempt' => now()->toDateTimeString(),
                            'verification_status' => $paymentStatus['status']
                        ]
                    ))
                ]);

                if ($paymentStatus['status'] === 'pending') {
                    return view('subscription.payment-pending', [
                        'payment' => $payment,
                        'client' => $client,
                        'plan' => $plan,
                        'pollingUrl' => route('subscription.yoco.eft.status', ['payment' => $payment->id])
                    ]);
                } else {
                    return redirect()->route('subscription.payment.failed', ['payment' => $payment->id])
                        ->with('error', 'EFT payment verification failed.');
                }
            }

        } catch (\Exception $e) {
            Log::error("EFT success callback error: " . $e->getMessage());
            return redirect()->route('subscription.form')
                ->with('error', 'Error processing EFT payment: ' . $e->getMessage());
        }
    }

    private function verifyYocoEftPayment($payment)
    {
        try {
            $metadata = json_decode($payment->metadata, true);
            $checkoutId = $metadata['checkout_id'] ?? null;

            if (!$checkoutId) {
                return ['status' => 'failed', 'error' => 'No checkout ID found'];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('YOCO_TEST_SECRET_KEY'),
                'Accept'        => 'application/json',
            ])->get("https://payments.yoco.com/api/checkouts/{$checkoutId}");

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'completed') {
                    return [
                        'status' => 'completed',
                        'transaction_id' => $data['id'],
                        'amount' => $data['amount'] / 100,
                        'currency' => $data['currency'],
                        'payment_method' => 'eft'
                    ];
                } elseif (in_array($data['status'], ['pending', 'processing'])) {
                    return ['status' => 'pending'];
                } else {
                    return ['status' => 'failed'];
                }
            }

            return ['status' => 'pending'];

        } catch (\Exception $e) {
            Log::error("Error verifying Yoco EFT payment: " . $e->getMessage());
            return ['status' => 'pending', 'error' => $e->getMessage()];
        }
    }

    public function checkEftPaymentStatus(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $client = Auth::user();

        // Verify the payment belongs to the authenticated user
        if ($payment->client_id !== $client->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $verificationResult = $this->verifyYocoEftPayment($payment);

        if ($verificationResult['status'] === 'completed') {
            // Process successful payment
            $payment->update(['status' => 'completed']);
            
            $client = Client::find($payment->client_id);
            $plan = TrainingType::find($payment->payable_id);
            
            $client->update([
                'subscription_type' => strtolower($plan->name),
                'subscription_paid_at' => now(),
                'subscription_expiry' => now()->addQuarter(),
            ]);

            $this->updateClientCourseSubscription($client, $plan);

            try {
                $client->notify(new PaymentProcessed($payment, 'success'));
            } catch (\Exception $e) {
                Log::error("Failed to send EFT payment notification: " . $e->getMessage());
            }

            return response()->json([
                'status' => 'completed',
                'redirect' => route('yoco.payment.success', ['payment' => $payment->id])
            ]);

        } elseif ($verificationResult['status'] === 'failed') {
            $payment->update(['status' => 'failed']);
            return response()->json([
                'status' => 'failed',
                'redirect' => route('subscription.payment.failed', ['payment' => $payment->id])
            ]);
        }

        return response()->json(['status' => 'pending']);
    }

    public function handleEftCancel(Request $request)
    {
        $client = Auth::user();
        
        // Find and update any pending EFT payments for this user
        Payment::where('client_id', $client->id)
            ->where('status', 'pending')
            ->where('payment_method', 'eft')
            ->update(['status' => 'cancelled']);

        Log::info("EFT payment cancelled by client {$client->id}");

        return redirect()->route('subscription.form')
            ->with('error', 'EFT payment was cancelled. You can try again anytime.');
    }

    private function handlePaymentResult($payment, $client, $plan)
    {
        if ($payment->status === 'completed') {
            // Update client subscription
            $client->update([
                'subscription_type' => strtolower($plan->name),
                'subscription_paid_at' => now(),
                'subscription_expiry' => now()->addQuarter(),
            ]);

            // Update client course subscriptions
            $this->updateClientCourseSubscription($client, $plan);

            // Send notification
            try {
                $client->notify(new PaymentProcessed($payment, 'success'));
            } catch (\Exception $e) {
                Log::error("Failed to send payment notification: " . $e->getMessage());
            }

            Log::info("Subscription payment successful for client {$client->id}, transaction {$payment->transaction_id}");

            return $this->showSuccessPage($payment);

        } else {
            Log::warning("Subscription payment failed for client {$client->id}");
            return redirect()->route('subscription.payment.failed', ['payment' => $payment->id])
                ->with('error', 'Payment failed. Please try again.');
        }
    }
    
    private function hasDuplicatePayment($client, $plan)
    {
        // For subscription plans (Premium), check active subscription
        if ($plan->id == 6) {
            if ($client->subscription_type === 'premium' && 
                $client->subscription_expiry && 
                $client->subscription_expiry->isFuture()) {
                return true;
            }
        }
        
        // For one-time purchase plans, check completed payments
        $existingPayment = Payment::where('client_id', $client->id)
            ->where('payable_type', 'subscription')
            ->where('payable_id', $plan->id)
            ->where('status', 'completed')
            ->exists();
            
        return $existingPayment;
    }

    private function getDuplicatePaymentMessage($client, $plan)
    {
        if ($plan->id == 6) {
            if ($client->subscription_type === 'premium' && 
                $client->subscription_expiry && 
                $client->subscription_expiry->isFuture()) {
                return 'You already have an active Premium subscription. Your current subscription expires on ' . 
                       $client->subscription_expiry->format('M d, Y');
            }
        }
        
        return 'You have already purchased this plan. Duplicate payments are not allowed.';
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

        // Update client subscription with ALL required fields
        $client->update([
            'subscription_type' => strtolower($plan->name),
            'subscription_paid_at' => now(),
            'subscription_expiry' => now()->addQuarter(),
            'updated_at' => now(),
            // Make sure other required fields are preserved
            'name' => $client->name,
            'surname' => $client->surname,
            'email' => $client->email,
            'userType' => $client->userType,
            'status' => $client->status
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
        try {
            $client = Client::findOrFail($payment->client_id);
            $plan = TrainingType::findOrFail($payment->payable_id);

            return view('success-subscription', [
                'plan' => $plan,
                'payment' => $payment,
                'client' => $client,
                'payment_amount' => $payment->amount,
                'transaction_id' => $payment->transaction_id
            ]);
        } catch (\Exception $e) {
            Log::error("Error showing success page: " . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('success', 'Payment successful! Your subscription is now active.');
        }
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
            
            // Also update the client's subscription details in the clients table
            $client->update([
                'subscription_type' => 'premium',
                'subscription_paid_at' => now(),
                'subscription_expiry' => now()->addQuarter(), // 3 months
                'updated_at' => now()
            ]);
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

    public function hasDuplicateSubscriptionPayment($client, $planId)
    {
        // For premium subscriptions, check if user already has an active subscription
        if ($planId == 6) { // Premium plan ID
            $subscriptionStatus = strtolower($client->subscription_type);
            return $subscriptionStatus === 'premium' && 
                $client->subscription_expiry && 
                $client->subscription_expiry->isFuture();
        }
        
        // For other subscription types, check completed payments
        return Payment::where([
            'client_id' => $client->id,
            'payable_type' => 'subscription',
            'payable_id' => $planId,
            'status' => 'completed'
        ])->exists();
    }

    public function getDuplicateSubscriptionPaymentMessage($client, $planId)
    {
        $plan = TrainingType::find($planId);
        $planName = $plan->name ?? 'this subscription';
        
        if ($planId == 6) {
            // Premium subscription specific message
            if ($client->subscription_type === 'premium' && 
                $client->subscription_expiry && 
                $client->subscription_expiry->isFuture()) {
                return "You already have an active {$planName} subscription. Your current subscription expires on " . 
                    $client->subscription_expiry->format('M d, Y') . ". " .
                    "Duplicate subscriptions are not allowed.";
            }
        }
        
        return "You have already purchased {$planName}. Duplicate payments are not allowed.";
    }

    public static function hasActiveSubscription($clientId, $planId)
    {
        $client = Client::find($clientId);
        if (!$client) return false;
        
        if ($planId == 6) {
            $subscriptionStatus = strtolower($client->subscription_type);
            return $subscriptionStatus === 'premium' && 
                $client->subscription_expiry && 
                $client->subscription_expiry->isFuture();
        }
        
        return Payment::where([
            'client_id' => $clientId,
            'payable_type' => 'subscription',
            'payable_id' => $planId,
            'status' => 'completed'
        ])->exists();
    }

    public function showPaymentFailed($paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $client = Auth::user();
            
            // Verify the payment belongs to the authenticated user
            if ($payment->client_id !== $client->id) {
                abort(403, 'Unauthorized');
            }
            
            return view('subscription.payment-failed', [
                'payment' => $payment,
                'client' => $client
            ]);
        } catch (\Exception $e) {
            Log::error("Error loading subscription payment failed page: " . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('error', 'Payment failed. Please try again.');
        }
    }
}