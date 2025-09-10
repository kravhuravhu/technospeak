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

        // 1. Your current plan (only premium if subscribed, otherwise free)
        $currentPlan = null;
        if ($user->subscription_type === 'premium') {
            $currentPlan = TrainingType::find(6); // Premium plan
        } else {
            $currentPlan = TrainingType::find(7); // Free plan (only if not premium)
        }
        
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
        
        // 4. Available product plans (all plans except current plan and completed sessions)
        // Task Assistance (2) and Personal Guide (3) should always be available
        $alwaysAvailableIds = [2, 3]; // Task Assistance and Personal Guide
        
        $excludedIds = collect([$currentPlan->id])
            ->merge($groupSessions->pluck('id'))
            ->merge($formalTrainingsRegistered->pluck('id'))
            ->unique()
            ->reject(function($id) use ($alwaysAvailableIds) {
                return in_array($id, $alwaysAvailableIds);
            })
            ->toArray();
        
        $availablePlans = $allTrainingTypes->filter(function($plan) use ($excludedIds, $alwaysAvailableIds) {
            return !in_array($plan->id, $excludedIds) || in_array($plan->id, $alwaysAvailableIds);
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
            'formalTrainingsRegistered' => $formalTrainingsRegistered,
            'availablePlans' => $availablePlans
        ]);
    }
}