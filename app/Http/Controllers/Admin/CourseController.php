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

        $categories = CourseCategory::all();
            
        return view('content-manager.courses.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = CourseCategory::all();
        $instructors = Instructor::all();
        return view('content-manager.courses.create', compact('categories', 'instructors'));
    }

    public function store(Request $request)
    {
        \Log::info('Course creation started', ['request' => $request->all()]);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:course_categories,id',
            'instructor_id' => 'required|exists:instructors,id',
            'description' => 'required|string',
            'catch_phrase' => 'required|string|max:90',
            'plan_type' => 'required|in:free,paid',
            'level' => 'required|in:beginner,intermediate,advanced,expert,all levels',
            'thumbnail' => 'required|url',
            'software_app_icon' => 'required|url',
            'noEpisodes' => 'required|integer|min:1',
            'total_duration' => 'required|integer|min:1',
            'episodes' => 'required|array|min:1',
            'episodes.*.title' => 'required|string|max:255',
            'episodes.*.description' => 'required|string',
            'episodes.*.video_url' => 'required|url',
            'episodes.*.duration' => 'required|string',
            'episodes.*.episode_number' => 'required|integer|min:1',
        ]);

        \DB::beginTransaction();
        try {
            \Log::debug('Creating course with data:', $validatedData);
            
            $course = Course::create([
                'title' => $validatedData['title'],
                'category_id' => $validatedData['category_id'],
                'instructor_id' => $validatedData['instructor_id'],
                'description' => $validatedData['description'],
                'catch_phrase' => $validatedData['catch_phrase'],
                'plan_type' => $validatedData['plan_type'],
                'level' => $validatedData['level'],
                'thumbnail' => $validatedData['thumbnail'],
                'software_app_icon' => $validatedData['software_app_icon'],
                'total_duration' => $validatedData['total_duration'],
                'noEpisodes' => $validatedData['noEpisodes'],
            ]);

            \Log::info('Course created', ['course_id' => $course->id]);

            foreach ($validatedData['episodes'] as $episodeData) {
                $durationInMinutes = ceil((int)explode(':', $episodeData['duration'])[0] * 60 + (int)explode(':', $episodeData['duration'])[1]) / 60;
                
                $episode = $course->episodes()->create([
                    'title' => $episodeData['title'],
                    'description' => $episodeData['description'],
                    'episode_number' => $episodeData['episode_number'],
                    'duration' => $durationInMinutes,
                    'video_url' => $episodeData['video_url'],
                ]);
                
                \Log::debug('Episode created', ['episode_id' => $episode->id]);
            }

            \DB::commit();
            
            \Log::info('Course creation completed successfully');
            
            return redirect()->route('content-manager.courses.index')
                ->with('success', 'Course created successfully!');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Course creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()
                ->with('error', 'Failed to create course. Error: ' . $e->getMessage());
        }
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