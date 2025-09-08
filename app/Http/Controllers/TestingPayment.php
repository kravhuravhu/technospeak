<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\TrainingRegistration;
use App\Models\TrainingSession;
use Illuminate\Support\Facades\Auth;

class TestingPayment extends Controller
{
    public function show()
    {
        $latestSession = TrainingSession::with('type', 'instructor')
            ->where('scheduled_for', '>', now())
            ->orderBy('scheduled_for', 'desc')
            ->first();

        return view('testingYoco', compact('latestSession'));
    }

    public function charge(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
            'token' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        $client = Auth::user();

        $session = TrainingSession::findOrFail($request->session_id);

        $amount = $session->type->getPriceForUserType($client->userType);

        Log::info("Payment attempt for client {$client->id}, session {$session->id}, amount R$amount, status pending");

        try {
            $response = Http::withHeaders([
                'X-Auth-Secret-Key' => env('YOCO_TEST_SECRET_KEY'),
            ])->post('https://online.yoco.com/v1/charges/', [
                'token' => $request->token,
                'amountInCents' => intval($amount * 100),
                'currency' => 'ZAR',
            ]);

            $data = $response->json();

            if (isset($data['error'])) {
                Log::info("Yoco error for client {$client->id}: " . $data['error']['message']);
                return back()->with('error', $data['error']['message']);
            }

            $payment = Payment::create([
                'transaction_id' => $data['id'],
                'client_id' => $client->id,
                'amount' => $amount,
                'payment_method' => 'card',
                'status' => $data['status'] === 'successful' ? 'completed' : 'failed',
                'payable_type' => 'training',
                'payable_id' => $session->id,
            ]);

            TrainingRegistration::updateOrCreate(
                [
                    'session_id' => $session->id,
                    'client_id' => $client->id,
                ],
                [
                    'phone' => $request->phone,
                    'payment_status' => $payment->status,
                    'payment_id' => $payment->id,
                ]
            );

            Log::info("Payment successful for client {$client->id}, transaction {$payment->transaction_id}");

            return back()->with('success', 'Payment successful! You are registered.');

        } catch (\Exception $e) {
            Log::error("Payment failed for client {$client->id}: " . $e->getMessage());
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    // eft
    public function eft(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
        ]);

        $client = Auth::user();
        $session = TrainingSession::findOrFail($request->session_id);
        $amount = $session->type->getPriceForUserType($client->userType);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode(env('YOCO_TEST_SECRET_KEY') . ':'),
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])->post('https://payments.yoco.com/api/checkouts', [
                'amount' => intval($amount * 100),
                'currency' => 'ZAR',
                'successUrl' => route('testing.payment.success'),
                'cancelUrl' => route('testing.payment.cancel'),
                'paymentMethods' => ['eft'],
                'customer' => [
                    'email' => $client->email,
                    'name'  => $client->name,
                ],
            ]);

            $data = $response->json();
            \Log::info('Yoco EFT response: ', $data);

            if (!isset($data['redirectUrl'])) {
                return back()->with('error', 'Failed to create EFT checkout.');
            }

            return redirect()->away($data['redirectUrl']);

        } catch (\Exception $e) {
            return back()->with('error', 'EFT failed: ' . $e->getMessage());
        }
    }
}
