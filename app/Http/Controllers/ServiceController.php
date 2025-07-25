<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Client;
use App\Models\ServicePlan;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:service_plans,id',
            'hours' => 'sometimes|integer|min:1',
            'name' => 'required',
        ]);

        $service = ServicePlan::find($request->service_id);
        $user = auth()->user();

        // Calculate price
        $price = $user->userType === 'Student' ? $service->rate_student : $service->rate_business;
        $total = $service->is_hourly ? $price * ($request->hours ?? 1) : $price;

        // Create payment record
        $payment = Payment::create([
            'client_id' => $user->id,
            'amount' => $total,
            'payment_method' => 'pending',
            'status' => 'pending',
            'payable_type' => 'service',
            'payable_id' => $service->id,
        ]);

        // Redirect to Stripe checkout
        return redirect()->route('stripe.checkout', [
            'clientId' => $user->id,
            'planId' => 'service_' . $service->id . ($service->is_hourly ? '_' . ($request->hours ?? 1) : '')
        ]);
    }

    protected function handleFreeService($service, $client)
    {
         // Only create training registration for group sessions
        if ($service->name === 'Group Q/A') {
            TrainingRegistration::create([
                'client_id' => $client->id,
                'session_id' => null,
                'payment_status' => 'free',
                'registered_at' => now()
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Registration successful!');
            
    }

    protected function handlePayment($service, $client, $hours = 1)
    {
        $price = $client->userType === 'Student' ? 
            $service->rate_student : $service->rate_business;
        //$price = $service->getPriceForUserType($client->userType);
        
        $totalAmount = $service->is_hourly ? $price * $hours : $price;

        $payment = Payment::create([
            'client_id' => $client->id,
            'amount' => $totalAmount,
            'payment_method' => 'pending',
            'payable_type' => 'service',
            'payable_id' => $service->id,
            'metadata' => $service->is_hourly ? ['hours' => $hours] : null,
            'status' => 'pending'
        ]);

        return redirect()->route('stripe.checkout', [
            'clientId' => $client->id,
            'planId' => 'service_' . $service->id . ($service->is_hourly ? '_' . $hours : '')
        ]);
    }
}