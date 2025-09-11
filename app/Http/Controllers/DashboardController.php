<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TrainingType;
use App\Models\TrainingRegistration;
use App\Models\TrainingSession;
use App\Models\Instructor;
use App\Http\Controllers\CourseAccessController;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $courseAccess = new CourseAccessController();
        $allTipsTricks = $courseAccess->getTipsTricks();
        $formalTrainings = $courseAccess->getFormalTrainings();
        $recommendedCourses = $courseAccess->getRecommendedCourses();

        $enrolledCourses = $user->courseSubscriptions()
            ->with(['course' => function($query) {
                $query->with(['category', 'instructor', 'episodes']);
            }])
            ->get();

        // enrolled tips & tricks
        $tipsAndTricksCurrent = $enrolledCourses->filter(function($subscription) {
            return in_array($subscription->course->plan_type, ['free', 'paid']);
        })->map(function($subscription) {
            $course = $subscription->course;
            return (object) [
                'id' => $course->id,
                'uuid' => $course->uuid,
                'title' => $course->title,
                'catch_phrase' => $course->catch_phrase,
                'thumbnail' => $course->thumbnail,
            ];
        });

        // enrolled formal trainings
        $formalTrainingCurrent = $enrolledCourses->filter(function($subscription) {
            return $subscription->course->plan_type === 'frml_training';
        })->map(function($subscription) {
            $course = $subscription->course;
            return (object) [
                'id' => $course->id,
                'uuid' => $course->uuid,
                'thumbnail' => $course->thumbnail,
                'formatted_duration' => $course->formatted_duration,
                'title' => $course->title,
                'progress' => $subscription->progress ?? 0,
            ];
        });
        
        // Get all training types
        $allTrainingTypes = TrainingType::whereIn('id', [1, 2, 3, 4, 5, 6, 7])->get();

        // 1. Your current plan using static methods
        $currentPlan = null;
        $subscriptionStatus = SubscriptionController::getSubscriptionStatus($user);

        if ($subscriptionStatus === 'active') {
            $currentPlan = TrainingType::find(6); // Premium plan
        } elseif ($subscriptionStatus === 'free' || $subscriptionStatus === 'none') {
            $currentPlan = TrainingType::find(7); // Free plan
        }

        // 4. Available product plans with improved logic
        $availablePlans = SubscriptionController::getAvailablePlans($user, $allTrainingTypes);
        
        // 2. Your group sessions (types 4 and 5 that user has registered for)
        $groupSessions = TrainingRegistration::with('session.type')
            ->where('client_id', $user->id)
            ->where('payment_status', 'completed')
            ->whereHas('session', function($query) {
                $query->whereIn('type_id', [4, 5]);
            })
            ->get()
            ->map(function($reg) {
                return $reg->session->type;
            })
            ->filter()
            ->unique('id');
        
        // 3. Your formal trainings (type 1 that user has registered for)
        $formalTrainingsRegistered = TrainingRegistration::with('session.type')
            ->where('client_id', $user->id)
            ->where('payment_status', 'completed')
            ->whereHas('session', function($query) {
                $query->where('type_id', 1);
            })
            ->get()
            ->map(function($reg) {
                return $reg->session->type;
            })
            ->filter()
            ->unique('id');

        return view('dashboard', [
            'allTipsTricks' => $allTipsTricks,
            'formalTrainings' => $formalTrainings,
            'tipsAndTricksCurrent' => $tipsAndTricksCurrent,
            'formalTrainingCurrent' => $formalTrainingCurrent,
            'recommendedCourses' => $recommendedCourses,
            'instructors' => Instructor::all(),
            'upcomingGroupSessions' => TrainingSession::getUpcomingGroupSessions(),
            'allTrainingTypes' => $allTrainingTypes,
            'currentPlan' => $currentPlan,
            'groupSessions' => $groupSessions,
            'formalTrainingsRegistered' => $formalTrainingsRegistered,
            'availablePlans' => $availablePlans,
            'subscriptionStatus' => $subscriptionStatus
        ]);
    }
}