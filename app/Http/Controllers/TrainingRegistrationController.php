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
            // Process payment with Yoco (USE TEST KEY LIKE TESTING VERSION)
            $response = Http::withHeaders([
                'X-Auth-Secret-Key' => env('YOCO_TEST_SECRET_KEY'), // Changed to TEST key
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
                return redirect()->route('yoco.training.failed', ['payment' => $payment->id])
                    ->with('error', 'Payment failed. Please try again.');
            }

        } catch (\Exception $e) {
            Log::error("Training payment failed for client {$client->id}: " . $e->getMessage());
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function showTrainingSuccess($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $client = Client::findOrFail($payment->client_id);
        $session = TrainingSession::findOrFail($payment->payable_id);

        return view('success-group', [
            'service' => $session, // Pass the session as service
            'payment' => $payment,
            'client' => $client
        ]);
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