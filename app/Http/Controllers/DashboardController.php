<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TrainingType;
use App\Models\TrainingRegistration;
use App\Models\TrainingSession;
use App\Models\Instructor;
use App\Models\Payment;
use App\Http\Controllers\CourseAccessController;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get filtered category from request
        $filteredCategory = $request->get('category');
        
        // Get training status with proper case handling
        $userSessions = TrainingRegistration::with(['session', 'payment'])
            ->where('client_id', $user->id)
            ->get()
            ->map(function($registration) {
                return [
                    'session' => $registration->session,
                    'payment_status' => $registration->payment_status,
                    'paid' => $registration->payment_status === 'completed'
                ];
            });

        // Get subscription status with proper case handling
        $subscriptionStatus = strtolower($user->subscription_type);
        $hasActivePremium = $subscriptionStatus === 'premium' && 
                            $user->subscription_expiry && 
                            $user->subscription_expiry->isFuture();
            

        $courseAccess = new CourseAccessController();
        
        // Get all tips and tricks first
        $courseAccess = new CourseAccessController();

        // Get all tips and tricks first
        $allTipsTricks = $courseAccess->getTipsTricks();

        // Debug: Log what we're getting
        if ($filteredCategory) {
            \Log::info("Filtering tips & tricks by category: " . $filteredCategory);
            \Log::info("Total tips & tricks before filtering: " . $allTipsTricks->count());
            
            $allTipsTricks = $this->filterTipsTricksByCategory($allTipsTricks, $filteredCategory);
            
            \Log::info("Total tips & tricks after filtering: " . $allTipsTricks->count());
            
            // Also log the category names for debugging
            $categoryNames = $allTipsTricks->pluck('category_name')->unique()->toArray();
            \Log::info("Available categories in data: " . implode(', ', $categoryNames));
        }
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

        // 1. Your current plan using subscription_type from Clients table
        $currentPlan = null;
        $subscriptionStatus = strtolower($user->subscription_type);

        if ($subscriptionStatus === 'premium') {
            $currentPlan = TrainingType::find(6); // Premium plan
        } elseif ($subscriptionStatus === 'free') {
            $currentPlan = TrainingType::find(7); // Free plan
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
        
        // 3. Your formal trainings - Check payments table for completed course payments
        $formalTrainingsRegistered = Payment::where('client_id', $user->id)
            ->where('payable_type', 'course')
            ->where('status', 'completed')
            ->get()
            ->map(function($payment) {
                // Since we're dealing with formal training as a concept rather than specific courses,
                // we'll return the formal training type (ID 1)
                return TrainingType::find(1);
            })
            ->filter()
            ->unique('id');

        // 4. Available product plans - filter out plans user already has
        $availablePlans = $this->getFilteredAvailablePlans($user, $allTrainingTypes, $groupSessions, $formalTrainingsRegistered);

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
            'subscriptionStatus' => $subscriptionStatus,
            'userSessions' => $userSessions,
            'hasActivePremium' => $hasActivePremium,
            'subscriptionExpiry' => $user->subscription_expiry,
            'subscriptionPaidAt' => $user->subscription_paid_at,
            'user' => $user,
            'filteredCategory' => $filteredCategory // Add this to pass to view
        ]);
    }

    private function filterTipsTricksByCategory($allTipsTricks, $categoryName)
    {
        return $allTipsTricks->filter(function($course) use ($categoryName) {
            // Check if the course has a category and matches the filtered category
            // Use case-insensitive comparison and trim whitespace
            if (isset($course['category_name'])) {
                $courseCategory = trim($course['category_name']);
                $filterCategory = trim($categoryName);
                
                return strcasecmp($courseCategory, $filterCategory) === 0;
            }
            return false;
        });
    }

    private function getFilteredAvailablePlans($user, $allTrainingTypes, $groupSessions, $formalTrainingsRegistered)
    {
        $availablePlans = collect();
        
        // Convert to lowercase for case-insensitive comparison
        $subscriptionType = strtolower($user->subscription_type);
        $hasActivePremium = $subscriptionType === 'premium' && 
                        $user->subscription_expiry && 
                        $user->subscription_expiry->isFuture();
        
        // Check if user has paid for any formal training (course)
        $hasPaidForFormalTraining = Payment::where('client_id', $user->id)
            ->where('payable_type', 'course')
            ->where('status', 'completed')
            ->exists();
        
        foreach ($allTrainingTypes as $plan) {
            // Skip free plan (ID 7) as it should never be in available plans
            if ($plan->id == 7) {
                continue;
            }
            
            // For premium plan (ID 6), only show if user doesn't have active premium
            if ($plan->id == 6) {
                if (!$hasActivePremium) {
                    $availablePlans->push($plan);
                }
                continue;
            }
            
            // For group sessions (4,5), check if user has already registered
            if (in_array($plan->id, [4, 5])) {
                $hasRegistered = $groupSessions->contains('id', $plan->id);
                if (!$hasRegistered) {
                    $availablePlans->push($plan);
                }
                continue;
            }
            
            // For formal training (1), check if user has already paid for any course
            if ($plan->id == 1) {
                if (!$hasPaidForFormalTraining) {
                    $availablePlans->push($plan);
                }
                continue;
            }
            
            // For Task Assistance (2) and Personal Guide (3), always show
            if (in_array($plan->id, [2, 3])) {
                $availablePlans->push($plan);
                continue;
            }
        }
        
        return $availablePlans;
    }

    public function getUserSubscriptionStatus()
    {
        $user = Auth::user();
        
        // Check if user has paid for any formal training (course)
        $hasPaidForFormalTraining = Payment::where('client_id', $user->id)
            ->where('payable_type', 'course')
            ->where('status', 'completed')
            ->exists();
        
        return [
            'has_premium' => $user->subscription_type === 'premium' && 
                            $user->subscription_expiry && 
                            $user->subscription_expiry->isFuture(),
            'premium_expiry' => $user->subscription_expiry,
            'has_formal_training' => $hasPaidForFormalTraining,
            'has_group_session' => function($typeId) use ($user) {
                return TrainingRegistration::where('client_id', $user->id)
                    ->whereHas('session', function($query) use ($typeId) {
                        $query->where('type_id', $typeId);
                    })
                    ->where('payment_status', 'completed')
                    ->exists();
            }
        ];
    }
}