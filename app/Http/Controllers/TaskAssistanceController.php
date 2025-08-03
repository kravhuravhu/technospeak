<?php

namespace App\Http\Controllers;

use App\Models\TaskAssistanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskConfirmation;
use App\Mail\TaskPaymentConfirmation;

class TaskAssistanceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_type' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'nullable|date',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120', // 5MB max
            'hours_estimated' => 'required|integer|min:1',
        ]);
        
        $requestData = $validated;
        $requestData['client_id'] = Auth::id();
        
        // Handle file uploads
        if ($request->hasFile('attachments')) {
            $paths = [];
            foreach ($request->file('attachments') as $file) {
                $paths[] = $file->store('task_attachments');
            }
            $requestData['attachments'] = $paths;
        }
        
        $taskRequest = TaskAssistanceRequest::create($requestData);
        
        // Notify admin
        // You'd implement your notification system here
        
        return response()->json(['success' => true, 'message' => 'Request submitted successfully']);
    }
    
    public function processPayment(Request $request, $id)
    {
        $taskRequest = TaskAssistanceRequest::findOrFail($id);
        
        // Determine rate based on user type
        $rate = Auth::user()->is_business ? 250 : 100;
        
        // Process payment via Stripe
        try {
            $stripeCharge = Auth::user()->charge(
                $taskRequest->hours_estimated * $rate * 100, // in cents
                $request->payment_method
            );
            
            $taskRequest->update([
                'payment_id' => $stripeCharge->id,
                'status' => 'in_progress'
            ]);
            
            // Send payment confirmation email
            Mail::to(Auth::user()->email)->send(new TaskPaymentConfirmation($taskRequest));
            
            return redirect()->route('payment.success');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}