<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Client;
use App\Models\Payment;
use App\Models\ActivityLog;
use App\Models\TrainingSession;

class AdminController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('admin');
    }

    public function admin()
    {
        $stats = [
            'coursesCount' => Course::count(),
            'activeClients' => Client::whereNotNull('email_verified_at')->count(),
            'pendingPayments' => Payment::where('status', 'pending')->count(),
        ];
        $recentClients = Client::orderBy('registered_date', 'desc')
                       ->orderBy('registered_time', 'desc')
                       ->take(5)
                       ->get();
        
        $coursesCount = \App\Models\Course::count();
        $activeClients = \App\Models\Client::whereNotNull('email_verified_at')->count();
        $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
        $trainingSessions = TrainingSession::count();

        // not yet
        // $recentActivities = ActivityLog::latest()->take(5)->get();

        // return view('content-manager.admin', compact('stats', 'recentClients', 'recentActivities'));
        return view('content-manager.admin', compact(
            'coursesCount',
            'activeClients',
            'pendingPayments',
            'trainingSessions',
            'recentClients'
        ));
    }

    public function settings()
    {
        $settings = [
            'site_name' => config('app.name'),
            'site_email' => config('mail.from.address'),
            // will add more later
        ];

        return view('content-manager.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
        ]);

        // will send to db later
        return back()->with('success', 'Settings updated successfully!');
    }
}