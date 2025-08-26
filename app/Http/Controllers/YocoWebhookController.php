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
        
        // For testing without signature verification
        if (app()->environment('local')) {
            Log::info('Skipping signature verification in local environment');
            return $this->processWebhook($request->json()->all());
        }
        
        // Verify webhook signature in production
        $signature = $request->header('X-Yoco-Signature');
        $payload = $request->getContent();
        
        if (!$this->verifySignature($signature, $payload)) {
            Log::error('Invalid Yoco webhook signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        return $this->processWebhook($request->json()->all());
    }
    
    protected function processWebhook($event)
    {
        try {
            // Handle different event types
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
            Log::error('Error processing Yoco webhook: ' . $e->getMessage(), [
                'event' => $event,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Processing error'], 500);
        }
    }

    protected function verifySignature($signature, $payload)
    {
        $secret = env('YOCO_WEBHOOK_SECRET');
        
        if (!$secret) {
            Log::error('Yoco webhook secret not configured');
            return false;
        }
        
        $computedSignature = base64_encode(hash_hmac('sha256', $payload, $secret, true));
        
        return hash_equals($signature, $computedSignature);
    }

    protected function handlePaymentSucceeded($event)
    {
        $paymentData = $event['data']['object'];
        
        // Extract metadata to identify the payment
        $metadata = $paymentData['metadata'] ?? [];
        $clientId = $metadata['client_id'] ?? null;
        $planId = $metadata['plan_id'] ?? null;
        
        if (!$clientId || !$planId) {
            Log::error('Missing metadata in Yoco payment', $paymentData);
            return response()->json(['error' => 'Missing metadata'], 400);
        }

        $client = Client::find($clientId);
        $plan = TrainingType::find($planId);

        if (!$client || !$plan) {
            Log::error('Client or plan not found', ['client_id' => $clientId, 'plan_id' => $planId]);
            return response()->json(['error' => 'Client or plan not found'], 404);
        }

        // Create payment record
        $payment = Payment::create([
            'transaction_id' => $paymentData['id'],
            'client_id' => $client->id,
            'amount' => $paymentData['amount'] / 100, // Convert from cents to rand
            'payment_method' => $paymentData['payment_method'] ?? 'yoco',
            'status' => 'completed',
            'payable_type' => 'subscription',
            'payable_id' => $plan->id
        ]);

        // Update client subscription
        $client->update([
            'subscription_type' => strtolower($plan->name),
            'subscription_paid_at' => now(),
            'subscription_expiry' => now()->addQuarter()
        ]);

        // Update or create client course subscription
        $this->updateClientCourseSubscription($client, $plan);

        // Send notification
        $client->notify(new PaymentProcessed($payment, 'success'));

        Log::info('Yoco payment processed successfully', [
            'client_id' => $client->id,
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