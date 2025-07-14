<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\QaSessionRegistrationConfirmation;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\TrainingSession;

class QaSessionRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'qa_session_id' => 'required|integer|exists:training_sessions,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20'
        ]);

        // Get the Q/A session details
        $qaSession = TrainingSession::findOrFail($request->qa_session_id);
        $amount = 11000; // R110 in cents

        // Save registration and get the new ID
        $registrationId = DB::table('qa_session_registrations')->insertGetId([
            'client_id' => auth()->id(),
            'qa_session_id' => $request->qa_session_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'amount' => $amount / 100, // Store in Rands
            'payment_status' => 'pending',
            'status' => 'pending',
            'registered_at' => now(),
        ]);

        // Setup Stripe session
        Stripe::setApiKey(config('services.stripe.secret'));

        $checkoutSession = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'zar',
                    'product_data' => [
                        'name' => $qaSession->title,
                        'description' => 'Q/A Session - ' . $qaSession->scheduled_for->format('F j, Y'),
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'customer_email' => $request->email,
            'metadata' => [
                'registration_id' => $registrationId,
                'qa_session_id' => $qaSession->id,
            ],
            'success_url' => route('qa.registration.success', ['id' => $registrationId]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('qa.registration.cancel', ['id' => $registrationId]),
        ]);

        // Update registration with Stripe session ID
        DB::table('qa_session_registrations')
            ->where('id', $registrationId)
            ->update([
                'stripe_session_id' => $checkoutSession->id
            ]);

        return redirect()->away($checkoutSession->url);
    }
    
    public function success(Request $request, $id)
    {
        // Verify the payment was successful
        $registration = DB::table('qa_session_registrations')
            ->where('id', $id)
            ->first();

        if (!$registration) {
            abort(404, 'Registration not found');
        }

        // Check payment status with Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::retrieve($request->session_id);

        if ($session->payment_status === 'paid') {
            // Update registration status
            DB::table('qa_session_registrations')
                ->where('id', $id)
                ->update([
                    'payment_status' => 'paid',
                    'status' => 'confirmed',
                    'completed_at' => now(),
                ]);

            // Send confirmation email
            $qaSession = TrainingSession::find($registration->qa_session_id);
            Mail::to($registration->email)->send(new QaSessionRegistrationConfirmation($registration, $qaSession));

            return view('qa.registration-success', [
                'registration' => $registration,
                'session' => $qaSession,
            ]);
        }

        // If payment wasn't successful, show appropriate message
        return view('qa.registration-failure', ['id' => $id]);
    }

    public function cancel($id)
    {
        // Update registration status
        DB::table('qa_session_registrations')
            ->where('id', $id)
            ->update([
                'payment_status' => 'failed',
                'status' => 'cancelled',
            ]);

        return view('qa.registration-cancel', ['id' => $id]);
    }
}