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

        if (!$session || $session->scheduled_for < now()) {
            return back()->with('error', 'This session is no longer available for registration.');
        }

        if ($session->isFull()) {
            return back()->with('error', 'This session is already full.');
        }

        $client = auth()->user();

        $registration = TrainingRegistration::firstOrCreate(
            [
                'session_id' => $validated['session_id'],
                'client_id' => $client->id ?? null,
            ],
            [
                'phone' => $validated['phone'],
                'payment_status' => 'pending',
            ]
        );

        // Show the Yoco payment form
        return $this->showYocoTrainingPaymentForm($session, $client);
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

        if ($session->scheduled_for < now()) {
            return back()->with('error', 'This session is no longer available for registration.');
        }

        if ($session->isFull()) {
            return back()->with('error', 'This session is already full.');
        }

        $amount = $session->type->getPriceForUserType($client->userType);

        Log::info("Training payment attempt for client {$client->id}, session {$session->id}, amount R$amount, status pending");

        try {
            // Create payment record first
            $payment = Payment::create([
                'client_id' => $client->id,
                'amount' => $amount,
                'payment_method' => 'card',
                'status' => 'pending',
                'payable_type' => 'training',
                'payable_id' => $session->id,
                'metadata' => json_encode([
                    'user_type' => $client->userType,
                    'session_title' => $session->title,
                    'payment_processor' => 'yoco'
                ])
            ]);

            // Process payment with Yoco
            $response = Http::withHeaders([
                'X-Auth-Secret-Key' => env('YOCO_SECRET_KEY'),
            ])->post('https://online.yoco.com/v1/charges/', [
                'token' => $request->token,
                'amountInCents' => intval($amount * 100),
                'currency' => 'ZAR',
            ]);

            $data = $response->json();

            if (isset($data['error'])) {
                Log::error("Yoco error for client {$client->id}: " . $data['error']['message']);
                
                // Update payment status to failed
                $payment->update([
                    'status' => 'failed',
                    'metadata' => json_encode(array_merge(
                        json_decode($payment->metadata, true) ?? [],
                        ['error' => $data['error']['message']]
                    ))
                ]);

                return back()->with('error', $data['error']['message']);
            }

            // Payment successful
            $payment->update([
                'transaction_id' => $data['id'],
                'status' => $data['status'] === 'successful' ? 'completed' : 'failed',
                'metadata' => json_encode(array_merge(
                    json_decode($payment->metadata, true) ?? [],
                    [
                        'yoco_response' => $data,
                        'processed_at' => now()->toDateTimeString()
                    ]
                ))
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
                return redirect()->route('yoco.training.failed', ['payment' => $payment->id])
                    ->with('error', 'Payment failed. Please try again.');
            }

        } catch (\Exception $e) {
            Log::error("Training payment failed for client {$client->id}: " . $e->getMessage());
            
            if (isset($payment)) {
                $payment->update([
                    'status' => 'failed',
                    'metadata' => json_encode(array_merge(
                        json_decode($payment->metadata, true) ?? [],
                        ['exception' => $e->getMessage()]
                    ))
                ]);
            }

            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    // Keep the existing verification and status check methods
    public function verifyTrainingPayment(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        // Check if payment was already processed
        if ($payment->status === 'completed') {
            return $this->showTrainingSuccessPage($payment);
        }

        // Check payment status via Yoco API
        $verificationResult = $this->verifyYocoPayment($payment);

        if ($verificationResult['status'] === 'completed') {
            return $this->processSuccessfulTrainingPayment($payment, $verificationResult);
        } elseif ($verificationResult['status'] === 'pending') {
            return view('payment.pending', [
                'payment' => $payment,
                'pollingUrl' => route('yoco.training.status', ['payment' => $payment->id])
            ]);
        } else {
            return $this->processFailedTrainingPayment($payment);
        }
    }

    protected function processSuccessfulTrainingPayment($payment, $paymentData)
    {
        $client = Client::findOrFail($payment->client_id);
        $session = TrainingSession::findOrFail($payment->payable_id);

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

        // Update training registration
        $registration = TrainingRegistration::where([
            'client_id' => $client->id,
            'session_id' => $session->id
        ])->first();

        if ($registration) {
            $registration->update([
                'payment_status' => 'completed',
                'payment_id' => $payment->id
            ]);
        }

        // Send notification
        $client->notify(new PaymentProcessed($payment, 'success'));

        Log::info('Yoco training payment completed successfully', [
            'payment_id' => $payment->id,
            'client_id' => $client->id,
            'session_id' => $session->id,
            'transaction_id' => $payment->transaction_id
        ]);

        return $this->showTrainingSuccessPage($payment);
    }

    protected function processFailedTrainingPayment($payment)
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

        Log::warning('Yoco training payment failed', ['payment_id' => $payment->id]);

        return view('payment.failed', [
            'payment' => $payment
        ]);
    }

    public function checkTrainingPaymentStatus(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        $verificationResult = $this->verifyYocoPayment($payment);
        
        if ($verificationResult['status'] === 'completed') {
            $this->processSuccessfulTrainingPayment($payment, $verificationResult);
            
            return response()->json([
                'status' => 'completed',
                'redirect' => route('yoco.training.success', ['payment' => $payment->id])
            ]);
        } elseif ($verificationResult['status'] === 'failed') {
            $this->processFailedTrainingPayment($payment);
            
            return response()->json([
                'status' => 'failed',
                'redirect' => route('yoco.training.failed', ['payment' => $payment->id])
            ]);
        }
        
        return response()->json(['status' => 'pending']);
    }

    protected function showTrainingSuccessPage($payment)
    {
        $client = Client::findOrFail($payment->client_id);
        $session = TrainingSession::findOrFail($payment->payable_id);

        return view('success-payment', [
            'trainingSession' => $session,
            'payment' => $payment,
            'client' => $client
        ]);
    }

    // Reuse the verifyYocoPayment method
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

    protected function getYocoPaymentLink($trainingTypeId, $userType)
    {
        // Live Q&A Session (type_id = 4)
        if ($trainingTypeId == 4) {
            return strtolower($userType) === 'student' 
                ? 'https://pay.yoco.com/r/78EaYJ' 
                : 'https://pay.yoco.com/r/2Yga0k';
        }
        
        // Response Consultation (type_id = 5)
        if ($trainingTypeId == 5) {
            return strtolower($userType) === 'student' 
                ? 'https://pay.yoco.com/r/4arOz5' 
                : 'https://pay.yoco.com/r/4xj5wr';
        }
        
        // Default fallback (shouldn't happen for these session types)
        return strtolower($userType) === 'student' 
            ? 'https://pay.yoco.com/r/78EaYJ' 
            : 'https://pay.yoco.com/r/2Yga0k';
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
}