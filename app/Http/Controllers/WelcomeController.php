<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class WelcomeController extends Controller
{
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])
                    ->latest()
                    ->take(6)
                    ->get();
                    
        return view('welcome', compact('courses'));
    }
}