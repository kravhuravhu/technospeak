<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Course;
use App\Models\CourseEpisode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('admin');
    }

    public function index(Course $course)
    {
        $episodes = $course->episodes()->orderBy('episode_number')->paginate(10);
        return view('content-manager.episodes.index', compact('course', 'episodes'));
    }

    public function create(Course $course)
    {
        return view('content-manager.episodes.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'video_url' => 'required|url',
                'duration' => 'required|integer|min:1',
                'episode_number' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:'.$course->noEpisodes,
                    Rule::unique('course_episodes')->where(function ($query) use ($course) {
                        return $query->where('course_id', $course->id);
                    })
                ],
                'is_free' => 'sometimes|boolean',
            ]);

            $episode = $course->episodes()->create($validated);

            return response()->json([
                'success' => true,
                'episode' => $episode,
                'message' => 'Episode added successfully'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Validation failed'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function edit(Course $course, CourseEpisode $episode)
    {
        return view('content-manager.episodes.edit', compact('course', 'episode'));
    }

    public function update(Request $request, Course $course, CourseEpisode $episode)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_url' => 'required|url',
            'duration' => 'required|integer|min:1',
            'episode_number' => 'required|integer|min:1|max:'.$course->noEpisodes,
            'is_free' => 'boolean',
        ]);

        $episode->update($validated);

        return redirect()->route('content-manager.courses.episodes.index', $course)
            ->with('success', 'Episode updated successfully!');
    }

public function destroy(Course $course, CourseEpisode $episode)
{
    try {
        $episode->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Episode deleted successfully'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete episode: ' . $e->getMessage()
        ], 500);
    }
}
}