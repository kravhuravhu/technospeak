<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseEpisode;
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
            'episodes.*.duration' => 'required|numeric|min:1',
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
                $durationInSeconds = (int) $episodeData['duration'];

                $episode = $course->episodes()->create([
                    'title' => $episodeData['title'],
                    'description' => $episodeData['description'],
                    'episode_number' => $episodeData['episode_number'],
                    'duration' => $durationInSeconds,
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
        \Log::info('Course update started', ['request' => $request->all()]);

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
            'episodes.*.duration' => 'required|numeric|min:1',
            'episodes.*.id' => 'nullable|integer',
            'episodes.*.episode_number' => 'required|integer|min:1',
        ]);

        \Log::debug('Raw episode data from request:', [
            'episodes' => $request->input('episodes'),
            'first_episode_id' => $request->input('episodes.1.id') ?? 'not found',
            'first_episode_data' => $request->input('episodes.1') ?? 'not found'
        ]);

        \DB::beginTransaction();
        try {
            // Update course details
            $course->update([
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

            $existingEpisodeIds = $course->episodes->pluck('id')->toArray();
            $submittedEpisodeIds = [];

            foreach ($validatedData['episodes'] as $episodeData) {
                \Log::debug('Processing episode', [
                    'id' => $episodeData['id'] ?? null,
                    'type' => (isset($episodeData['id']) && $episodeData['id'] > 0) ? 'existing' : 'new',
                    'data' => $episodeData
                ]);
                if (!isset($episodeData['id'])) {
                    continue; // Skip if no ID (shouldn't happen with our form)
                }

                // Existing episode (positive ID)
                if ($episodeData['id'] > 0) {
                    $episode = CourseEpisode::where('id', $episodeData['id'])
                        ->where('course_id', $course->id)
                        ->first();

                    if ($episode) {
                        $episode->update([
                            'title' => $episodeData['title'],
                            'description' => $episodeData['description'],
                            'episode_number' => $episodeData['episode_number'],
                            'duration' => (int) $episodeData['duration'],
                            'video_url' => $episodeData['video_url'],
                        ]);
                        $submittedEpisodeIds[] = $episode->id;
                        \Log::debug('Updated existing episode', ['id' => $episode->id]);
                    }
                } 
                // New episode (negative ID)
                else {
                    $newEpisode = $course->episodes()->create([
                        'title' => $episodeData['title'],
                        'description' => $episodeData['description'],
                        'episode_number' => $episodeData['episode_number'],
                        'duration' => (int) $episodeData['duration'],
                        'video_url' => $episodeData['video_url'],
                    ]);
                    $submittedEpisodeIds[] = $newEpisode->id;
                    \Log::debug('Created new episode', ['id' => $newEpisode->id]);
                }
            }

            // Delete episodes that were removed from the form
            $episodesToDelete = array_diff($existingEpisodeIds, $submittedEpisodeIds);
            if (!empty($episodesToDelete)) {
                CourseEpisode::where('course_id', $course->id)
                    ->whereIn('id', $episodesToDelete)
                    ->delete();
            }

            \DB::commit();
            
            return redirect()->route('content-manager.courses.index')
                ->with('success', 'Course updated successfully!');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Course update failed: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()
                ->with('error', 'Failed to update course. Error: ' . $e->getMessage());
        }
    }

    // populating to dash free
    public function trainingCallFree($limit = null)
    {
        $query = Course::with(['category', 'instructor', 'episodes'])
            ->free()
            ->latest();

        $freeCourses = ($limit ? $query->take($limit) : $query)->get()
            ->map(function ($course) {
                $totalSeconds = $course->total_duration;
                $hours = floor($totalSeconds / 3600);
                $minutes = floor(($totalSeconds % 3600) / 60);
                $seconds = $totalSeconds % 60;

                if ($hours > 0) {
                    $formattedDuration = "{$hours}h{$minutes}m{$seconds}s";
                } elseif ($minutes > 0) {
                    $formattedDuration = "{$minutes}m{$seconds}s";
                } else {
                    $formattedDuration = "0m{$seconds}s";
                }

                $episodesArray = $course->episodes->map(function ($episode) {
                    $duration = $episode->duration;
                    $h = floor($duration / 3600);
                    $m = floor(($duration % 3600) / 60);
                    $s = $duration % 60;

                    if ($h > 0) {
                        $episodeDuration = "{$h}h{$m}m{$s}s";
                    } elseif ($m > 0) {
                        $episodeDuration = "{$m}m{$s}s";
                    } else {
                        $episodeDuration = "0m{$s}s";
                    }

                    return [
                        'number' => $episode->episode_number,
                        'name' => $episode->title,
                        'duration' => $episodeDuration
                    ];
                })->toArray();

                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'thumbnail' => $course->thumbnail,
                    'formatted_duration' => $formattedDuration,
                    'level' => $course->level,
                    'instructor_name' => $course->instructor->name,
                    'category_name' => $course->category->name,
                    'episodes' => $episodesArray,
                    'episodes_count' => $course->episodes->count(),
                    'created_at' => $course->created_at
                ];
            });

        return $freeCourses;
    }

    // populating to dash paid
    public function trainingCallPaid($limit = null)
    {
        $query = Course::with(['category', 'instructor', 'episodes'])
            ->paid()
            ->latest();

        $paidCourses = ($limit ? $query->take($limit) : $query)->get()
            ->map(function ($course) {
                $totalSeconds = $course->total_duration;
                $hours = floor($totalSeconds / 3600);
                $minutes = floor(($totalSeconds % 3600) / 60);
                $seconds = $totalSeconds % 60;

                if ($hours > 0) {
                    $formattedDuration = "{$hours}h{$minutes}m{$seconds}s";
                } elseif ($minutes > 0) {
                    $formattedDuration = "{$minutes}m{$seconds}s";
                } else {
                    $formattedDuration = "0m{$seconds}s";
                }

                $episodesArray = $course->episodes->map(function ($episode) {
                    $duration = $episode->duration;
                    $h = floor($duration / 3600);
                    $m = floor(($duration % 3600) / 60);
                    $s = $duration % 60;

                    if ($h > 0) {
                        $episodeDuration = "{$h}h{$m}m{$s}s";
                    } elseif ($m > 0) {
                        $episodeDuration = "{$m}m{$s}s";
                    } else {
                        $episodeDuration = "0m{$s}s";
                    }

                    return [
                        'number' => $episode->episode_number,
                        'name' => $episode->title,
                        'duration' => $episodeDuration
                    ];
                })->toArray();

                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'thumbnail' => $course->thumbnail,
                    'formatted_duration' => $formattedDuration,
                    'level' => $course->level,
                    'instructor_name' => $course->instructor->name,
                    'category_name' => $course->category->name,
                    'price' => 'Premium Training', 
                    'episodes' => $episodesArray,
                    'episodes_count' => $course->episodes->count(),
                    'created_at' => $course->created_at
                ];
            });

        return $paidCourses;
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('content-manager.courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}