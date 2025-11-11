<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\GenerateCertificate;
use App\Models\Course; 
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CourseRating;
use App\Models\CourseEpisode;
use App\Models\CourseResource;
use App\Models\CourseCertificate;
use App\Models\TrainingType;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\ClientCourseSubscription;
use Illuminate\Support\Facades\Http;
use App\Notifications\PaymentProcessed;
use App\Notifications\CertificateIssuedNotification;

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

    // price for the logged user
    public function getSubscriptionPrice()
    {
        $user = Auth::user();

        $trainingType = TrainingType::where('name', 'Premium')->first();

        if (!$trainingType) {
            return null;
        }

        if (!$user) {
            return $trainingType->professional_price;
        }

        return $trainingType->getPriceForUserType($user->userType);
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

    public function getTipsTricks()
    {
        $user = Auth::user();
        
        $courses = $this->adminCourseController->trainingCallTipsTricks()
            ->map(function($course) use ($user) {
                $course['is_enrolled'] = $user->isSubscribedTo($course['id']);
                return $course;
            });
            
        return $courses;
    }

    public function getFormalTrainings()
    {
        $user = Auth::user();
        
        $courses = $this->adminCourseController->trainingCallFormal()
            ->map(function($course) use ($user) {
                // Check if $course is an array or object and get the ID accordingly
                $courseId = is_array($course) ? $course['id'] : $course->id;
                
                $course['is_enrolled'] = $user->isSubscribedTo($courseId);
                
                // Check if user has paid for this formal training
                $course['has_paid'] = self::hasPaidForCourse($user->id, $courseId);
                
                // Get payment details if paid
                if ($course['has_paid']) {
                    $payment = Payment::where('client_id', $user->id)
                        ->where('payable_type', 'course')
                        ->where('payable_id', $courseId)
                        ->where('status', 'completed')
                        ->first();
                    
                    $course['payment_details'] = $payment ? [
                        'transaction_id' => $payment->transaction_id,
                        'amount' => $payment->amount,
                        'payment_date' => $payment->created_at,
                        'payment_method' => $payment->payment_method
                    ] : null;
                }
                
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

            $course = Course::where('uuid', $courseId)->firstOrFail();

            if ($user->isSubscribedTo($course->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have access to this training. Open it from your Dashboard to continue.',
                    'open_url' => url('/enrolled-courses/' . $course->uuid),
                ], 409);
            }

            if(($course->plan_type === 'frml_training') && (!$user->isSubscribedTo($course->id))) {
                // Check if user has already paid for this formal training
                $hasPaid = self::hasPaidForCourse($user->id, $course->id);
                
                if ($hasPaid) {
                    // User has paid, create subscription and redirect to course
                    $subscription = $user->courseSubscriptions()->create([
                        'course_id' => $course->id,
                        'course_uuid' => $course->uuid,
                        'payment_status' => 'formal_payment',
                        'current_episode_id' => $course->episodes()->orderBy('episode_number')->value('id'),
                        'started_at' => now(),
                        'last_accessed_at' => now()
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Successfully enrolled, redirecting...',
                        'subscription' => $subscription,
                        'open_url' => url('/enrolled-courses/'.$course->uuid),
                    ]);
                } else {
                    // User hasn't paid, redirect to details page first
                    return response()->json([
                        'success' => true,
                        'message' => 'Redirecting to course details',
                        'open_url' => url('/unenrolled-courses/'.$course->uuid),
                    ]);
                }
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
                'message' => 'Successfully enrolled, redirecting...',
                'subscription' => $subscription,
                'open_url' => url('/enrolled-courses/'.$course->uuid),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error during enrollment: ' . $e->getMessage()
            ], 500);
        }
    }

    // view enrolled courses
    public function show(Course $course)
    {
        $user = Auth::user();

        if (!$user->isSubscribedTo($course->id)) {
            return redirect()->route('unenrolled-courses.show', $course->uuid);
        } else {
            if (($course->plan_type === 'free' || ($course->plan_type === 'paid')) && !$user->hasActiveSubscription()) {
                // access to only the first episode
                $accessibleEpisodes = $course->episodes->take(1);
            } else {
                $accessibleEpisodes = $course->episodes;
            }

            $totalSeconds = $course->total_duration;
            $hours = floor($totalSeconds / 3600);
            $minutes = floor(($totalSeconds % 3600) / 60);
            $seconds = $totalSeconds % 60;
            
            $formattedDuration = ($hours > 0 ? "{$hours}h" : "") . ($minutes > 0 ? "{$minutes}m" : "") . "{$seconds}s";

            $subscription = $user->courseSubscriptions()->where('course_id', $course->id)->first();
            $progress = $subscription ? $subscription->progress : 0;

            // Remove the completed episode IDs logic since the table doesn't exist
            // $completedEpisodeIds = $subscription && $subscription->episodeProgress()
            //     ? $subscription->episodeProgress()
            //         ->where('is_completed', true)
            //         ->pluck('episode_id')
            //     : collect();

            // For now, we'll assume no episodes are completed to avoid errors
            $completedEpisodeIds = collect();

            $episodes = $accessibleEpisodes->map(function($episode) use ($completedEpisodeIds) {
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
                    'locked' => false
                ];
            });

            if (($course->plan_type === 'free' || ($course->plan_type === 'paid')) && !$user->hasActiveSubscription() && $course->episodes->count() > 1) {
                $lockedEpisodes = $course->episodes->slice(1)->map(function($episode) {
                    return [
                        'id' => $episode->id,
                        'number' => $episode->episode_number,
                        'title' => $episode->title,
                        'description' => $episode->description,
                        'duration' => '',
                        'video_url' => null,
                        'completed' => false,
                        'locked' => true
                    ];
                });
                
                $episodes = $episodes->merge($lockedEpisodes);
            }

            $showCertificateTab = $course->has_certificate;
            $certificate = $subscription ? $subscription->certificate : null;

            $resources = $course->resources()->get();

            $trainingType = TrainingType::where('name', 'Premium')->first();
            if ($trainingType) {
                $price = $user
                    ? $trainingType->getPriceForUserType($user->userType)
                    : $trainingType->professional_price;
            } else {
                $price = null;
            }

            return view('enrolled-courses.show', compact(
                'course', 
                'subscription', 
                'showCertificateTab', 
                'certificate', 
                'resources', 
                'completedEpisodeIds', 
                'episodes', 
                'progress',
                'user',
                'price'
            ));
        }
    }

    // view while unenrolled
    public function showUnenrolled(Course $course)
    {
        $user = Auth::user();

        if (!$user) {
            return view('unenrolled-courses.show', $course->uuid);
        }

        $hasFormalPayment = self::hasPaidForCourse($user->id, $course->id);

        if ($hasFormalPayment) {
            return redirect()->route('enrolled-courses.show', $course->uuid);
        }

        $course->load(['category', 'instructor', 'episodes' => function($query) {
            $query->orderBy('episode_number');
        }]);

        $course->resources_count = $course->resources()->count();
        $course->episodes_count = $course->episodes()->count();

        $hasActiveSubscription = $user->hasActiveSubscription();

        return view('unenrolled-courses.show', [
            'course' => $course,
            'hasActiveSubscription' => $hasActiveSubscription,
            'user' => $user,
            'hasFormalPayment' => $hasFormalPayment,
        ]);
    }

    public function markEpisodeCompleted(Course $course, CourseEpisode $episode)
    {
        $user = Auth::user();
        
        if (!$user->isSubscribedTo($course->id)) {
            abort(403, 'You are not enrolled in this course');
        }

        if ($episode->course_id !== $course->id) {
            abort(400, 'Episode does not belong to this course');
        }

        $subscription = $user->courseSubscriptions()
            ->where('course_uuid', $course->uuid)
            ->first();

        if (!$subscription) {
            abort(404, 'Subscription not found');
        }

        $subscription->episodeProgress()->updateOrCreate(
            ['episode_id' => $episode->id],
            ['is_completed' => true, 'completed_at' => now()]
        );

        // Update progress
        $completedCount = $subscription->episodeProgress()->where('is_completed', true)->count();
        $totalEpisodes = $course->episodes()->count();
        $progress = $totalEpisodes > 0 ? round(($completedCount / $totalEpisodes) * 100) : 0;

        $subscription->update(['progress' => $progress]);

        // if course is completed
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
        \Log::info("updateProgress started for user {$user->id}, course {$course->id}, episode {$episode->id}");

        $subscription = $user->courseSubscriptions()
            ->where('course_uuid', $course->uuid)
            ->firstOrFail();

        $duration = $episode->duration;
        $watchedSeconds = min($validated['watched_seconds'], $duration);
        $progressPercent = round(($watchedSeconds / $duration) * 100);

        // Since you don't have course_episode_progress table,
        // we'll update the subscription directly
        if ($progressPercent > 0) {
            $subscription->update([
                'current_episode_id' => $episode->id,
                'last_accessed_at' => now()
            ]);
        }

        // Update overall course progress based on watched seconds
        // This is a simplified calculation - you might want to implement more sophisticated logic
        $totalWatched = $watchedSeconds; // Simplified - you might want to track total watched differently
        $totalDuration = $course->total_duration;

        $overallProgress = $totalDuration > 0
            ? round(($totalWatched / $totalDuration) * 100)
            : 0;

        $subscription->update([
            'progress' => $overallProgress,
            'last_accessed_at' => now()
        ]);

        \Log::info("User {$user->id} progress updated. Episode {$episode->id} progress={$progressPercent}, overall={$overallProgress}");

        $certificateUrl = null;

        if ($overallProgress >= 100) {
            $subscription->markAsCompleted();
            \Log::info("Course {$course->id} marked completed for subscription {$subscription->id}");

            $userFullname  = $user->name . ' ' . $user->surname;
            
            $instrfirstInitial = strtoupper(substr($course->instructor->name, 0, 1));
            $instrlastName = ucfirst($course->instructor->surname);
            $instructorSign = $instrfirstInitial . '. ' . $instrlastName;

            $certificateId = 'CERT-' . strtoupper(substr(uniqid(), 0, 10));
            $generatedAt   = now(); 

            try {
                // generate the certificate
                $certificateUrl = GenerateCertificate::generate(
                    $userFullname, 
                    $subscription->id, 
                    $course->id, 
                    $course->title,
                    $instructorSign,
                    $generatedAt,
                    $certificateId,
                );
                \Log::info("Certificate generated successfully at {$certificateUrl}");

                // save to DB
                CourseCertificate::create([
                    'course_id'       => $course->id,
                    'subscription_id' => $subscription->id,
                    'client_id'       => $user->id,
                    'certificate_id'  => $certificateId,
                    'certificate_url' => $certificateUrl,
                    'issued_at'       => now(),
                ]);

                \Log::info("Certificate record saved in DB for user {$user->id}, subscription {$subscription->id}");
                
                // Send notification
                $user->notify(new CertificateIssuedNotification(
                    $userFullname,
                    $course->title,
                    $certificateUrl
                ));
                \Log::info("Certificate email notification sent to user {$user->email}");
            } catch (\Throwable $e) {
                \Log::error("Certificate generation failed: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            }
        }

        return response()->json([
            'success' => true,
            'progress' => $progressPercent,
            'overall_progress' => $overallProgress,
            'certificate_url' => $certificateUrl,
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

    // overall for tracking all enrolled progress
    public function getOverallProgressData()
    {
        $user = Auth::user();

        // only formal trainings
        $subscriptions = $user->courseSubscriptions()
            ->with('course')
            ->get()
            ->filter(function($subscription) {
                return $subscription->course && $subscription->course->plan_type === 'frml_training';
            });

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

        // Set message and level
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

    public function showPaymentForm(Course $course)
    {
        $user = Auth::user();
        
        // Check if user has already paid for this course
        $hasPaid = Payment::where('client_id', $user->id)
            ->where('payable_type', 'course')
            ->where('payable_id', $course->id)
            ->where('status', 'completed')
            ->exists();
            
        if ($hasPaid) {
            return redirect()->route('enrolled-courses.show', $course->uuid)
                ->with('info', 'You have already purchased this training');
        }
        
        return view('formal-training.yoco-payment', [
            'course' => $course,
            'client' => $user,
            'price' => $course->price
        ]);
    }

    public function processYocoPayment(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'token' => 'required|string',
        ]);

        $client = Auth::user();
        $course = Course::findOrFail($request->course_id);
        
        // Check for duplicate payment
        if ($this->hasDuplicateCoursePayment($client, $course->id)) {
            $errorMessage = $this->getDuplicateCoursePaymentMessage($course);
            
            Log::warning("Duplicate course payment attempt prevented", [
                'client_id' => $client->id,
                'course_id' => $course->id,
                'message' => $errorMessage
            ]);
            
            return back()->with('error', $errorMessage);
        }

        $amount = $course->price;

        Log::info("Formal training payment attempt for client {$client->id}, course {$course->id}, amount R$amount, status pending");

        try {
            // Process payment with Yoco
            $response = Http::withHeaders([
                'X-Auth-Secret-Key' => env('YOCO_TEST_SECRET_KEY'),
            ])->post('https://online.yoco.com/v1/charges/', [
                'token' => $request->token,
                'amountInCents' => intval($amount * 100),
                'currency' => 'ZAR',
            ]);

            $data = $response->json();

            if (isset($data['error'])) {
                Log::error("Yoco error for client {$client->id}: " . $data['error']['message']);
                return back()->with('error', $data['error']['message']);
            }

            // Create payment record after successful charge
            $payment = Payment::create([
                'transaction_id' => $data['id'],
                'client_id' => $client->id,
                'amount' => $amount,
                'payment_method' => 'card',
                'status' => $data['status'] === 'successful' ? 'completed' : 'failed',
                'payable_type' => 'course',
                'payable_id' => $course->id,
                'metadata' => json_encode([
                    'user_type' => $client->userType,
                    'course_title' => $course->title,
                    'payment_processor' => 'yoco',
                    'yoco_response' => $data
                ])
            ]);

            if ($payment->status === 'completed') {
                // Create or update course subscription
                $subscription = ClientCourseSubscription::updateOrCreate(
                    [
                        'client_id' => $client->id,
                        'course_id' => $course->id
                    ],
                    [
                        'course_uuid' => $course->uuid,
                        'payment_status' => 'formal_payment',
                        'payment_id' => $payment->id,
                        'current_episode_id' => $course->episodes()->orderBy('episode_number')->value('id'),
                        'started_at' => now(),
                        'last_accessed_at' => now()
                    ]
                );

                // Send notification
                try {
                    $client->notify(new PaymentProcessed($payment, 'success'));
                } catch (\Exception $e) {
                    Log::error("Failed to send payment notification: " . $e->getMessage());
                }

                Log::info("Formal training payment successful for client {$client->id}, transaction {$payment->transaction_id}");

                return redirect()->route('formal.training.payment.success', ['payment' => $payment->id])
                    ->with('success', 'Payment successful! You now have access to the training.');

            } else {
                Log::warning("Formal training payment failed for client {$client->id}");
                return redirect()->route('formal.training.payment.failed', ['payment' => $payment->id])
                    ->with('error', 'Payment failed. Please try again.');
            }

        } catch (\Exception $e) {
            Log::error("Formal training payment failed for client {$client->id}: " . $e->getMessage());
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function paymentSuccess($paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $course = Course::findOrFail($payment->payable_id);
            $client = Client::findOrFail($payment->client_id);
            
            return view('formal-training.payment-success', [
                'course' => $course,
                'payment' => $payment,
                'client' => $client,
                'payment_amount' => $payment->amount,
                'transaction_id' => $payment->transaction_id
            ]);
        } catch (\Exception $e) {
            Log::error("Error loading payment success page: " . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('success', 'Payment successful! You now have access to the training.');
        }
    }
    
    public function paymentFailed($paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            return view('formal-training.payment-failed', [
                'payment' => $payment
            ]);
        } catch (\Exception $e) {
            Log::error("Error loading payment failed page: " . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('error', 'Payment failed. Please try again.');
        }
    }
    
    public static function hasPaidForCourse($clientId, $courseId)
    {
        return Payment::where('client_id', $clientId)
            ->where('payable_type', 'course')
            ->where('payable_id', $courseId)
            ->where('status', 'completed')
            ->exists();
    }

    private function hasDuplicateCoursePayment($client, $courseId)
    {
        return Payment::where([
            'client_id' => $client->id,
            'payable_type' => 'course',
            'payable_id' => $courseId,
            'status' => 'completed'
        ])->exists();
    }

    private function getDuplicateCoursePaymentMessage($course)
    {
        return "You have already purchased the formal training: '{$course->title}'. " .
            "Duplicate payments for the same training are not allowed.";
    }

    public function processYocoEftPayment(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $client = Auth::user();
        $course = Course::findOrFail($request->course_id);
        
        // Check for duplicate payment
        if ($this->hasDuplicateCoursePayment($client, $course->id)) {
            $errorMessage = $this->getDuplicateCoursePaymentMessage($course);
            
            Log::warning("Duplicate course EFT payment attempt prevented", [
                'client_id' => $client->id,
                'course_id' => $course->id,
                'message' => $errorMessage
            ]);
            
            return back()->with('error', $errorMessage);
        }

        $amount = $course->price;

        Log::info("Formal training EFT payment attempt for client {$client->id}, course {$course->id}, amount R$amount, status pending");

        try {
            // Create EFT checkout with Yoco payments API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('YOCO_TEST_SECRET_KEY'),
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ])->post('https://payments.yoco.com/api/checkouts', [
                'amount' => intval($amount * 100),
                'currency' => 'ZAR',
                'successUrl' => route('formal.training.yoco.eft.success', ['course_id' => $course->id, 'client_id' => $client->id]),
                'cancelUrl' => route('formal.training.yoco.eft.cancel'),
                'paymentMethods' => ['eft'],
                'processingMode' => 'test',
                'customer' => [
                    'email' => $client->email,
                    'name'  => $client->name . ' ' . $client->surname,
                ],
                'metadata' => [
                    'course_id' => $course->id,
                    'client_id' => $client->id,
                    'course_title' => $course->title,
                    'user_type' => $client->userType
                ]
            ]);

            $data = $response->json();
            Log::info('Yoco EFT checkout response for course: ', $data);

            if (!isset($data['redirectUrl'])) {
                Log::error("Yoco EFT checkout failed - no redirect URL", [
                    'response' => $data,
                    'client_id' => $client->id
                ]);
                return back()->with('error', 'Failed to create EFT payment link. Please try again.');
            }

            // Create pending payment record
            $payment = Payment::create([
                'transaction_id' => $data['id'] ?? 'pending_' . uniqid(),
                'client_id' => $client->id,
                'amount' => $amount,
                'payment_method' => 'eft',
                'status' => 'pending',
                'payable_type' => 'course',
                'payable_id' => $course->id,
                'metadata' => json_encode([
                    'user_type' => $client->userType,
                    'course_title' => $course->title,
                    'payment_processor' => 'yoco',
                    'yoco_response' => $data,
                    'calculated_price' => $amount,
                    'payment_type' => 'eft',
                    'checkout_id' => $data['id'],
                    'redirect_url' => $data['redirectUrl']
                ])
            ]);

            Log::info("EFT payment initiated for course {$course->id}, client {$client->id}, checkout ID: {$data['id']}");

            // Redirect to Yoco EFT payment page
            return redirect()->away($data['redirectUrl']);

        } catch (\Exception $e) {
            Log::error("Formal training EFT payment failed for client {$client->id}: " . $e->getMessage());
            return back()->with('error', 'EFT payment failed: ' . $e->getMessage());
        }
    }

    public function handleEftSuccess(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'client_id' => 'required|exists:clients,id',
            'checkoutId' => 'nullable|string',
        ]);

        $client = Client::findOrFail($request->client_id);
        $course = Course::findOrFail($request->course_id);

        try {
            // Find the pending payment
            $payment = Payment::where('client_id', $client->id)
                ->where('payable_type', 'course')
                ->where('payable_id', $course->id)
                ->where('status', 'pending')
                ->where('payment_method', 'eft')
                ->latest()
                ->first();

            if (!$payment) {
                Log::error("No pending EFT payment found for client {$client->id}, course {$course->id}");
                return redirect()->route('formal.training.payment.form', $course)
                    ->with('error', 'Payment record not found. Please contact support.');
            }

            // Verify payment status with Yoco
            $paymentStatus = $this->verifyYocoEftPayment($payment);

            if ($paymentStatus['status'] === 'completed') {
                // Update payment status to completed
                $payment->update([
                    'status' => 'completed',
                    'transaction_id' => $paymentStatus['transaction_id'] ?? $payment->transaction_id,
                    'metadata' => json_encode(array_merge(
                        json_decode($payment->metadata, true) ?? [],
                        [
                            'processed_at' => now()->toDateTimeString(),
                            'yoco_verification' => $paymentStatus
                        ]
                    ))
                ]);

                // Create or update course subscription
                $subscription = ClientCourseSubscription::updateOrCreate(
                    [
                        'client_id' => $client->id,
                        'course_id' => $course->id
                    ],
                    [
                        'course_uuid' => $course->uuid,
                        'payment_status' => 'formal_payment',
                        'payment_id' => $payment->id,
                        'current_episode_id' => $course->episodes()->orderBy('episode_number')->value('id'),
                        'started_at' => now(),
                        'last_accessed_at' => now()
                    ]
                );

                // Send notification
                try {
                    $client->notify(new PaymentProcessed($payment, 'success'));
                } catch (\Exception $e) {
                    Log::error("Failed to send EFT payment notification: " . $e->getMessage());
                }

                Log::info("EFT formal training payment successful for client {$client->id}, transaction {$payment->transaction_id}");

                return redirect()->route('formal.training.payment.success', ['payment' => $payment->id])
                    ->with('success', 'EFT payment successful! You now have access to the training.');

            } else {
                // Payment still pending or failed
                $payment->update([
                    'status' => $paymentStatus['status'],
                    'metadata' => json_encode(array_merge(
                        json_decode($payment->metadata, true) ?? [],
                        [
                            'verification_attempt' => now()->toDateTimeString(),
                            'verification_status' => $paymentStatus['status']
                        ]
                    ))
                ]);

                if ($paymentStatus['status'] === 'pending') {
                    return view('formal-training.payment-pending', [
                        'payment' => $payment,
                        'client' => $client,
                        'course' => $course,
                        'pollingUrl' => route('formal.training.yoco.eft.status', ['payment' => $payment->id])
                    ]);
                } else {
                    return redirect()->route('formal.training.payment.failed', ['payment' => $payment->id])
                        ->with('error', 'EFT payment verification failed.');
                }
            }

        } catch (\Exception $e) {
            Log::error("EFT success callback error for course: " . $e->getMessage());
            return redirect()->route('formal.training.payment.form', $course)
                ->with('error', 'Error processing EFT payment: ' . $e->getMessage());
        }
    }

    public function checkEftPaymentStatus(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $client = Auth::user();

        // Verify the payment belongs to the authenticated user
        if ($payment->client_id !== $client->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $verificationResult = $this->verifyYocoEftPayment($payment);

        if ($verificationResult['status'] === 'completed') {
            // Process successful payment
            $payment->update(['status' => 'completed']);
            
            $client = Client::find($payment->client_id);
            $course = Course::find($payment->payable_id);
            
            // Create subscription
            ClientCourseSubscription::updateOrCreate(
                [
                    'client_id' => $client->id,
                    'course_id' => $course->id
                ],
                [
                    'course_uuid' => $course->uuid,
                    'payment_status' => 'formal_payment',
                    'payment_id' => $payment->id,
                    'current_episode_id' => $course->episodes()->orderBy('episode_number')->value('id'),
                    'started_at' => now(),
                    'last_accessed_at' => now()
                ]
            );

            try {
                $client->notify(new PaymentProcessed($payment, 'success'));
            } catch (\Exception $e) {
                Log::error("Failed to send EFT payment notification: " . $e->getMessage());
            }

            return response()->json([
                'status' => 'completed',
                'redirect' => route('formal.training.payment.success', ['payment' => $payment->id])
            ]);

        } elseif ($verificationResult['status'] === 'failed') {
            $payment->update(['status' => 'failed']);
            return response()->json([
                'status' => 'failed',
                'redirect' => route('formal.training.payment.failed', ['payment' => $payment->id])
            ]);
        }

        return response()->json(['status' => 'pending']);
    }

    public function handleEftCancel(Request $request)
    {
        $client = Auth::user();
        
        // Find and update any pending EFT payments for this user
        Payment::where('client_id', $client->id)
            ->where('status', 'pending')
            ->where('payment_method', 'eft')
            ->where('payable_type', 'course')
            ->update(['status' => 'cancelled']);

        Log::info("EFT payment cancelled by client {$client->id} for course");

        return redirect()->route('dashboard')
            ->with('error', 'EFT payment was cancelled. You can try again anytime.');
    }

    private function verifyYocoEftPayment($payment)
    {
        try {
            $metadata = json_decode($payment->metadata, true);
            $checkoutId = $metadata['checkout_id'] ?? null;

            if (!$checkoutId) {
                return ['status' => 'failed', 'error' => 'No checkout ID found'];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('YOCO_TEST_SECRET_KEY'),
                'Accept'        => 'application/json',
            ])->get("https://payments.yoco.com/api/checkouts/{$checkoutId}");

            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] === 'completed') {
                    return [
                        'status' => 'completed',
                        'transaction_id' => $data['id'],
                        'amount' => $data['amount'] / 100,
                        'currency' => $data['currency'],
                        'payment_method' => 'eft'
                    ];
                } elseif (in_array($data['status'], ['pending', 'processing'])) {
                    return ['status' => 'pending'];
                } else {
                    return ['status' => 'failed'];
                }
            }

            return ['status' => 'pending'];

        } catch (\Exception $e) {
            Log::error("Error verifying Yoco EFT payment: " . $e->getMessage());
            return ['status' => 'pending', 'error' => $e->getMessage()];
        }
    }

}