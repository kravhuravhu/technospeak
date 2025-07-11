<?php

namespace App\Http\Controllers;

use App\Models\TrainingRegistration;
use Illuminate\Http\Request;
use App\Models\TrainingSession;

class TrainingRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $session = TrainingSession::find($validated['session_id']);
        if (!$session || $session->scheduled_for < now()) {
            return back()->with('error', 'This session is no longer available for registration.');
        }

        if ($session->isFull()) {
            return back()->with('error', 'This session is already full.');
        }

        // Create registration
        TrainingRegistration::create([
            'session_id' => $validated['session_id'],
            'client_id' => auth()->id() ?? null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'payment_status' => 'pending',
        ]);

        return back()->with('success', 'You have successfully registered for this session!');
    }
}