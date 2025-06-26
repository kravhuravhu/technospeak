<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function index(Course $course)
    {
        $episodes = $course->episodes()->latest()->paginate(10);
        return view('admin.episodes.index', compact('course', 'episodes'));
    }

    public function create(Course $course)
    {
        return view('admin.episodes.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_url' => 'required|url',
            'duration' => 'required|integer|min:1',
            'is_free' => 'boolean',
            'order' => 'required|integer|min:1',
        ]);

        $course->episodes()->create($validated);

        return redirect()->route('content-manager.courses.episodes.index', $course)
            ->with('success', 'Episode created successfully!');
    }

    public function show(Course $course, Episode $episode)
    {
        return view('admin.episodes.show', compact('course', 'episode'));
    }

    public function edit(Course $course, Episode $episode)
    {
        return view('admin.episodes.edit', compact('course', 'episode'));
    }

    public function update(Request $request, Course $course, Episode $episode)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_url' => 'required|url',
            'duration' => 'required|integer|min:1',
            'is_free' => 'boolean',
            'order' => 'required|integer|min:1',
        ]);

        $episode->update($validated);

        return redirect()->route('content-manager.courses.episodes.index', $course)
            ->with('success', 'Episode updated successfully!');
    }

    public function destroy(Course $course, Episode $episode)
    {
        $episode->delete();

        return redirect()->route('content-manager.courses.episodes.index', $course)
            ->with('success', 'Episode deleted successfully!');
    }
}