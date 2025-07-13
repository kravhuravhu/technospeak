<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Client;
use App\Models\ServicePlan;
use App\Models\Payment;
 
class StripeController extends Controller
{
    public function checkout($clientId, $planId)
    {
        $client = Client::findOrFail($clientId);
        $plan = ServicePlan::findOrFail($planId);
 
        $price = $client->userType === 'student'
            ? $plan->rate_student
            : $plan->rate_business;
 
        Stripe::setApiKey(env('STRIPE_SECRET'));
 
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'zar',
                    'product_data' => ['name' => $plan->name],
                    'unit_amount' => $price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => $plan->is_subscription ? 'subscription' : 'payment',
            'success_url' => url('/payment-success'),
            'cancel_url' => url('/payment-cancel'),
        ]);
 
        Payment::create([
            'client_id' => $client->id,
            'amount' => $price,
            'payment_method' => 'stripe',
            'stripe_session_id' => $session->id,
            'service_plan_id' => $plan->id,
            'status' => 'pending'
        ]);
 
        return redirect($session->url);
    }
}