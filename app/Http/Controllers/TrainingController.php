<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use App\Models\TrainingRegistration;
use App\Models\TrainingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrainingConfirmation;
use Carbon\Carbon;

class TrainingController extends Controller
{
    /**
     * Get upcoming training sessions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upcomingSessions()
    {
        $sessions = TrainingSession::with(['type', 'instructor'])
            ->where('scheduled_for', '>', now())
            ->orderBy('scheduled_for')
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'title' => $session->title,
                    'description' => $session->description,
                    'type' => $session->type->name,
                    'instructor' => $session->instructor ? $session->instructor->name : 'TBD',
                    'scheduled_for' => $session->scheduled_for,
                    'from_time' => $session->from_time,
                    'to_time' => $session->to_time,
                    'duration' => $session->duration_seconds,
                    'max_participants' => $session->max_participants,
                    'registered_count' => $session->registrations()->count(),
                    'price_student' => $session->price_student,
                    'price_business' => $session->price_business,
                    'formatted_date' => Carbon::parse($session->scheduled_for)->format('F j, Y'),
                    'formatted_time' => Carbon::parse($session->from_time)->format('g:i A') . ' - ' . 
                                      Carbon::parse($session->to_time)->format('g:i A')
                ];
            });

        return response()->json($sessions);
    }

    /**
     * Handle RSVP for a training session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rsvp(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
            'phone' => 'nullable|string|max:20'
        ]);

        $user = auth()->user();
        $session = TrainingSession::find($validated['session_id']);

        // Check if already registered
        $existing = TrainingRegistration::where([
            'client_id' => $user->id,
            'session_id' => $validated['session_id']
        ])->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this session'
            ], 400);
        }

        // Check session capacity
        $registeredCount = TrainingRegistration::where('session_id', $validated['session_id'])->count();
        
        if ($session->max_participants && $registeredCount >= $session->max_participants) {
            return response()->json([
                'success' => false,
                'message' => 'This session is already full'
            ], 400);
        }

        // Check if session is in the past
        if (Carbon::parse($session->scheduled_for)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'This session has already occurred'
            ], 400);
        }

        // Create registration
        $registration = TrainingRegistration::create([
            'client_id' => $user->id,
            'phone' => $validated['phone'] ?? null,
            'session_id' => $validated['session_id'],
            'payment_status' => $session->price_student > 0 ? 'pending' : 'free',
            'registered_at' => now()
        ]);

        // Send confirmation email
        Mail::to($user->email)->send(new TrainingConfirmation($registration));

        return response()->json([
            'success' => true,
            'message' => 'Successfully registered for the session',
            'registration' => $registration,
            'remaining_seats' => $session->max_participants ? ($session->max_participants - $registeredCount - 1) : null
        ]);
    }

    /**
     * Get all training types
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTrainingTypes()
    {
        $types = TrainingType::all()->map(function ($type) {
            return [
                'id' => $type->id,
                'name' => $type->name,
                'description' => $type->description,
                'is_group_session' => (bool)$type->is_group_session,
                'max_participants' => $type->max_participants,
                'student_price' => $type->student_price,
                'professional_price' => $type->professional_price
            ];
        });

        return response()->json($types);
    }

    /**
     * Get session details by ID
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSession($id)
    {
        $session = TrainingSession::with(['type', 'instructor', 'registrations'])
            ->findOrFail($id);

        return response()->json([
            'id' => $session->id,
            'title' => $session->title,
            'description' => $session->description,
            'type' => $session->type->name,
            'instructor' => $session->instructor ? $session->instructor->name : 'TBD',
            'scheduled_for' => $session->scheduled_for,
            'from_time' => $session->from_time,
            'to_time' => $session->to_time,
            'duration' => $session->duration_seconds,
            'max_participants' => $session->max_participants,
            'registered_count' => $session->registrations()->count(),
            'price_student' => $session->price_student,
            'price_business' => $session->price_business,
            'formatted_date' => Carbon::parse($session->scheduled_for)->format('F j, Y'),
            'formatted_time' => Carbon::parse($session->from_time)->format('g:i A') . ' - ' . 
                                Carbon::parse($session->to_time)->format('g:i A'),
            'registrations' => $session->registrations->map(function ($reg) {
                return [
                    'user_id' => $reg->client_id,
                    'registered_at' => $reg->registered_at,
                    'payment_status' => $reg->payment_status
                ];
            })
        ]);
    }

    /**
     * Cancel a registration
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelRegistration(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:training_registrations,id'
        ]);

        $registration = TrainingRegistration::find($validated['registration_id']);

        // Verify user owns this registration
        if ($registration->client_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Check if it's too late to cancel (e.g., within 24 hours of session)
        $sessionTime = Carbon::parse($registration->session->scheduled_for);
        if ($sessionTime->diffInHours(now()) < 24) {
            return response()->json([
                'success' => false,
                'message' => 'Cancellations must be made at least 24 hours before the session'
            ], 400);
        }

        $registration->delete();

        return response()->json([
            'success' => true,
            'message' => 'Registration cancelled successfully'
        ]);
    }

    /**
     * Get user's upcoming registrations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function myRegistrations()
    {
        $registrations = TrainingRegistration::with(['session.type', 'session.instructor'])
            ->where('client_id', auth()->id())
            ->whereHas('session', function ($query) {
                $query->where('scheduled_for', '>', now());
            })
            ->get()
            ->map(function ($reg) {
                return [
                    'id' => $reg->id,
                    'session_id' => $reg->session_id,
                    'title' => $reg->session->title,
                    'type' => $reg->session->type->name,
                    'instructor' => $reg->session->instructor ? $reg->session->instructor->name : 'TBD',
                    'scheduled_for' => $reg->session->scheduled_for,
                    'formatted_date' => Carbon::parse($reg->session->scheduled_for)->format('F j, Y'),
                    'formatted_time' => Carbon::parse($reg->session->from_time)->format('g:i A') . ' - ' . 
                                       Carbon::parse($reg->session->to_time)->format('g:i A'),
                    'payment_status' => $reg->payment_status,
                    'registered_at' => $reg->registered_at
                ];
            });

        return response()->json($registrations);
    }
}