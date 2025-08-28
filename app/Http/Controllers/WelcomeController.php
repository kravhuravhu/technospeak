<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    // load courses on the welcome page
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])
                    ->where('plan_type', 'free')
                    ->latest()
                    ->take(6)
                    ->get();
                    
        return view('welcome', compact('courses'));
    }

    // load course on trainigs page
    public function trainingsPage()
    {
        $courses = Cache::remember('random_free_courses', 60, function() {
            return Course::tipsTricks()->inRandomOrder()->take(3)->get();
        });

        $recommendedTraining = Course::where('plan_type', 'frml_training')->inRandomOrder()->first();

        return view('trainings', compact('courses', 'recommendedTraining'));
    }

    // load instructors on about page
    public function aboutPage()
    {
        $instructors = Instructor::all();

        return view('about', compact('instructors'));
    }
}