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
            'plan_id' => 'required|exists:training_types,id',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $plan = TrainingType::findOrFail($request->plan_id);
        
        if ($plan->id == 7) { // Tech Teasers (free)
            return redirect()->route('subscription.subscribe.free');
        }

        return redirect()->route('stripe.checkout', [
            'clientId' => auth()->id(),
            'planId' => 'subscription_' . $plan->id
        ]);
    }

    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:training_types,id',
        ]);

        $user = auth()->user();
        $plan = TrainingType::findOrFail($request->plan_id);

        // Don't allow unsubscribing from free plan
        if ($plan->id == 7) {
            return back()->with('error', 'Cannot unsubscribe from free plan');
        }

        // Remove payment records for this subscription
        Payment::where('client_id', $user->id)
            ->where('payable_type', 'subscription')
            ->where('payable_id', $plan->id)
            ->delete();

        // Update client's subscription status if this was their active subscription
        if ($user->subscription_type == strtolower($plan->name)) {
            $user->update([
                'subscription_type' => null,
                'subscription_paid_at' => null,
                'subscription_expiry' => null
            ]);
        }

        return back()->with('success', 'Successfully unsubscribed from ' . $plan->name);
    }


    public function subscribeFree()
    {
        $client = auth()->user();
        $client->update([
            'subscription_type' => 'free',
            'subscription_paid_at' => null,
            'subscription_expiry' => null
        ]);
        
        return redirect()->route('dashboard', ['section' => 'usr_alltrainings'])
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

    public function subscriptionSuccess(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $sessionId = $request->get('session_id');
            $stripeSession = Session::retrieve($sessionId);

            $trainingType = TrainingType::findOrFail($stripeSession->metadata->training_type_id);
            $client = Client::findOrFail($stripeSession->metadata->client_id);

            // Create payment record
            $payment = Payment::create([
                'transaction_id' => $stripeSession->payment_intent,
                'client_id' => $client->id,
                'amount' => $stripeSession->amount_total / 100,
                'payment_method' => 'stripe',
                'status' => 'completed',
                'payable_type' => 'subscription',
                'payable_id' => $trainingType->id
            ]);

            // Update client's subscription status
            $client->update([
                'subscription_type' => strtolower($trainingType->name),
                'subscription_paid_at' => now(), 
                'subscription_expiry' => now()->addQuarter()
            ]);

            return view('success-subscription', [
                'plan' => $trainingType,
                'payment_amount' => $stripeSession->amount_total / 100,
                'transaction_id' => $stripeSession->payment_intent
            ]);

        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error processing payment: ' . $e->getMessage());
        }
    }
}