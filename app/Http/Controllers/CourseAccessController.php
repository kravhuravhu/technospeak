<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\CourseController;
use App\Models\Course; 
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

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
}
