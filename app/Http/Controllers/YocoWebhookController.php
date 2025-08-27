<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Client;
use App\Models\TrainingType;
use App\Models\ClientCourseSubscription;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Notifications\PaymentProcessed;

class YocoWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info('Yoco webhook received', $request->all());
        
        // Verify webhook signature in production
        if (!app()->environment('local')) {
            $signature = $request->header('X-Yoco-Signature');
            $payload = $request->getContent();
            
            if (!$this->verifySignature($signature, $payload)) {
                Log::error('Invalid Yoco webhook signature');
                return response()->json(['error' => 'Invalid signature'], 400);
            }
        }

        return $this->processWebhook($request->json()->all());
    }
    
    protected function processWebhook($event)
    {
        try {
            switch ($event['type']) {
                case 'payment.succeeded':
                    return $this->handlePaymentSucceeded($event);
                case 'payment.failed':
                    return $this->handlePaymentFailed($event);
                default:
                    Log::info('Unhandled Yoco event type: ' . ($event['type'] ?? 'unknown'));
                    return response()->json(['status' => 'ignored']);
            }
        } catch (\Exception $e) {
            Log::error('Error processing Yoco webhook: ' . $e->getMessage());
            return response()->json(['error' => 'Processing error'], 500);
        }
    }

    protected function handlePaymentSucceeded($event)
    {
        $paymentData = $event['data']['object'];
        $metadata = $paymentData['metadata'] ?? [];
        
        $paymentId = $metadata['payment_id'] ?? null;
        $clientId = $metadata['client_id'] ?? null;
        $planId = $metadata['plan_id'] ?? null;

        if (!$paymentId) {
            Log::error('Missing payment_id in Yoco webhook metadata', $paymentData);
            return response()->json(['error' => 'Missing payment_id'], 400);
        }

        $payment = Payment::find($paymentId);
        if (!$payment) {
            Log::error('Payment not found', ['payment_id' => $paymentId]);
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // If payment is already completed, skip processing
        if ($payment->status === 'completed') {
            Log::info('Payment already processed', ['payment_id' => $paymentId]);
            return response()->json(['status' => 'already_processed']);
        }

        $client = Client::find($payment->client_id);
        $plan = TrainingType::find($payment->payable_id);

        if (!$client || !$plan) {
            Log::error('Client or plan not found', [
                'client_id' => $payment->client_id,
                'plan_id' => $payment->payable_id
            ]);
            return response()->json(['error' => 'Client or plan not found'], 404);
        }

        // Update payment record
        $payment->update([
            'transaction_id' => $paymentData['id'],
            'status' => 'completed',
            'metadata' => json_encode(array_merge(
                json_decode($payment->metadata, true) ?? [],
                [
                    'webhook_processed_at' => now()->toDateTimeString(),
                    'yoco_webhook_data' => $paymentData
                ]
            ))
        ]);

        // Update client subscription
        $client->update([
            'subscription_type' => strtolower($plan->name),
            'subscription_paid_at' => now(),
            'subscription_expiry' => now()->addQuarter(),
            'updated_at' => now()
        ]);

        // Update client course subscriptions
        $this->updateClientCourseSubscription($client, $plan);

        // Send notification
        $client->notify(new PaymentProcessed($payment, 'success'));

        Log::info('Yoco payment processed via webhook', [
            'payment_id' => $payment->id,
            'transaction_id' => $paymentData['id']
        ]);

        return response()->json(['status' => 'success']);
    }

    protected function updateClientCourseSubscription($client, $plan)
    {
        // For premium subscription, update all premium course subscriptions
        if (strtolower($plan->name) === 'premium') {
            $premiumCourses = Course::where('plan_type', 'premium')->get();
            
            foreach ($premiumCourses as $course) {
                ClientCourseSubscription::updateOrCreate(
                    [
                        'client_id' => $client->id,
                        'course_id' => $course->id
                    ],
                    [
                        'payment_status' => 'paid',
                        'subscribed_at' => now(),
                        'updated_at' => now()
                    ]
                );
            }
        }
    }

    protected function handlePaymentFailed($event)
    {
        $paymentData = $event['data']['object'];
        $metadata = $paymentData['metadata'] ?? [];
        $clientId = $metadata['client_id'] ?? null;

        if ($clientId) {
            $client = Client::find($clientId);
            if ($client) {
                // Create failed payment record
                $payment = Payment::create([
                    'transaction_id' => $paymentData['id'],
                    'client_id' => $client->id,
                    'amount' => $paymentData['amount'] / 100,
                    'payment_method' => $paymentData['payment_method'] ?? 'yoco',
                    'status' => 'failed',
                    'payable_type' => 'subscription',
                    'payable_id' => $metadata['plan_id'] ?? null
                ]);

                $client->notify(new PaymentProcessed($payment, 'failed'));
            }
        }

        Log::warning('Yoco payment failed', $paymentData);
        return response()->json(['status' => 'failed_payment_handled']);
    }
    
    public function testWebhook(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Webhook endpoint is accessible',
            'timestamp' => now(),
            'url' => url('/api/yoco/webhook')
        ]);
    }
}