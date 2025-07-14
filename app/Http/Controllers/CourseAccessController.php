<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\CourseController;
use App\Models\Course; 
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
}
