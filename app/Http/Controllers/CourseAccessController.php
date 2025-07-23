<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\CourseController;
use App\Models\Course; 
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CourseRating;

class CourseAccessController extends Controller
{
    protected $adminCourseController;

    public function __construct()
    {
        $currentGuard = Auth::getDefaultDriver();
        
        // admin controller
        $this->adminCourseController = new CourseController();
        
        Auth::shouldUse($currentGuard);
    }

    // recommended trainings
    public function getrecommendedCourses()
    {
        $user = Auth::user();
        $recommendedCourses = collect();

        // Get enrolled courses
        $enrolledCourses = $user->courseSubscriptions()->pluck('course_id');

        // based on preferred
        if ($user->preferred_category_id) {
            $recommendedCourses = Course::where('category_id', $user->preferred_category_id)
                ->whereNotIn('id', $enrolledCourses)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        }

        // random if no preferred
        if ($recommendedCourses->count() < 4) {
            $additionalCourses = Course::whereNotIn('id', $enrolledCourses)
                ->whereNotIn('id', $recommendedCourses->pluck('id'))
                ->inRandomOrder()
                ->limit(4 - $recommendedCourses->count())
                ->get();

            $recommendedCourses = $recommendedCourses->merge($additionalCourses);
        }

        return $recommendedCourses;
    }

    public function getFreeCourses()
    {
        $user = Auth::user();
        
        $courses = $this->adminCourseController->trainingCallFree()
            ->map(function($course) use ($user) {
                $course['is_enrolled'] = $user->isSubscribedTo($course['id']);
                return $course;
            });
            
        return $courses;
    }

    public function getPaidCourses()
    {
        $user = Auth::user();
        
        $courses = $this->adminCourseController->trainingCallPaid()
            ->map(function($course) use ($user) {
                $course['is_enrolled'] = $user->isSubscribedTo($course['id']);
                return $course;
            });
            
        return $courses;
    }

    public function enroll()
    {
        try {
            $request = request();
            $courseId = $request->input('course_id');
            $user = Auth::user();
            
            // Validate course exists
            $course = Course::findOrFail($courseId);
            
            // Check if already enrolled
            if ($user->isSubscribedTo($courseId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already enrolled in this course'
                ], 409);
            }

            if ($course->plan_type === 'paid') {
                return $this->handlePaidEnrollment($user, $course);
            }
            
            $subscription = $user->courseSubscriptions()->create([
                'course_id' => $courseId,
                'payment_status' => 'free',
                'current_episode_id' => $course->episodes()->orderBy('episode_number')->value('id')
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully enrolled in the course',
                'subscription' => $subscription
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error during enrollment: ' . $e->getMessage()
            ], 500);
        }
    }

    private function handlePaidEnrollment($user, $course)
    {
        if ($user->hasActiveSubscription()) {
            $subscription = $user->courseSubscriptions()->create([
                'course_id' => $course->id,
                'payment_status' => 'paid',
                'current_episode_id' => $course->episodes()->orderBy('episode_number')->value('id')
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully enrolled in the premium course',
                'subscription' => $subscription
            ]);
        }
        
        return response()->json([
            'success' => false,
            'redirect' => route('stripe.checkout', [
                'clientId' => $user->id,
                'planId' => 'premium_plan'
            ]),
            'message' => 'Payment required for premium courses'
        ]);
    }

    // view enrolled courses
    public function show(Course $course)
    {
        $user = Auth::user();

        if (!$user->isSubscribedTo($course->id)) {
            abort(403, 'You are not enrolled in this course');
        }

        $totalSeconds = $course->total_duration;
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;
        
        $formattedDuration = ($hours > 0 ? "{$hours}h" : "") . ($minutes > 0 ? "{$minutes}m" : "") . "{$seconds}s";

        $subscription = $user->courseSubscriptions()->where('course_id', $course->id)->first();
        $progress = $subscription ? $subscription->progress : 0;
        $completedEpisodes = $subscription->completedEpisodes ?? collect();

        $episodes = $course->episodes->map(function($episode) use ($completedEpisodes) {
            $duration = $episode->duration;
            $h = floor($duration / 3600);
            $m = floor(($duration % 3600) / 60);
            $s = $duration % 60;
            
            $durationFormatted = ($h > 0 ? "{$h}h" : "") . ($m > 0 ? "{$m}m" : "") . "{$s}s";

            return [
                'id' => $episode->id,
                'number' => $episode->episode_number,
                'title' => $episode->title,
                'description' => $episode->description,
                'duration' => $durationFormatted,
                'video_url' => $episode->video_url,
                'completed' => $completedEpisodes->contains($episode->id),
                'is_free' => $episode->is_free
            ];
        });

        return view('enrolled-courses.show', compact('course', 'subscription'));

    }

    public function markEpisodeCompleted(Course $course, CourseEpisode $episode)
    {
        $user = Auth::user();
        
        // Verify user is enrolled in this course
        if (!$user->isSubscribedTo($course->id)) {
            abort(403, 'You are not enrolled in this course');
        }

        // Verify episode belongs to this course
        if ($episode->course_id !== $course->id) {
            abort(400, 'Episode does not belong to this course');
        }

        $subscription = $user->courseSubscriptions()
            ->where('course_id', $course->id)
            ->first();

        // Mark episode as completed
        $subscription->completedEpisodes()->syncWithoutDetaching([$episode->id]);

        // Update progress
        $completedCount = $subscription->completedEpisodes()->count();
        $totalEpisodes = $course->episodes()->count();
        $progress = round(($completedCount / $totalEpisodes) * 100);

        $subscription->update(['progress' => $progress]);

        return response()->json([
            'success' => true,
            'progress' => $progress,
            'message' => 'Episode marked as completed'
        ]);
    }

    // course/epidode progress
    public function updateProgress(Request $request, Course $course, CourseEpisode $episode)
    {
        $validated = $request->validate([
            'watched_seconds' => 'required|integer|min:0',
            'is_completed' => 'sometimes|boolean'
        ]);

        $subscription = Auth::user()->courseSubscriptions()
            ->where('course_id', $course->id)
            ->firstOrFail();

        $duration = $episode->duration;
        $watchedSeconds = min($validated['watched_seconds'], $duration);
        $progressPercent = round(($watchedSeconds / $duration) * 100);

        $progress = $subscription->episodeProgress()->updateOrCreate(
            ['episode_id' => $episode->id],
            [
                'watched_seconds' => $watchedSeconds,
                'progress_percent' => $progressPercent,
                'is_completed' => $validated['is_completed'] ?? false,
                'last_played_at' => now(),
                'completed_at' => $validated['is_completed'] ?? false ? now() : null
            ]
        );

        // overall progress
        $totalEpisodes = $course->episodes()->count();
        $completedEpisodes = $subscription->episodeProgress()->where('is_completed', true)->count();
        $overallProgress = round(($completedEpisodes / $totalEpisodes) * 100);

        $subscription->update(['progress' => $overallProgress]);

        return response()->json([
            'success' => true,
            'progress' => $progress,
            'overall_progress' => $overallProgress
        ]);
    }

    public function destroy(Course $course)
    {
        $user = Auth::user();

        if (!$user->isSubscribedTo($course->id)) {
            abort(403, 'You are not enrolled in this course');
        }

        $subscription = $user->courseSubscriptions()
            ->where('course_id', $course->id)
            ->firstOrFail();

        $subscription->delete();

        return redirect()->route('dashboard')
            ->with('toast', [
                'type' => 'success',
                'message' => 'Successfully unenrolled from ' . $course->title
            ]);
    }

    // user comments
    public function getComments(Course $course)
    {
        $comments = $course->comments()
            ->with(['client', 'replies.client'])
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return response()->json($comments);
    }

    public function addComment(Request $request, Course $course)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:course_comments,id'
        ]);

        $comment = $course->comments()->create([
            'client_id' => Auth::id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content']
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment->load('client')
        ]);
    }

    // course certifications
    public function getCertificate(Course $course)
    {
        $subscription = Auth::user()->courseSubscriptions()
            ->where('course_id', $course->id)
            ->where('completed', true)
            ->first();

        if (!$subscription) {
            abort(404, 'No certificate available');
        }

        $certificate = $subscription->certificate;

        if (!$certificate) {
            abort(404, 'This course does not provide a certificate');
        }

        return response()->json($certificate);
    }

    // course rating
    public function getRatings(Course $course)
    {

        $ratings = $course->ratings()
            ->with('client')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'average' => $course->ratings()->avg('rating'),
            'count' => $course->ratings()->count(),
            'user_rating' => $course->ratings()->where('client_id', Auth::id())->first(),
            'all_ratings' => $ratings
        ]);
    }

    public function submitRating(Request $request, Course $course)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000'
        ]);

        $rating = $course->ratings()->updateOrCreate(
            ['client_id' => Auth::id()],
            ['rating' => $validated['rating'], 'review' => $validated['review']]
        );

        return response()->json([
            'success' => true,
            'rating' => $rating
        ]);
    }

    public function updateRating(Request $request, Course $course, CourseRating $rating)
    {
        if ($rating->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($rating->course_id !== $course->id) {
            abort(400, 'Rating does not belong to this course');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000'
        ]);

        $rating->update([
            'rating' => $validated['rating'],
            'review' => $validated['review']
        ]);

        return response()->json([
            'success' => true,
            'rating' => $rating
        ]);
    }
}
