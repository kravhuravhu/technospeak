<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TrainingType;
use App\Models\TrainingRegistration;
use App\Models\TrainingSession;
use App\Models\Instructor;
use App\Models\Payment;
use App\Models\ClientCourseSubscription;
use App\Http\Controllers\CourseAccessController;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use Carbon\Carbon;

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

        // 2. Your group sessions (types 4 and 5 that user has registered for) - ENHANCED LOGIC
        $groupSessions = $this->getUserGroupSessionsWithDetails($user);
        
        // 3. Your formal trainings - ENHANCED LOGIC with detailed information
        $formalTrainingsRegistered = $this->getUserFormalTrainingsWithDetails($user);

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
            'filteredCategory' => $filteredCategory // to pass to view
        ]);
    }

    protected function getUserGroupSessionsWithDetails($user)
    {
        if (!$user) {
            return collect();
        }

        // Get completed payments for group sessions (types 4 and 5)
        $paidGroupSessions = Payment::where('client_id', $user->id)
            ->where('status', 'completed')
            ->where('payable_type', 'training')
            ->whereHasMorph('payable', [TrainingSession::class], function($query) {
                $query->whereIn('type_id', [4, 5]); // Group Session 1 & 2
            })
            ->with(['payable' => function($query) {
                $query->with(['type', 'instructor', 'category']);
            }])
            ->get()
            ->map(function($payment) {
                $session = $payment->payable;
                if (!$session) return null;
                
                $isActive = $session->scheduled_for >= now();
                $status = $isActive ? 'upcoming' : 'completed';
                
                return [
                    'id' => $session->id,
                    'type_id' => $session->type_id,
                    'name' => $session->title,
                    'description' => $session->description,
                    'type_name' => $session->type->name,
                    'category_name' => $session->category->name ?? 'General',
                    'instructor_name' => $session->instructor->name ?? 'Technospeak Team',
                    'scheduled_for' => $session->scheduled_for,
                    'from_time' => $session->from_time,
                    'to_time' => $session->to_time,
                    'formatted_date' => Carbon::parse($session->scheduled_for)->format('M d, Y'),
                    'formatted_time' => Carbon::parse($session->from_time)->format('g:i A') . ' - ' . Carbon::parse($session->to_time)->format('g:i A'),
                    'student_price' => $session->type->student_price,
                    'professional_price' => $session->type->professional_price,
                    'payment_date' => $payment->created_at,
                    'formatted_payment_date' => Carbon::parse($payment->created_at)->format('M d, Y'),
                    'transaction_id' => $payment->transaction_id,
                    'is_active' => $isActive,
                    'status' => $status,
                    'max_participants' => $session->max_participants,
                    'duration' => $session->formatted_duration
                ];
            })
            ->filter() // Remove nulls
            ->sortBy('scheduled_for') // Sort by date
            ->values();

        return $paidGroupSessions;
    }

    protected function getUserFormalTrainingsWithDetails($user)
    {
        if (!$user) {
            return collect();
        }

        // Get formal trainings from two sources:
        // 1. Training sessions (traditional formal training registrations)
        // 2. Course purchases (formal training courses)
        
        $formalTrainings = collect();

        // Source 1: Traditional training sessions (type 1 - Formal Training)
        $paidFormalSessions = Payment::where('client_id', $user->id)
            ->where('status', 'completed')
            ->where('payable_type', 'training')
            ->whereHasMorph('payable', [TrainingSession::class], function($query) {
                $query->where('type_id', 1); // Formal Training
            })
            ->with(['payable' => function($query) {
                $query->with(['type', 'instructor', 'category']);
            }])
            ->get()
            ->map(function($payment) {
                $session = $payment->payable;
                if (!$session) return null;
                
                $isActive = $session->scheduled_for >= now();
                $status = $isActive ? 'upcoming' : 'completed';
                
                return [
                    'id' => $session->id,
                    'type_id' => $session->type_id,
                    'name' => $session->title,
                    'description' => $session->description,
                    'type_name' => $session->type->name,
                    'category_name' => $session->category->name ?? 'General',
                    'instructor_name' => $session->instructor->name ?? 'Technospeak Team',
                    'scheduled_for' => $session->scheduled_for,
                    'from_time' => $session->from_time,
                    'to_time' => $session->to_time,
                    'formatted_date' => Carbon::parse($session->scheduled_for)->format('M d, Y'),
                    'formatted_time' => Carbon::parse($session->from_time)->format('g:i A') . ' - ' . Carbon::parse($session->to_time)->format('g:i A'),
                    'student_price' => $session->type->student_price,
                    'professional_price' => $session->type->professional_price,
                    'payment_date' => $payment->created_at,
                    'formatted_payment_date' => Carbon::parse($payment->created_at)->format('M d, Y'),
                    'transaction_id' => $payment->transaction_id,
                    'is_active' => $isActive,
                    'status' => $status,
                    'max_participants' => $session->max_participants,
                    'duration' => $session->formatted_duration,
                    'source' => 'training_session'
                ];
            })
            ->filter()
            ->values(); // Reset keys

        // Source 2: Formal training courses (plan_type = 'frml_training')
        $paidFormalCourses = Payment::where('client_id', $user->id)
            ->where('status', 'completed')
            ->where('payable_type', 'course')
            ->whereHasMorph('payable', [Course::class], function($query) {
                $query->where('plan_type', 'frml_training'); // Formal Training courses
            })
            ->with(['payable' => function($query) {
                $query->with(['category', 'instructor']);
            }])
            ->get()
            ->map(function($payment) use ($user) {
                $course = $payment->payable;
                if (!$course) return null;

                // For courses, we consider them "active" if not completed
                $subscription = ClientCourseSubscription::where('client_id', $user->id)
                    ->where('course_id', $course->id)
                    ->first();
                
                $isActive = $subscription && $subscription->progress < 100;
                $status = $isActive ? 'upcoming' : 'completed';
                
                return [
                    'id' => $course->id,
                    'type_id' => 1, // Map to Formal Training type
                    'name' => $course->title,
                    'description' => $course->description,
                    'type_name' => 'Formal Training',
                    'category_name' => $course->category->name ?? 'General',
                    'instructor_name' => $course->instructor->name ?? 'Technospeak Team',
                    'scheduled_for' => $course->created_at, // Use course creation date
                    'from_time' => '00:00:00',
                    'to_time' => '23:59:59',
                    'formatted_date' => Carbon::parse($course->created_at)->format('M d, Y'),
                    'formatted_time' => 'Self-paced',
                    'student_price' => $course->price,
                    'professional_price' => $course->price,
                    'payment_date' => $payment->created_at,
                    'formatted_payment_date' => Carbon::parse($payment->created_at)->format('M d, Y'),
                    'transaction_id' => $payment->transaction_id,
                    'is_active' => $isActive,
                    'status' => $status,
                    'max_participants' => 1, // Individual course
                    'duration' => $course->formatted_duration,
                    'source' => 'course',
                    'course_uuid' => $course->uuid,
                    'progress' => $subscription ? $subscription->progress : 0
                ];
            })
            ->filter()
            ->values(); // Reset keys

        // Combine both sources using array_merge instead of Eloquent merge
        $formalTrainings = collect(array_merge($paidFormalSessions->toArray(), $paidFormalCourses->toArray()))
            ->sortBy('scheduled_for') // Sort by date
            ->values();

        return $formalTrainings;
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
            
            // For group sessions (4,5), check if user has already registered for ACTIVE sessions
            if (in_array($plan->id, [4, 5])) {
                $hasActiveRegistration = $groupSessions->contains(function($session) use ($plan) {
                    return $session['type_id'] == $plan->id && $session['is_active'];
                });
                if (!$hasActiveRegistration) {
                    $availablePlans->push($plan);
                }
                continue;
            }
            
            // For formal training (1), check if user has any ACTIVE formal training (from either source)
            if ($plan->id == 1) {
                $hasActiveFormalTraining = $formalTrainingsRegistered->contains('is_active', true);
                if (!$hasActiveFormalTraining) {
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