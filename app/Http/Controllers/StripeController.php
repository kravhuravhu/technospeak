<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Payment;
use App\Models\Course;

class StripeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('stripe.sk'));

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'zar',
                    'product_data' => [
                        'name' => 'Send money',
                    ],
                    'unit_amount' => 1000, // R10.00
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('index'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        return view('stripe.success');
    }

    // public function success($id)
    // {
    //     $payment = Payment::findOrFail($id);
    //     $payment->update(['status' => 'completed']);

    //     $client = $payment->client;
    //     $course = $payment->course;
    //     $client->courses()->attach($course->id);

    //     return redirect()->route('courses.show', $course->id)
    //         ->with('success', 'Payment completed and access granted!');
    // }

    // public function cancel($id)
    // {
    //     return view('stripe.cancel');
    // }
}

