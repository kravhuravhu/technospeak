<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Client;
use App\Models\TrainingSession;
use App\Models\TrainingRegistration;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('admin');
    }

    public function index()
    {
        $clients = Client::all();
        $payments = Payment::with(['client', 'payable'])
            ->latest()
            ->paginate(10);

        $totalRevenue = Payment::completed()->sum('amount');
        $pendingAmount = Payment::pending()->sum('amount');

        return view('content-manager.payments.index', [
            'payments' => $payments,
            'totalRevenue' => $totalRevenue,
            'pendingAmount' => $pendingAmount,
            'clients' => $clients
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => [
                'required',
                Rule::in(['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'stripe'])
            ],
            'payable_type' => [
                'required',
                Rule::in(array_keys(Payment::PAYABLE_TYPES))
            ],
            'payable_id' => 'required|integer',
            'transaction_id' => 'nullable|string|unique:payments,transaction_id'
        ]);

        // full class name
        $validated['payable_type'] = Payment::PAYABLE_TYPES[$validated['payable_type']];

        // amount based on user typ
        if (!isset($validated['amount'])) {
            $validated['amount'] = $this->calculateAmount(
                $validated['payable_type'],
                $validated['payable_id'],
                $validated['client_id']
            );
        }

        $payment = Payment::create($validated);

        return response()->json([
            'success' => true,
            'payment' => $payment,
            'message' => 'Payment recorded successfully'
        ]);
    }

    public function approve(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Only pending payments can be approved');
        }

        $payment->update(['status' => 'completed']);

        // payment based on payable type
        $this->processPayment($payment);

        return back()->with('success', 'Payment approved successfully');
    }

    protected function calculateAmount(string $payableType, int $payableId, string $clientId): float
    {
        $client = Client::findOrFail($clientId);
        
        if ($payableType === \App\Models\TrainingSession::class) {
            $session = TrainingSession::with('type')->findOrFail($payableId);
            return $session->type->getPriceForUserType($client->userType);
        }

        return 0;
    }

    protected function processPayment(Payment $payment): void
    {
        if ($payment->payable_type === \App\Models\TrainingSession::class) {
            $this->processTrainingPayment($payment);
        }
    }

    protected function processTrainingPayment(Payment $payment): void
    {
        // Find or create registration
        $registration = TrainingRegistration::firstOrCreate(
            [
                'session_id' => $payment->payable_id,
                'client_id' => $payment->client_id
            ],
            [
                'name' => $payment->client->name,
                'email' => $payment->client->email,
                'payment_status' => 'completed'
            ]
        );

        // Update registration status
        $registration->update([
            'payment_status' => 'completed',
            'payment_id' => $payment->id
        ]);
    }

    public function show(Payment $payment)
    {
        $payment->load(['client', 'payable']);

        return view('content-manager.payments.show', compact('payment'));
    }
}