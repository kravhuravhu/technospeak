<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingSession;
use App\Models\TrainingType;
use App\Models\Instructor;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrainingSessionController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('admin');
    }

    public function index()
    {
        $sessions = TrainingSession::with(['type', 'instructor'])
            ->latest()
            ->paginate(10);

        return view('content-manager.trainings.index', compact('sessions'));
    }

    public function create()
    {
        $types = TrainingType::all();
        $categories = CourseCategory::all();
        $instructors = Instructor::all();

        return view('content-manager.trainings.create', compact('types', 'categories', 'instructors'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Training session creation started', ['data' => $request->all()]);

            $validated = $request->validate([
                'title' => 'required|max:150',
                'type_id' => 'required|exists:training_types,id',
                'description' => 'nullable|string',
                'from_time' => 'required|date_format:H:i',
                'to_time' => 'required|date_format:H:i|after:from_time',
                'duration_seconds' => 'required|integer|min:60',
                'category_id' => 'required|exists:course_categories,id',
                'instructor_id' => 'nullable|exists:instructors,id',
                'scheduled_for' => 'required|date',
                'max_participants' => 'nullable|integer|min:1',
            ]);

            $training = TrainingSession::create($validated);

            Log::info('Training session created successfully', ['training_id' => $training->id]);

            return redirect()
                ->route('content-manager.trainings.index')
                ->with('success', 'Training session created.');
        } catch (\Throwable $e) {
            Log::error('Training session creation failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withErrors('An error occurred while creating the training session.')
                ->withInput();
        }
    }

    public function show(TrainingSession $training)
    {
        $training->load(['type', 'instructor', 'registrations.client']);
        return view('content-manager.trainings.show', compact('training'));
    }

    public function edit(TrainingSession $training)
    {
        $types = TrainingType::all();
        $categories = CourseCategory::all();
        $instructors = Instructor::all();

        return view('content-manager.trainings.edit', compact('training', 'types', 'categories', 'instructors'));
    }

    public function update(Request $request, TrainingSession $training)
    {
        \Log::info('Training session update started', [
            'training_id' => $training->id,
            'data' => $request->all()
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'type_id' => 'required|exists:training_types,id',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:course_categories,id',
            'instructor_id' => 'nullable|exists:instructors,id',
            'scheduled_for' => 'required|date',
            'from_time' => 'required|date_format:H:i',
            'to_time' => 'required|date_format:H:i|after:from_time',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        try {
            list($fh, $fm) = explode(':', $validated['from_time']);
            list($th, $tm) = explode(':', $validated['to_time']);

            $from = $fh * 3600 + $fm * 60;
            $to = $th * 3600 + $tm * 60;
            $duration = $to - $from;

            if ($duration < 60) {
                return back()->withErrors(['duration_seconds' => 'Duration must be at least 1 minute.'])->withInput();
            }

            $validated['duration_seconds'] = $duration;

            $training->update($validated);

            \Log::info('Training session updated', ['training' => $training->fresh()->toArray()]);

            return redirect()->route('content-manager.trainings.index')
                ->with('success', 'Training session updated successfully!');
        } catch (\Throwable $e) {
            \Log::error('Training session update failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors('An error occurred while updating the training session.')->withInput();
        }
    }

    public function destroy(TrainingSession $training)
    {
        if ($training->registrations()->exists()) {
            return back()->with('error', 
                'Cannot delete training session with existing registrations. Cancel registrations first.');
        }

        $training->delete();

        return redirect()->route('content-manager.trainings.index')
            ->with('success', 'Training session deleted successfully!');
    }

    public function registrations(TrainingSession $training)
    {
        $registrations = $training->registrations()
            ->with('client')
            ->latest()
            ->paginate(10);

        return view('content-manager.trainings.registrations', compact('training', 'registrations'));
    }

    public function markAttendance(Request $request, TrainingSession $training)
    {
        $request->validate([
            'registration_ids' => 'required|array',
            'registration_ids.*' => 'exists:training_registrations,id',
        ]);

        $training->registrations()
            ->whereIn('id', $request->registration_ids)
            ->update(['attended' => true]);

        return back()->with('success', 'Attendance marked successfully!');
    }
}