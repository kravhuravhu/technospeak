<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Payment;
use App\Models\TrainingRegistration;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with(['preferredCategory'])
            ->latest('registered_date')
            ->paginate(10);

        return view('content-manager.clients.clients', compact('clients'));
    }

    public function create()
    {
        $categories = CourseCategory::all();
        return view('content-manager.clients.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:10|unique:clients,id',
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:clients,email',
            'password' => 'required|string|min:8|confirmed',
            'preferred_category_id' => 'nullable|exists:course_categories,id',
            'subscription_type' => 'nullable|string|max:50',
            'subscription_expiry' => 'nullable|date',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['registered_date'] = now()->format('Y-m-d');
        $validated['registered_time'] = now()->format('H:i:s');

        Client::create($validated);

        return redirect()->route('content-manager.clients.clients')
            ->with('success', 'Client created successfully!');
    }

    public function show(Client $client)
    {
        $client->load([
            'preferredCategory',
            'courseSubscriptions.course',
            'trainingRegistrations.session',
            'payments'
        ]);

        $courses = Course::whereNotIn('id', $client->courseSubscriptions->pluck('course_id'))
            ->latest()
            ->take(5)
            ->get();

        $trainings = TrainingSession::whereNotIn('id', $client->trainingRegistrations->pluck('session_id'))
            ->where('scheduled_at', '>', now()) 
            ->take(5)
            ->get();

        return view('content-manager.clients.show', compact('client', 'courses', 'trainings'));
    }

    public function edit(Client $client)
    {
        $categories = CourseCategory::all();
        return view('content-manager.clients.edit', compact('client', 'categories'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('clients')->ignore($client->id, 'id')
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'preferred_category_id' => 'nullable|exists:course_categories,id',
            'subscription_type' => 'nullable|string|max:50',
            'subscription_expiry' => 'nullable|date',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $client->update($validated);

        return redirect()->route('content-manager.clients.show', $client)
            ->with('success', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        // Prevent deletion if client has any activity
        if ($client->courseSubscriptions()->exists() || 
            $client->trainingRegistrations()->exists() || 
            $client->payments()->exists()) {
            return back()->with('error', 
                'Cannot delete client with existing activity. Archive instead.');
        }

        $client->delete();

        return redirect()->route('content-manager.clients.clients')
            ->with('success', 'Client deleted successfully!');
    }

    public function enrollCourse(Request $request, Client $client)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'payment_status' => 'required|in:free,paid'
        ]);

        // Check if already enrolled
        if ($client->courseSubscriptions()->where('course_id', $validated['course_id'])->exists()) {
            return back()->with('error', 'Client is already enrolled in this course');
        }

        $client->courseSubscriptions()->create([
            'course_id' => $validated['course_id'],
            'payment_status' => $validated['payment_status']
        ]);

        return back()->with('success', 'Client enrolled in course successfully!');
    }

    public function registerTraining(Request $request, Client $client)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
            'payment_status' => 'required|in:pending,paid'
        ]);

        // Check if already registered
        if ($client->trainingRegistrations()->where('session_id', $validated['session_id'])->exists()) {
            return back()->with('error', 'Client is already registered for this session');
        }

        $client->trainingRegistrations()->create([
            'session_id' => $validated['session_id'],
            'payment_status' => $validated['payment_status']
        ]);

        return back()->with('success', 'Client registered for training successfully!');
    }
}