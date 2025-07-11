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

        return view('content-manager.payments.index', compact('payments', 'totalRevenue', 'pendingAmount'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['client', 'course']);
        return view('content-manager.payments.show', compact('payment'));
    }

    public function approve(Request $request, Payment $payment)
    {
        $payment->update(['status' => 'completed']);

        $client = $payment->client;
        $course = $payment->course;
        $client->courses()->attach($course->id);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment approved and course access granted!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment record deleted successfully!');
    }
}