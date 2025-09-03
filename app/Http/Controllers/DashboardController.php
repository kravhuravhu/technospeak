<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

        // enrolled formal trainigs
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

        // Get user's active plans
        $activePlans = collect([TrainingType::find(7)]); // Free plan is always active

        if ($user->subscription_type === 'premium') {
            $activePlans->push(TrainingType::find(6));
        }

        // Get completed trainings and add to active plans
        $completedTrainings = TrainingRegistration::with('session.type')
            ->where('client_id', $user->id)
            ->where('payment_status', 'completed')
            ->get()
            ->map(function($reg) {
                return $reg->session->type;
            })
            ->filter()
            ->unique('id');

        $activePlans = $activePlans->merge($completedTrainings);

        // Get available plans (all plans except those user is already subscribed to)
        $availablePlans = $allTrainingTypes->filter(function($plan) use ($activePlans) {
            return !$activePlans->contains('id', $plan->id);
        });

        return view('dashboard', [
            'allTipsTricks' => $allTipsTricks,
            'formalTrainings' => $formalTrainings,
            'tipsAndTricksCurrent' => $tipsAndTricksCurrent,
            'formalTrainingCurrent' => $formalTrainingCurrent,
            'recommendedCourses' => $recommendedCourses,
            'instructors' => Instructor::all(),
            'upcomingGroupSessions' => TrainingSession::getUpcomingGroupSessions(),
            'activePlans' => $activePlans,
            'availablePlans' => $availablePlans,
            'allTrainingTypes' => $allTrainingTypes
        ]);
    }
}