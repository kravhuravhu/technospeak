<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('admin');
    }

    public function index()
    {
        $courses = Course::with(['category', 'instructor'])
            ->withCount('episodes')
            ->latest()
            ->paginate(10);
            
        return view('content-manager.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = CourseCategory::all();
        $instructors = Instructor::all();
        return view('content-manager.courses.create', compact('categories', 'instructors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:course_categories,id',
            'instructor_id' => 'required|exists:instructors,id',
            'description' => 'required|string',
            'catch_phrase' => 'required|string|max:90',
            'plan_type' => 'required|in:free,paid',
            'price' => 'required_if:plan_type,paid|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced,expert,all levels',
            'thumbnail' => 'required|url',
            'software_app_icon' => 'required|url',
            'total_duration' => 'required|integer|min:1',
            'noEpisodes' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        Course::create($validated);

        return redirect()->route('content-manager.courses.index')
            ->with('success', 'Course created successfully!');
    }

    public function show(Course $course)
    {
        return view('content-manager.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = CourseCategory::all();
        $instructors = Instructor::all();
        return view('content-manager.courses.edit', compact('course', 'categories', 'instructors'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:course_categories,id',
            'instructor_id' => 'required|exists:instructors,id',
            'description' => 'required|string',
            'catch_phrase' => 'required|string|max:90',
            'plan_type' => 'required|in:free,paid',
            'price' => 'required_if:plan_type,paid|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced,expert,all levels',
            'thumbnail' => 'required|url',
            'software_app_icon' => 'required|url',
            'total_duration' => 'required|integer|min:1',
            'noEpisodes' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $course->update($validated);

        return redirect()->route('content-manager.courses.index')
            ->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('content-manager.courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}