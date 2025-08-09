<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\CourseController;
use App\Models\Course; 
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CourseRating;
use App\Models\CourseEpisode;
use Illuminate\Support\Facades\Log;

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

    public function getSingleRecommendedCourse()
    {
        $user = Auth::user();
        $recommendedCourse = null;

        // Get enrolled courses
        $enrolledCourses = $user->courseSubscriptions()->pluck('course_id');

        // First try based on preferred category
        if ($user->preferred_category_id) {
            $recommendedCourse = Course::where('category_id', $user->preferred_category_id)
                ->whereNotIn('id', $enrolledCourses)
                ->inRandomOrder()
                ->first();
        }

        // If no preferred category or no course found, get any random course
        if (!$recommendedCourse) {
            $recommendedCourse = Course::whereNotIn('id', $enrolledCourses)
                ->inRandomOrder()
                ->first();
        }

        return $recommendedCourse;
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
            //$course = Course::findOrFail($courseId);
            $course = Course::where('uuid', $courseId)->firstOrFail();
            
            // Check if already enrolled
            if ($user->isSubscribedTo($course->id)) { 
                return response()->json([
                    'success' => false,
                    'message' => 'You are already enrolled in this course'
                ], 409);
            }

            if ($course->plan_type === 'paid') {
                return $this->handlePaidEnrollment($user, $course);
            }

            $subscription = $user->courseSubscriptions()->create([
                'course_id' => $course->id,
                'course_uuid' => $course->uuid,
                'payment_status' => 'free',
                'current_episode_id' => $course->episodes()->orderBy('episode_number')->value('id'),
                'started_at' => now(),
                'last_accessed_at' => now()
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
                'course_uuid' => $course->uuid,
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
            return redirect()->route('unenrolled-courses.show', $course->uuid);
        } else {
            $totalSeconds = $course->total_duration;
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $seconds = $totalSeconds % 60;
            
            $formattedDuration = ($hours > 0 ? "{$hours}h" : "") . ($minutes > 0 ? "{$minutes}m" : "") . "{$seconds}s";

            $subscription = $user->courseSubscriptions()->where('course_id', $course->id)->first();
            $progress = $subscription ? $subscription->progress : 0;

            // get the episode that is completed
            $completedEpisodeIds = $subscription && $subscription->episodeProgress()
                ? $subscription->episodeProgress()
                    ->where('is_completed', true)
                    ->pluck('episode_id')
                : collect();

            $episodes = $course->episodes->map(function($episode) use ($completedEpisodeIds) {
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
                    'completed' => $completedEpisodeIds->contains($episode->id),
                    'is_free' => $episode->is_free,
                ];
            });

            $showCertificateTab = $course->has_certificate;
            $certificate = $subscription ? $subscription->certificate : null;

            $resources = $course->resources()->get();

            return view('enrolled-courses.show', compact('course', 'subscription', 'showCertificateTab', 'certificate', 'resources', 'completedEpisodeIds', 'episodes', 'progress'));
        }
    }

    // view while unenrolled
    public function showUnenrolled(Course $course)
    {
        $user = Auth::user();

        if ($user && $user->isSubscribedTo($course->id)) {
            return redirect()->route('enrolled-courses.show', $course->uuid);
        } else {
            $course->load(['category', 'instructor', 'episodes' => function($query) {
                $query->orderBy('episode_number');
            }]);

            $course->resources_count = $course->resources()->count();
            $course->episodes_count = $course->episodes()->count();

            $hasActiveSubscription = $user ? $user->hasActiveSubscription() : false;
            $payEnroll = $course->plan_type == 'paid' || $hasActiveSubscription;

            return view('unenrolled-courses.show', [
                'course' => $course,
                'payEnroll' => $payEnroll,
                'hasActiveSubscription' => $hasActiveSubscription
            ]);
        }
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
            ->where('course_uuid', $course->uuid)
            ->first();

        if (!$subscription) {
            abort(404, 'Subscription not found');
        }

        // Mark episode as completed
        $subscription->episodeProgress()->updateOrCreate(
            ['episode_id' => $episode->id],
            ['is_completed' => true, 'completed_at' => now()]
        );

        // Update progress
        $completedCount = $subscription->episodeProgress()->where('is_completed', true)->count();
        $totalEpisodes = $course->episodes()->count();
        $progress = $totalEpisodes > 0 ? round(($completedCount / $totalEpisodes) * 100) : 0;

        $subscription->update(['progress' => $progress]);

        // Check if course is completed
        if ($progress >= 100) {
            $subscription->markAsCompleted();
        }

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

        $user = Auth::user();
        
        $subscription = $user->courseSubscriptions()
            ->where('course_uuid', $course->uuid)
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

        if ($progressPercent > 0) {
            $subscription->update(['current_episode_id' => $episode->id]);
        }

        // overall course progress
        // based on watched seconds & total_duration
        $totalWatched = $subscription->episodeProgress()->sum('watched_seconds');
        $totalDuration = $course->total_duration;

        if ($totalDuration > 0) {
            $overallProgress = round(($totalWatched / $totalDuration) * 100);
        } else {
            $overallProgress = 0;
        }

        $subscription->update([
            'progress' => $overallProgress,
            'last_accessed_at' => now()
        ]);

        if ($overallProgress >= 100) {
            $subscription->markAsCompleted();
        }

        return response()->json([
            'success' => true,
            'progress' => $progress,
            'overall_progress' => $overallProgress
        ]);
    }

    // delete and can unenroll too
    public function destroy(Course $course)
    {
        $user = Auth::user();

        if (!$user->isSubscribedTo($course->id)) {
            if (request()->expectsJson()) {
                return response()->json([
                    'error' => 'You are not enrolled in this course'
                ], 403);
            }
            abort(403, 'You are not enrolled in this course');
        }

        $subscription = $user->courseSubscriptions()
            ->where('course_uuid', $course->uuid)
            ->firstOrFail();

        $subscription->episodeProgress()->delete();

        $subscription->episodeProgress()->delete();

        $subscription->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => route('dashboard'),
                'message' => 'Successfully unenrolled from ' . $course->title
            ]);
        }

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
            ->where('course_uuid', $course->uuid)
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

    // resources if enrolled
    public function getUserResources()
    {
        $user = Auth::user();

        $resources = $user->courseSubscriptions()
            ->with(['course.resources'])
            ->get()
            ->flatMap(function($subscription) {
                return $subscription->course->resources;
            })
            ->map(function($resource) {
                return [
                    'id' => $resource->id,
                    'title' => $resource->title,
                    'description' => $resource->description,
                    'thumbnail' => $resource->thumbnail_url,
                    'url' => $resource->file_url,
                    'type' => $resource->file_type,
                    'category' => $resource->category->name ?? 'Course Resource',
                    'course_id' => $resource->course_id,
                    'locked' => false
                ];
            })
            ->values();

        return response()->json($resources);
    }

    // overall for tracking all enrolled progress
    public function getOverallProgressData()
    {
        $user = Auth::user();

        $subscriptions = $user->courseSubscriptions()->with('course')->get();
        $enrolledCount = $subscriptions->count();

        if ($enrolledCount === 0) {
            return [
                'overall_progress' => 0,
                'message' => "Start your learning journey today! 🚀",
                'level' => 0,
                'courses' => []
            ];
        }

        $totalProgress = 0;

        $courses = $subscriptions->map(function ($subscription) use (&$totalProgress) {
            $course = $subscription->course;
            $progress = $subscription->progress;
            $totalProgress += $progress;

            $totalDuration = $course->total_duration;
            $watched = floor(($progress / 100) * $totalDuration);
            $left = max(0, $totalDuration - $watched);

            return [
                'uuid' => $course->uuid,
                'title' => $course->title,
                'thumbnail' => $course->thumbnail,
                'formatted_duration' => $course->formatted_duration,
                'progress' => $progress,
                'watched_seconds' => $watched,
                'left_seconds' => $left,
            ];
        });

        $averageProgress = round($totalProgress / $enrolledCount);

        // message and level
        if ($averageProgress >= 100) {
            $message = "Congratulations! 🏆 You’ve reached expert status. Keep pushing boundaries 🪵, mastering new skills, and inspiring others on your journey! 🎖️";
            $level = 4;
        } elseif ($averageProgress >= 75) {
            $message = "You’re almost there! 🌟 Keep up the amazing work 🧸 and continue refining your knowledge 🪵. Your dedication is paying off beautifully!";
            $level = 3;
        } elseif ($averageProgress >= 50) {
            $message = "Great job reaching the halfway mark! 🔥 Stay motivated 🐻 and keep building your skills steadily — the best is yet to come 🪵!";
            $level = 2;
        } elseif ($averageProgress >= 25) {
            $message = "Nice progress! 💪 Keep your momentum strong 🦫 and consistent. Every step forward brings you closer to your goals 🪵.";
            $level = 1;
        } else {
            $message = "Welcome to your learning journey! 🚀 Every expert started just like you 🧸. Take your first steps with confidence and curiosity 🍂.";
            $level = 0;
        }

        return [
            'overall_progress' => $averageProgress,
            'message' => $message,
            'level' => $level,
            'courses' => $courses->toArray(),
        ];
    }
}