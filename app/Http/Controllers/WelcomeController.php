<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])
                    ->where('plan_type', 'free')
                    ->latest()
                    ->take(6)
                    ->get();
                    
        return view('welcome', compact('courses'));
    }

    public function trainingsPage()
    {
        $courses = Cache::remember('random_free_courses', 60, function() {
            return Course::free()->inRandomOrder()->take(3)->get();
        });

        $recommendedTraining = Course::where('plan_type', 'paid')->inRandomOrder()->first();

        return view('trainings', compact('courses', 'recommendedTraining'));
    }
}