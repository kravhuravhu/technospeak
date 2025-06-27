<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingSession;
use App\Models\TrainingType;
use App\Models\Instructor;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // $instructors = Client::where('is_instructor', true)->get();
        $instructors = Instructor::all();

        return view('content-manager.trainings.create', compact('types', 'instructors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_id' => 'required|exists:training_types,id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'instructor_id' => 'nullable|exists:users,id',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('trainings', 'public');
        }

        TrainingSession::create($validated);

        return redirect()->route('content-manager.trainings.index')
            ->with('success', 'Training session created successfully!');
    }

    public function show(TrainingSession $training)
    {
        $training->load(['type', 'instructor', 'registrations.client']);
        return view('content-manager.trainings.show', compact('training'));
    }

    public function edit(TrainingSession $training)
    {
        $types = TrainingType::all();
        $instructors = Client::where('is_instructor', true)->get();

        return view('content-manager.trainings.edit', compact('training', 'types', 'instructors'));
    }

    public function update(Request $request, TrainingSession $training)
    {
        $validated = $request->validate([
            'type_id' => 'required|exists:training_types,id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'instructor_id' => 'nullable|exists:users,id',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($training->thumbnail) {
                Storage::disk('public')->delete($training->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('trainings', 'public');
        }

        $training->update($validated);

        return redirect()->route('content-manager.trainings.index')
            ->with('success', 'Training session updated successfully!');
    }

    public function destroy(TrainingSession $training)
    {
        // Prevent deletion if there are registrations
        if ($training->registrations()->exists()) {
            return back()->with('error', 
                'Cannot delete training session with existing registrations. Cancel registrations first.');
        }

        // Delete thumbnail if exists
        if ($training->thumbnail) {
            Storage::disk('public')->delete($training->thumbnail);
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