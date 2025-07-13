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
            'id' => Payment::max('id') + 1, // Get the highest ID and increment
            'client_id' => (string) $client->id,
            'amount' => $price,
            'payment_method' => 'stripe',
            'status' => 'pending',
            'payment_for' => strtolower($plan->name) === 'q/a session' ? 'qa_session' : 'service_plan',
            'item_id' => $plan->id,
            'service_plan_id' => $plan->id,
            'stripe_session_id' => $session->id
        ]);
 
        return redirect($session->url);
    }

    public function success()
    {
        return view('stripe.success'); // Or return a success message
    }
}