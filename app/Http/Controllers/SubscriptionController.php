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

    $plan = ServicePlan::findOrFail($request->plan_id);
    
    if (!$plan->is_subscription) {
        return redirect()->back()->with('error', 'Selected plan is not a subscription');
    }

    return redirect()->route('stripe.checkout', [
        'clientId' => auth()->id(),
        'planId' => 'subscription_' . $plan->id
    ]);
}

    public function subscribeFree()
    {
        $client = auth()->user();
        $client->update([
            'subscription_type' => 'free',
            'subscription_expiry' => null
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