<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\TrainingType;
use App\Models\TrainingRegistration;
use App\Models\TrainingSession;
use App\Models\Instructor;
use App\Http\Controllers\CourseAccessController;
use Illuminate\Support\Facades\Log;

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

        // Categorize user's active plans
        $currentPlan = null;
        $groupSessions = collect();
        $formalTrainings = collect();
        
        // Check if user has premium subscription
        if ($user->subscription_type === 'premium') {
            $currentPlan = TrainingType::find(6); // Premium plan
        } else {
            $currentPlan = TrainingType::find(7); // Free plan (only if not premium)
        }
        
        // Get completed group sessions (types 4 and 5)
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
        
        // Get completed formal trainings (type 1)
        $formalTrainings = TrainingRegistration::with('session.type')
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
        
        // Get available plans (all plans except current plan and completed sessions)
        $excludedIds = collect([$currentPlan->id])
            ->merge($groupSessions->pluck('id'))
            ->merge($formalTrainings->pluck('id'))
            ->unique()
            ->toArray();
        
        $availablePlans = $allTrainingTypes->filter(function($plan) use ($excludedIds) {
            return !in_array($plan->id, $excludedIds);
        });

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
            'formalTrainings' => $formalTrainings,
            'availablePlans' => $availablePlans
        ]);
    }
}