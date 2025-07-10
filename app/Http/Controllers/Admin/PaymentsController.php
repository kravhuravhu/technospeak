<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Payment;
use App\Models\Course;
use App\Models\Client;

class PaymentsController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('admin');
    }

    public function index()
    {
        $payments = Payment::with(['client', 'course'])->latest()->paginate(10);
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $pendingAmount = Payment::where('status', 'pending')->sum('amount');

        return view('admin.payments.index', compact('payments', 'totalRevenue', 'pendingAmount'));
    }

    public function initiateStripeCheckout(Request $request)
    {
        $course = Course::findOrFail($request->course_id);
        $client = Auth::user(); // assuming authenticated client

        $amountInCents = (int) round($course->price * 100);

        $payment = Payment::create([
            'transaction_id' => uniqid('txn_'),
            'client_id' => $client->id,
            'course_id' => $course->id,
            'amount' => $course->price,
            'status' => 'pending',
        ]);

        Stripe::setApiKey(config('stripe.sk'));

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'zar',
                    'product_data' => [
                        'name' => $course->title,
                    ],
                    'unit_amount' => $amountInCents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['id' => $payment->id]),
            'cancel_url' => route('payment.cancel', ['id' => $payment->id]),
        ]);

        return redirect()->away($session->url);
    }

    public function approve(Request $request, Payment $payment)
    {
        $payment->update(['status' => 'completed']);

        // ✔️ Grant access to the course
        $client = $payment->client;
        $course = $payment->course;
        $client->courses()->attach($course->id);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment approved and course access granted!');
    }

    public function show(Payment $payment)
    {
        $payment->load(['client', 'course']);
        return view('admin.payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment record deleted successfully!');
    }
}