<?php

namespace App\Http\Controllers;

use App\Models\TrainingRegistration;
use App\Models\TrainingSession;
use App\Models\Payment;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Http;
use App\Notifications\PaymentProcessed;
use App\Models\TrainingType;

class TrainingRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $session = TrainingSession::with('type')->find($validated['session_id']);
        $client = auth()->user();

        // Check if session is available
        if (!$session || $session->scheduled_for < now()) {
            return back()->with('error', 'This session is no longer available for registration.');
        }

        if ($session->isFull()) {
            return back()->with('error', 'This session is already full.');
        }

        // Check if user already paid for this session
        if ($this->hasDuplicateTrainingPayment($client, $session->id)) {
            $errorMessage = $this->getDuplicateTrainingPaymentMessage($session->id);
            return back()->with('error', $errorMessage);
        }

        // Create or update registration with pending status
        $registration = TrainingRegistration::updateOrCreate(
            [
                'session_id' => $validated['session_id'],
                'client_id' => $client->id,
            ],
            [
                'phone' => $validated['phone'],
                'payment_status' => 'pending',
            ]
        );

        // REDIRECT TO YOUR EXISTING PAYMENT FORM - FIXED
        return $this->showYocoTrainingPaymentForm($session, $client);
    }

    public function showTrainingSelection()
    {
        // Get all available training sessions that are in the future
        $trainingSessions = TrainingSession::with('type')
            ->where('scheduled_for', '>=', now())
            ->orderBy('scheduled_for')
            ->get();
        
        // Get all training types for filtering
        $trainingTypes = TrainingType::whereIn('id', [1, 2, 3, 4, 5])->get();
        
        return view('training.selection', compact('trainingSessions', 'trainingTypes'));
    }

    protected function showYocoTrainingPaymentForm(TrainingSession $session, Client $client)
    {
        $price = $session->type->getPriceForUserType($client->userType);
        
        return view('training.yoco-payment', compact('session', 'price', 'client'));
    }

    public function processYocoTrainingPayment(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
            'token' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        $client = Auth::user();
        $session = TrainingSession::with('type')->findOrFail($request->session_id);

        // Check if session is in the past
        if ($session->scheduled_for < now()) {
            return back()->with('error', 'This session is no longer available for registration.');
        }

        // Check if session is full
        if ($session->isFull()) {
            return back()->with('error', 'This session is already full.');
        }

        // Check for duplicate payment for this specific session
        if ($this->hasDuplicateTrainingPayment($client, $session->id)) {
            $errorMessage = $this->getDuplicateTrainingPaymentMessage($session->id);
            
            // Log the duplicate payment attempt
            Log::warning("Duplicate payment attempt prevented", [
                'client_id' => $client->id,
                'session_id' => $session->id,
                'type_id' => $session->type_id,
                'message' => $errorMessage
            ]);
            
            return back()->with('error', $errorMessage);
        }

        $amount = $session->type->getPriceForUserType($client->userType);

        Log::info("Training payment attempt for client {$client->id}, session {$session->id}, amount R$amount, status pending");

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
                'payable_type' => 'training',
                'payable_id' => $session->id,
                'metadata' => json_encode([
                    'user_type' => $client->userType,
                    'session_title' => $session->title,
                    'payment_processor' => 'yoco',
                    'yoco_response' => $data
                ])
            ]);

            if ($payment->status === 'completed') {
                // Update training registration
                $registration = TrainingRegistration::updateOrCreate(
                    [
                        'session_id' => $session->id,
                        'client_id' => $client->id,
                    ],
                    [
                        'phone' => $request->phone,
                        'payment_status' => 'completed',
                        'payment_id' => $payment->id,
                    ]
                );

                // Send notification
                $client->notify(new PaymentProcessed($payment, 'success'));

                Log::info("Training payment successful for client {$client->id}, transaction {$payment->transaction_id}");

                return redirect()->route('yoco.training.success', ['payment' => $payment->id])
                    ->with('success', 'Payment successful! You are now registered for the session.');
            } else {
                Log::warning("Training payment failed for client {$client->id}");
                return redirect()->route('training.payment.failed', ['payment' => $payment->id])
                    ->with('error', 'Payment failed. Please try again.');
            }

        } catch (\Exception $e) {
            Log::error("Training payment failed for client {$client->id}: " . $e->getMessage());
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }


public function hasDuplicateTrainingPayment($client, $sessionId)
{
    $session = TrainingSession::find($sessionId);
    if (!$session) return false;

    // Check if user has already paid for this specific session
    $existingPayment = Payment::where([
            'client_id' => $client->id,
            'payable_type' => 'training',
            'payable_id' => $sessionId,
            'status' => 'completed'
        ])->exists();

    // If payment exists, check if the session is still in the future
    if ($existingPayment) {
        return $session->scheduled_for >= now();
    }

    return false;
}

    public function showRegistrationForm($sessionId)
    {
        $session = TrainingSession::with('type')->findOrFail($sessionId);
        $client = auth()->user();
        
        // Check if session is in the past
        if ($session->scheduled_for < now()) {
            return back()->with('error', 'This session is no longer available for registration.');
        }
        
        // Check if session is full
        if ($session->isFull()) {
            return back()->with('error', 'This session is already full.');
        }
        
        // Check if user already paid for this specific session - PREVENT ACCESS
        if ($this->hasDuplicateTrainingPayment($client, $session->id)) {
            $errorMessage = $this->getDuplicateTrainingPaymentMessage($session->id);
            return redirect()->route('training.register')->with('error', $errorMessage);
        }
        
        $price = $session->type->getPriceForUserType($client->userType);
        
        return view('training.register-form', compact('session', 'price', 'client'));
    }

    public function getDuplicateTrainingPaymentMessage($sessionId)
    {
        $session = TrainingSession::find($sessionId);
        $typeName = $session->type->name ?? 'this training session';
        
        // Get the user's existing payment for this session
        $client = Auth::user();
        
        $existingPayment = Payment::where([
            'client_id' => $client->id,
            'payable_type' => 'training',
            'payable_id' => $sessionId,
            'status' => 'completed'
        ])->first();
        
        $message = "You have already paid for {$typeName}: '{$session->title}'. ";
        
        if ($existingPayment) {
            $message .= "Your payment was processed on " . 
                    $existingPayment->created_at->format('M d, Y') . ". " .
                    "Duplicate payments for the same session are not allowed.";
        } else {
            $message .= "Duplicate payments are not allowed.";
        }
        
        return $message;
    }

    public function registrations(TrainingSession $training)
    {
        $registrations = $training->registrations()
            ->with('client')
            ->latest()
            ->paginate(10);

        return view('content-manager.trainings.registrations', compact('training', 'registrations'));
    }

    protected function handlePayment(TrainingSession $session, Client $client)
    {
        $existingPayment = Payment::where([
            'client_id' => $client->id,
            'payable_type' => 'training',
            'payable_id' => $session->id,
            'status' => 'completed'
        ])->exists();

        if ($existingPayment) {
            return back()->with('success', 'You have already paid for this session!');
        }

        $payment = Payment::create([
            'client_id' => $client->id,
            'amount' => $session->type->getPriceForUserType($client->userType),
            'payment_method' => 'yoco',
            'payable_type' => 'training',
            'payable_id' => $session->id,
            'status' => 'pending',
            'metadata' => json_encode([
                'user_type' => $client->userType,
                'session_title' => $session->title,
                'payment_processor' => 'yoco'
            ])
        ]);

        TrainingRegistration::where([
            'client_id' => $client->id,
            'session_id' => $session->id
        ])->update([
            'payment_id' => $payment->id,
        ]);

        // Get the appropriate Yoco payment link based on session type and user type
        $yocoPaymentLink = $this->getYocoPaymentLink($session->type_id, $client->userType);
        
        // Build URL with proper redirect parameters
        $successUrl = route('yoco.training.verify', ['payment' => $payment->id]);
        $cancelUrl = route('yoco.training.cancel', ['payment' => $payment->id]);
        
        $yocoUrl = $yocoPaymentLink . 
            '?metadata[payment_id]=' . $payment->id . 
            '&metadata[client_id]=' . $client->id . 
            '&metadata[session_id]=' . $session->id .
            '&amount=' . ($session->type->getPriceForUserType($client->userType) * 100) . // Yoco expects amount in cents
            '&redirectUrl=' . urlencode($successUrl) .
            '&cancelUrl=' . urlencode($cancelUrl);

        Log::info('Yoco training payment initiated', [
            'payment_id' => $payment->id,
            'client_id' => $client->id,
            'session_id' => $session->id,
            'amount' => $session->type->getPriceForUserType($client->userType),
            'yoco_url' => $yocoUrl
        ]);

        return redirect($yocoUrl);

        // return redirect()->route('stripe.checkout', [
        //     'clientId' => $client->id,
        //     'planId' => 'training_' . $session->id
        // ]);
    }

    public static function hasPaidForSession($clientId, $sessionId)
    {
        return Payment::where([
            'client_id' => $clientId,
            'payable_type' => 'training',
            'payable_id' => $sessionId,
            'status' => 'completed'
        ])->exists();
    }
    protected function processTrainingPayment(Payment $payment): void
    {
        $registration = TrainingRegistration::firstOrNew([
            'session_id' => $payment->payable_id,
            'client_id' => $payment->client_id,
        ]);

        $registration->fill([
            'name' => $payment->client->name,
            'email' => $payment->client->email,
            'payment_id' => $payment->id,
            'payment_status' => $payment->status,
        ])->save();
    }
    
    public function showTrainingPaymentFailed($paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $client = Auth::user();
            
            // Verify the payment belongs to the authenticated user
            if ($payment->client_id !== $client->id) {
                abort(403, 'Unauthorized');
            }
            
            // Get the training session details
            $session = TrainingSession::find($payment->payable_id);
            
            return view('training.payment-failed', [
                'payment' => $payment,
                'session' => $session,
                'client' => $client
            ]);
        } catch (\Exception $e) {
            Log::error("Error loading training payment failed page: " . $e->getMessage());
            return redirect()->route('training.register')
                ->with('error', 'Payment failed. Please try again.');
        }
    }

    public function processYocoEftPayment(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
            'phone' => 'nullable|string',
        ]);

        $client = Auth::user();
        $session = TrainingSession::with('type')->findOrFail($request->session_id);

        // Check if session is in the past
        if ($session->scheduled_for < now()) {
            return back()->with('error', 'This session is no longer available for registration.');
        }

        // Check if session is full
        if ($session->isFull()) {
            return back()->with('error', 'This session is already full.');
        }

        // Check for duplicate payment
        if ($this->hasDuplicateTrainingPayment($client, $session->id)) {
            $errorMessage = $this->getDuplicateTrainingPaymentMessage($session->id);
            
            Log::warning("Duplicate training EFT payment attempt prevented", [
                'client_id' => $client->id,
                'session_id' => $session->id,
                'message' => $errorMessage
            ]);
            
            return back()->with('error', $errorMessage);
        }

        $amount = $session->type->getPriceForUserType($client->userType);

        Log::info("Training EFT payment attempt for client {$client->id}, session {$session->id}, amount R$amount, status pending");

        try {
            // Create EFT checkout with Yoco payments API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('YOCO_TEST_SECRET_KEY'),
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])->post('https://payments.yoco.com/api/checkouts', [
                'amount' => intval($amount * 100),
                'currency' => 'ZAR',
                'successUrl' => route('training.yoco.eft.success', ['session_id' => $session->id, 'client_id' => $client->id]),
                'cancelUrl' => route('training.yoco.eft.cancel'),
                'paymentMethods' => ['eft'],
                'processingMode' => 'test',
                'customer' => [
                    'email' => $client->email,
                    'name'  => $client->name,
                ],
                'metadata' => [
                    'session_id' => $session->id,
                    'client_id' => $client->id,
                    'session_title' => $session->title,
                    'user_type' => $client->userType
                ]
            ]);

            $data = $response->json();
            Log::info('Yoco EFT checkout response for training: ', $data);

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
                'payable_type' => 'training',
                'payable_id' => $session->id,
                'metadata' => json_encode([
                    'user_type' => $client->userType,
                    'session_title' => $session->title,
                    'payment_processor' => 'yoco',
                    'yoco_response' => $data,
                    'calculated_price' => $amount,
                    'payment_type' => 'eft',
                    'checkout_id' => $data['id'],
                    'redirect_url' => $data['redirectUrl'],
                    'phone' => $request->phone
                ])
            ]);

            Log::info("EFT payment initiated for training session {$session->id}, client {$client->id}, checkout ID: {$data['id']}");

            // Redirect to Yoco EFT payment page
            return redirect()->away($data['redirectUrl']);

        } catch (\Exception $e) {
            Log::error("Training EFT payment failed for client {$client->id}: " . $e->getMessage());
            return back()->with('error', 'EFT payment failed: ' . $e->getMessage());
        }
    }

    public function handleEftSuccess(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
            'client_id' => 'required|exists:clients,id',
            'checkoutId' => 'nullable|string',
        ]);

        $client = Client::findOrFail($request->client_id);
        $session = TrainingSession::findOrFail($request->session_id);

        try {
            // Find the pending payment
            $payment = Payment::where('client_id', $client->id)
                ->where('payable_type', 'training')
                ->where('payable_id', $session->id)
                ->where('status', 'pending')
                ->where('payment_method', 'eft')
                ->latest()
                ->first();

            if (!$payment) {
                Log::error("No pending EFT payment found for client {$client->id}, session {$session->id}");
                return redirect()->route('training.register.form', $session)
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

                // Update training registration
                $metadata = json_decode($payment->metadata, true);
                $registration = TrainingRegistration::updateOrCreate(
                    [
                        'session_id' => $session->id,
                        'client_id' => $client->id,
                    ],
                    [
                        'phone' => $metadata['phone'] ?? null,
                        'payment_status' => 'completed',
                        'payment_id' => $payment->id,
                    ]
                );

                // Send notification
                try {
                    $client->notify(new PaymentProcessed($payment, 'success'));
                } catch (\Exception $e) {
                    Log::error("Failed to send EFT payment notification: " . $e->getMessage());
                }

                Log::info("EFT training payment successful for client {$client->id}, transaction {$payment->transaction_id}");

                return redirect()->route('yoco.training.success', ['payment' => $payment->id])
                    ->with('success', 'EFT payment successful! You are now registered for the session.');

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
                    return view('training.payment-pending', [
                        'payment' => $payment,
                        'client' => $client,
                        'session' => $session,
                        'pollingUrl' => route('training.yoco.eft.status', ['payment' => $payment->id])
                    ]);
                } else {
                    return redirect()->route('training.payment.failed', ['payment' => $payment->id])
                        ->with('error', 'EFT payment verification failed.');
                }
            }

        } catch (\Exception $e) {
            Log::error("EFT success callback error for training: " . $e->getMessage());
            return redirect()->route('training.register.form', $session)
                ->with('error', 'Error processing EFT payment: ' . $e->getMessage());
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
            $session = TrainingSession::find($payment->payable_id);
            
            // Update training registration
            $metadata = json_decode($payment->metadata, true);
            TrainingRegistration::updateOrCreate(
                [
                    'session_id' => $session->id,
                    'client_id' => $client->id,
                ],
                [
                    'phone' => $metadata['phone'] ?? null,
                    'payment_status' => 'completed',
                    'payment_id' => $payment->id,
                ]
            );

            try {
                $client->notify(new PaymentProcessed($payment, 'success'));
            } catch (\Exception $e) {
                Log::error("Failed to send EFT payment notification: " . $e->getMessage());
            }

            return response()->json([
                'status' => 'completed',
                'redirect' => route('yoco.training.success', ['payment' => $payment->id])
            ]);

        } elseif ($verificationResult['status'] === 'failed') {
            $payment->update(['status' => 'failed']);
            return response()->json([
                'status' => 'failed',
                'redirect' => route('training.payment.failed', ['payment' => $payment->id])
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
            ->where('payable_type', 'training')
            ->update(['status' => 'cancelled']);

        Log::info("EFT payment cancelled by client {$client->id} for training");

        return redirect()->route('training.register')
            ->with('error', 'EFT payment was cancelled. You can try again anytime.');
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
}