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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with(['preferredCategory'])
            ->latest('registered_date')
            ->where('status', 'active')
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
            ->where('created_at', '>', now()) 
            ->take(5)
            ->get();

        $trainingSessions = TrainingSession::all();

        return view('content-manager.clients.show', compact('client', 'courses', 'trainings', 'trainingSessions'));
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

    public function enrollCourse(Request $request, Client $client)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'payment_status' => 'required|in:free,paid'
        ]);

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

        if ($client->trainingRegistrations()->where('session_id', $validated['session_id'])->exists()) {
            return back()->with('error', 'Client is already registered for this session');
        }

        $client->trainingRegistrations()->create([
            'session_id' => $validated['session_id'],
            'payment_status' => $validated['payment_status']
        ]);

        return back()->with('success', 'Client registered for training successfully!');
    }

    public function destroyEnrollment(Request $request)
    {
        $subscription = \App\Models\ClientCourseSubscription::find($request->input('subscription_id'));

        if (!$subscription) {
            return back()->with('error', 'Subscription not found');
        }

        $subscription->delete();

        return back()->with('success', 'Enrollment removed');
    }

    public function destroy(Client $client)
    {
        if ($client->courseSubscriptions()->exists() || 
            $client->trainingRegistrations()->exists() || 
            $client->payments()->exists()) {

            // archive the client, don't delete
            $client->status = 'archived';
            $client->archived_at = now();
            $client->email = $client->email . '.arch_' . time();
            $client->save();

            return back()->with('success', 'Client archived instead of deleted due to existing activity.');
        }

        if (auth('web')->check() && auth('web')->id() === $client->id) {
            auth('web')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        Cache::forget('client_' . $client->id);

        $client->delete();

        return redirect()->route('content-manager.clients.clients')
            ->with('success', 'Client deleted successfully!');
    }

    public function archived()
    {
        $archivedClients = Client::where('status', '!=', 'active')
            ->with('preferredCategory')
            ->get()
            ->map(function($client) {
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'surname' => $client->surname,
                    'email' => $client->email,
                    'userType' => $client->userType ?? 'Unknown',
                    'preferredCategory' => $client->preferredCategory ? $client->preferredCategory->name : 'Unset',
                    'archived_at' => $client->archived_at ? $client->archived_at->format('Y-m-d H:i:s') : null
                ];
            });

        return response()->json([
            'archivedClients' => $archivedClients
        ]);
    }
}