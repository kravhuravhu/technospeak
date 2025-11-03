<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\TrainingSession;
use App\Models\CourseResource;
use App\Models\ResourceType;
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
        
        // Get upcoming sessions for Group Session 1 (QA) and Group Session 2 (Consultation)
        $qaSession = TrainingSession::where('type_id', 4)
                        ->where('scheduled_for', '>', now())
                        ->orderBy('scheduled_for')
                        ->first();
                        
        $consultSession = TrainingSession::where('type_id', 5)
                        ->where('scheduled_for', '>', now())
                        ->orderBy('scheduled_for')
                        ->first();
                    
        return view('welcome', compact('courses', 'qaSession', 'consultSession'));
    }

    // load course on trainings page
    // load also the upcoming sessions
    public function trainingsPage()
    {
        $courses = Cache::remember('random_free_courses', 60, function() {
            return Course::tipsTricks()->inRandomOrder()->take(3)->get();
        });

        // recommend a random training for formal
        $recommendedTraining = Course::where('plan_type', 'frml_training')->inRandomOrder()->first();

        // Get upcoming sessions
        $groupSession1 = TrainingSession::where('type_id', 4)
                            ->where('scheduled_for', '>', now())
                            ->orderBy('scheduled_for')
                            ->with('type', 'instructor')
                            ->first();
        
        $groupSession2 = TrainingSession::where('type_id', 5)
                            ->where('scheduled_for', '>', now())
                            ->orderBy('scheduled_for')
                            ->with('type', 'instructor')
                            ->first();

        // resource "Cheatsheet"
        $cheatsheetType = ResourceType::where('name', 'Cheatsheet')->first();

        // cheatsheet resource
        $latestCheatsheet = null;
        if ($cheatsheetType) {
            $latestCheatsheet = CourseResource::where('resource_type_id', $cheatsheetType->id)
                ->latest('created_at')
                ->first();
        }

        return view('trainings', compact('courses', 'recommendedTraining', 'groupSession1', 'groupSession2', 'latestCheatsheet'));
    }

    // load instructors on about page
    public function aboutPage()
    {
        $instructors = Instructor::all();

        return view('about', compact('instructors'));
    }
}