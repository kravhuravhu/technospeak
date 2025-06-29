<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use Illuminate\Http\Request;

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

    public function show(Payment $payment)
    {
        $payment->load(['client', 'course']);
        return view('admin.payments.show', compact('payment'));
    }

    public function approve(Request $request, Payment $payment)
    {
        $payment->update(['status' => 'completed']);

        // I'll discuss with Omega first to maybe ....
        // 1. Grant the client access to the course
        // 2. Send a confirmation email

        return redirect()->route('content-manager.payments.index')
            ->with('success', 'Payment approved successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('content-manager.payments.index')
            ->with('success', 'Payment record deleted successfully!');
    }
}