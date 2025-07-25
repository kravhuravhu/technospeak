<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Client;
use App\Models\TrainingType;
use Illuminate\Http\Request;
use App\Models\ServicePlan;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:service_plans,id',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $plan = ServicePlan::find($request->plan_id);
        $user = auth()->user();

        // Calculate price
        $price = $user->userType === 'Student' ? $plan->rate_student : $plan->rate_business;

        // Create payment record
        $payment = Payment::create([
            'client_id' => $user->id,
            'amount' => $price,
            'payment_method' => 'pending',
            'status' => 'pending',
            'payable_type' => 'subscription',
            'payable_id' => $plan->id,
        ]);

        // Redirect to Stripe checkout
        return redirect()->route('stripe.checkout', [
            'clientId' => $user->id,
            'planId' => 'subscription_' . $plan->id
        ]);
    }

    public function subscribeFree()
    {
        $client = auth()->user();
        $client->update([
            'subscription_type' => 'free',
            'subscription_expiry' => null //do not expire free subscriptions
        ]);
        
        return redirect()->route('dashboard')
            ->with('success', 'Free subscription activated!');
    }

    protected function handlePayment($plan, $client)
    {
        $price = $plan->getPriceForUserType($client->userType);
        
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
}