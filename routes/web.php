<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\TrainingSessionController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\TrainingRegistrationController;
use App\Http\Controllers\CourseAccessController;
use App\Http\Controllers\Admin\CourseResourceController;
use App\Models\Instructor;
use App\Models\Client;
use App\Models\TrainingSession;
use App\Models\TrainingRegistration;
use App\Models\Payment;
use App\Models\TrainingType;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Middleware\AdminOrInstructorAuth;
use App\Http\Controllers\SubmissionController;
use App\Models\CourseResource;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestingPayment;

// Public routes
Route::get('/', [
    WelcomeController::class, 'index'
]);

Route::get('/about', [
    WelcomeController::class, 'aboutPage'
])->name('about');

Route::get('/trainings', [
    WelcomeController::class, 'trainingsPage'
]);

Route::get('/pricing', function () {
    $premiumPlan = \App\Models\TrainingType::find(6); 
    $services = \App\Models\TrainingType::whereIn('id', [1, 2, 3, 4, 5])->get();
    return view('pricing', [
        'premiumPlan' => $premiumPlan,
        'services' => $services
    ]);
});

Route::get('/privacy', function () { return view('privacy'); });
Route::get('/terms', function () { return view('terms'); });

// Training registration
Route::post('/training/register', [TrainingRegistrationController::class, 'store'])->name('training.register');

// Subscription routes
Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe')
->middleware('auth');

Route::get('/subscription/free', [SubscriptionController::class, 'subscribeFree'])
    ->name('subscription.subscribe.free')
    ->middleware('auth');

// Auth routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // view enrolled
    Route::prefix('enrolled-courses')->group(function () {
        Route::get('/{course}', [CourseAccessController::class, 'show'])->name('enrolled-courses.show');
        Route::delete('/{course}', [CourseAccessController::class, 'destroy'])->name('enrolled-courses.destroy');

    Route::post('/{course}/episodes/{episode}/complete', 
        [CourseAccessController::class, 'markEpisodeCompleted'])
        ->name('enrolled-courses.episodes.complete');
    });

    // update
    Route::post('/enrolled-courses/{course}/episodes/{episode}/progress', [CourseAccessController::class, 'updateProgress'])
        ->name('enrolled-courses.episodes.progress');

    // view all free/paid resource
    Route::get('/api/user/data', function() {
        $user = Auth::user();
        return response()->json([
            'subscription_type' => $user->subscription_type,
            'name' => $user->name
        ]);
    });

    Route::get('/api/resources/all', function() {
        $resources = CourseResource::with('category')->get()->map(function($resource) {
            return [
                'id' => $resource->id,
                'title' => $resource->title,
                'description' => $resource->description,
                'thumbnail_url' => $resource->thumbnail_url,
                'file_url' => $resource->file_url,
                'file_type' => $resource->file_type,
                'category' => $resource->category ? [
                    'id' => $resource->category->id,
                    'name' => $resource->category->name
                ] : null
            ];
        });

        return response()->json($resources);
    });

    // view while unenrolled
    Route::prefix('unenrolled-courses')->group(function () {
        Route::get('/{course}', [CourseAccessController::class, 'showUnenrolled'])->name('unenrolled-courses.show');
    });
    
    // rating & cert
    Route::prefix('api/courses/{course}')->group(function() {
        Route::get('/ratings', [CourseAccessController::class, 'getRatings']);
        Route::post('/ratings', [CourseAccessController::class, 'submitRating']);
        Route::put('/ratings/{rating}', [CourseAccessController::class, 'updateRating']);
    });

    // Enrollments
    Route::delete('client-courses/delete', [ClientController::class, 'destroyEnrollment'])->name('content-manager.client-courses.destroy');

    // Email Verification
    Route::post('/email/verify/send', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('status', 'email-already-verified');
        }
        $request->user()->sendEmailVerificationNotification();
        
        return redirect()->route('dashboard')->with('status', 'verification-link-sent');
    })->middleware(['auth'])->name('custom.verification.send');
 
    Route::post('/onboarding/complete', [PreferenceController::class, 'set'])->name('completeOnboarding');
    Route::get('/skip-onboarding', function () {
        session(['skipped_preference' => true, 'skipped_userType' => true]);
        return redirect()->back();
    })->name('skipOnboarding');
   
    // Profile routes
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // report/feedback
    Route::post('/submit-support/{type}', [SubmissionController::class, 'supportFeedbackSubmit'])->name('submit.support');

    // Subscription routes
    Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe'])
    ->name('subscription.subscribe')
    ->middleware('auth');

    Route::post('/subscription/unsubscribe', [SubscriptionController::class, 'unsubscribe'])
    ->name('subscription.unsubscribe')
    ->middleware('auth');

    Route::get('/subscription/free', [SubscriptionController::class, 'subscribeFree'])
    ->name('subscription.subscribe.free')
    ->middleware('auth');

    Route::post('/courses/enroll', [CourseAccessController::class, 'enroll'])
    ->middleware('auth')
    ->name('courses.enroll');

    Route::get('/stripe/subscription/success', [StripeController::class, 'subscriptionSuccess'])
    ->name('stripe.subscription.success')
    ->middleware('auth');
 
    // Payment routes
    Route::prefix('stripe')->group(function () {
        Route::get('/checkout/{clientId}/{planId}', [StripeController::class, 'checkout'])
            ->name('stripe.checkout')
            ->middleware('auth');

        Route::post('/webhook', [StripeWebhookController::class, 'handle']);

        // Separate success handlers
        Route::get('/success', [StripeController::class, 'success'])->name('stripe.success'); // For training sessions
        Route::get('/subscription/success', [StripeController::class, 'subscriptionSuccess'])
            ->name('stripe.subscription.success')
            ->middleware('auth');

        // Yoco payment routes
        Route::prefix('yoco')->group(function () {
            Route::get('/payment/verify/{payment}', [SubscriptionController::class, 'verifyPayment'])
                ->name('yoco.payment.verify')
                ->middleware('auth');

            Route::get('/payment/status/{payment}', [SubscriptionController::class, 'checkPaymentStatus'])
                ->name('yoco.payment.status')
                ->middleware('auth');

            Route::get('/payment/success/{payment}', function($paymentId) {
                $payment = Payment::findOrFail($paymentId);
                return view('success-subscription', [
                    'plan' => TrainingType::find($payment->payable_id),
                    'payment_amount' => $payment->amount,
                    'transaction_id' => $payment->transaction_id,
                    'client' => Client::find($payment->client_id)
                ]);
            })->name('yoco.payment.success')->middleware('auth');

            Route::get('/payment/failed/{payment}', function($paymentId) {
                $payment = Payment::findOrFail($paymentId);
                return view('payment.failed', ['payment' => $payment]);
            })->name('yoco.payment.failed')->middleware('auth');

            Route::get('/payment/cancel/{payment}', function($paymentId) {
                $payment = Payment::findOrFail($paymentId);
                $payment->update(['status' => 'cancelled']);
                
                return redirect()->route('dashboard')
                    ->with('error', 'Payment was cancelled.');
            })->name('yoco.payment.cancel')->middleware('auth');
        });

        // Yoco webhook route
        //Route::post('/api/yoco/webhook', [YocoWebhookController::class, 'handleWebhook']);

        // Yoco payment redirect
        Route::get('/subscription/yoco/redirect', [SubscriptionController::class, 'redirectToYoco'])
            ->name('subscription.yoco.redirect')
            ->middleware('auth');

        // Yoco training payment routes
        Route::prefix('yoco')->group(function () {
            // Training payment verification
            Route::get('/training/verify/{payment}', [TrainingRegistrationController::class, 'verifyTrainingPayment'])
                ->name('yoco.training.verify')
                ->middleware('auth');

            Route::get('/training/status/{payment}', [TrainingRegistrationController::class, 'checkTrainingPaymentStatus'])
                ->name('yoco.training.status')
                ->middleware('auth');

            Route::get('/training/success/{payment}', function($paymentId) {
                $payment = Payment::findOrFail($paymentId);
                $session = TrainingSession::find($payment->payable_id);
                
                return view('success-payment', [
                    'trainingSession' => $session,
                    'payment' => $payment
                ]);
            })->name('yoco.training.success')->middleware('auth');

            Route::get('/training/failed/{payment}', function($paymentId) {
                $payment = Payment::findOrFail($paymentId);
                return view('payment.failed', ['payment' => $payment]);
            })->name('yoco.training.failed')->middleware('auth');

            Route::get('/training/cancel/{payment}', function($paymentId) {
                $payment = Payment::findOrFail($paymentId);
                $payment->update(['status' => 'cancelled']);
                
                return redirect()->route('dashboard')
                    ->with('error', 'Payment was cancelled.');
            })->name('yoco.training.cancel')->middleware('auth');
        });
    });
    
    // Add API route for registration check
    Route::get('/api/check-registration/{typeId}', function($typeId) {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['registered' => false]);
        }
        
        // Check if user has any completed registrations for this type
        $registered = Payment::where('client_id', $user->id)
            ->where('payable_type', 'training')
            ->whereHas('payable', function($query) use ($typeId) {
                $query->where('type_id', $typeId);
            })
            ->where('status', 'completed')
            ->exists();
        
        return response()->json(['registered' => $registered]);
    })->middleware('auth');
});

require __DIR__.'/auth.php';
 
// Admin routes
Route::prefix('content')->name('content-manager.')->group(function() {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    Route::middleware([AdminOrInstructorAuth::class])->group(function () {
        Route::get('admin', [AdminController::class, 'admin'])->name('admin');
        
        // Courses
        Route::resource('courses', CourseController::class);
        Route::resource('courses.episodes', EpisodeController::class);

        // Course Resources
        Route::resource('resource', CourseResourceController::class)
            ->names([
                'destroy' => 'resource.destroy',
            ]);
                
        // Course cate
        Route::resource('categories', CourseCategoryController::class)->except(['show']);
        
        // Clients
        Route::resource('clients', ClientController::class)
            ->names([
                'index' => 'clients.clients',
                'create' => 'clients.create',
                'store' => 'clients.store',
                'show' => 'clients.show',
                'edit' => 'clients.edit',
                'update' => 'clients.update',
                'destroy' => 'clients.destroy',
                //'archived' => 'clients.archived'
            ]);
        Route::get('clients/archived/json', [ClientController::class, 'archived'])
            ->name('clients.archived.json');
        Route::post('clients/{client}/enroll-course', [ClientController::class, 'enrollCourse'])->name('clients.enroll-course');
        Route::post('clients/{client}/register-training', [ClientController::class, 'registerTraining'])->name('clients.register-training');
                
        // Episode
        Route::resource('content-manager/courses.episodes', EpisodeController::class)
            ->names([
                'index' => 'content-manager.courses.episodes.index',
                'create' => 'content-manager.courses.episodes.create',
                'store' => 'content-manager.courses.episodes.store',
                'show' => 'content-manager.courses.episodes.show',
                'edit' => 'content-manager.courses.episodes.edit',
                'update' => 'content-manager.courses.episodes.update',
                'destroy' => 'content-manager.courses.episodes.destroy'
        ]);
        
        // Payments
        Route::prefix('payments')->group(function() {
            Route::get('/', [PaymentsController::class, 'index'])->name('payments.index');
            Route::get('/create', [PaymentsController::class, 'create'])->name('payments.create');
            Route::post('/', [PaymentsController::class, 'store'])->name('payments.store');
            Route::get('/{payment}', [PaymentsController::class, 'show'])->name('payments.show');
            Route::post('/{payment}/approve', [PaymentsController::class, 'approve'])->name('payments.approve');
            
            // AJAX endpoints
            Route::get('/get-items', [PaymentsController::class, 'getItems'])->name('payments.get-items');
            Route::get('/calculate-amount', [PaymentsController::class, 'calculateAmount'])->name('payments.calculate-amount');
        });
        
        // trainings
        Route::resource('trainings', TrainingSessionController::class);
        Route::get('trainings/{training}/registrations', [TrainingSessionController::class, 'registrations'])->name('trainings.registrations');
        Route::post('trainings/{training}/mark-attendance', [TrainingSessionController::class, 'markAttendance'])->name('trainings.mark-attendance');
        
        // more features
        Route::prefix('other-features')->name('other-features.')->group(function() {
            Route::get('/', [\App\Http\Controllers\Admin\OtherFeaturesController::class, 'index'])
                ->name('index');
            
            // other features routes
            Route::resource('instructors', \App\Http\Controllers\Admin\InstructorController::class)
                ->names([
                    'index' => 'instructors.index',
                    'create' => 'instructors.create',
                    'store' => 'instructors.store',
                    'edit' => 'instructors.edit',
                    'update' => 'instructors.update',
                    'destroy' => 'instructors.destroy'
                ]);
                
            Route::resource('categories', \App\Http\Controllers\Admin\CourseCategoryController::class)
                ->names([
                    'index' => 'categories.index',
                    'create' => 'categories.create',
                    'store' => 'categories.store',
                    'show' => 'categories.show',
                    'edit' => 'categories.edit',
                    'update' => 'categories.update',
                    'destroy' => 'categories.destroy'
                ]);
                
            Route::resource('resource-types', \App\Http\Controllers\Admin\ResourceTypeController::class)
                ->names([
                    'index' => 'resource-types.index',
                    'create' => 'resource-types.create',
                    'store' => 'resource-types.store',
                    'show' => 'resource-types.show',
                    'edit' => 'resource-types.edit',
                    'update' => 'resource-types.update',
                    'destroy' => 'resource-types.destroy'
                ]);
                
            Route::resource('training-types', \App\Http\Controllers\Admin\TrainingTypeController::class)
                ->names([
                    'index' => 'training-types.index',
                    'create' => 'training-types.create',
                    'store' => 'training-types.store',
                    'show' => 'training-types.show',
                    'edit' => 'training-types.edit',
                    'update' => 'training-types.update',
                    'destroy' => 'training-types.destroy'
                ]);
        });

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

// success payment
Route::get('/success-payment', function() {
    return view('success-payment'); 
})->name('payment.success');

// clear-cache
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return response()->json(['message' => 'Cache cleared']);
});

// user requests submission
Route::post('/submit/{type}', [SubmissionController::class, 'submit'])->name('submit.generic');

// my yoco test
Route::middleware('auth')->group(function () {
    Route::get('/testing-yoco', [TestingPayment::class, 'show'])->name('testing.yoco');
    Route::post('/testing-yoco/charge', [TestingPayment::class, 'charge'])->name('testing.payment.charge');
    Route::post('/testing-yoco/eft', [TestingPayment::class, 'eft'])->name('testing.payment.eft');
});

// callbacks after EFT
Route::get('/testing-yoco/success', function () {
    return redirect()->route('testing.yoco')->with('success', 'EFT Payment successful!');
})->name('testing.payment.success');

Route::get('/testing-yoco/cancel', function () {
    return redirect()->route('testing.yoco')->with('error', 'EFT Payment cancelled.');
})->name('testing.payment.cancel');


// Yoco subscription routes
Route::get('/subscription/yoco/form', [SubscriptionController::class, 'showSubscriptionForm'])
    ->name('subscription.yoco.form')
    ->middleware('auth');

Route::post('/subscription/yoco/process', [SubscriptionController::class, 'processYocoPayment'])
    ->name('subscription.yoco.process')
    ->middleware('auth');

Route::get('/subscription/yoco/redirect', [SubscriptionController::class, 'redirectToYoco'])
    ->name('subscription.yoco.redirect')
    ->middleware('auth');

Route::get('/yoco/payment/success/{payment}', [SubscriptionController::class, 'showSuccessPage'])
    ->name('yoco.payment.success')
    ->middleware('auth');

// API endpoint for frontend validation to check subscription status
Route::get('/api/check-subscription-status/{planId}', function($planId) {
    $user = Auth::user();
    
    if (!$user) {
        return response()->json(['active' => false, 'message' => 'User not authenticated']);
    }
    
    $active = \App\Http\Controllers\SubscriptionController::hasActiveSubscription($user->id, $planId);
    
    if ($planId == 6) { // Premium plan
        $subscriptionStatus = strtolower($user->subscription_type);
        $message = $active ? 
            'You already have an active Premium subscription. Your subscription expires on ' . 
            ($user->subscription_expiry ? $user->subscription_expiry->format('M d, Y') : 'N/A') :
            'No active Premium subscription found';
    } else {
        $message = $active ? 
            'You have already purchased this subscription' : 
            'No active subscription found';
    }
    
    return response()->json([
        'active' => $active,
        'message' => $message
    ]);
})->middleware('auth');


// Yoco training payment routes
Route::post('/training/yoco/process', [TrainingRegistrationController::class, 'processYocoTrainingPayment'])
    ->name('training.yoco.process')
    ->middleware('auth');

Route::get('/training/register/{session}', [TrainingRegistrationController::class, 'showRegistrationForm'])
    ->name('training.register.form')
    ->middleware('auth');

Route::get('/training/register', [TrainingRegistrationController::class, 'showTrainingSelection'])
    ->name('training.register')
    ->middleware('auth');

// API endpoint for frontend validation
Route::get('/api/user/subscription-status', function() {
    $user = Auth::user();
    $controller = new \App\Http\Controllers\DashboardController();
    return response()->json($controller->getUserSubscriptionStatus());
})->middleware('auth');

// API endpoint for frontend validation to check if user has paid for a specific session
Route::get('/api/check-session-payment/{sessionId}', function($sessionId) {
    $user = Auth::user();
    
    if (!$user) {
        return response()->json(['paid' => false, 'message' => 'User not authenticated']);
    }
    
    $paid = \App\Http\Controllers\TrainingRegistrationController::hasPaidForSession($user->id, $sessionId);
    
    return response()->json([
        'paid' => $paid,
        'message' => $paid ? 'You have already paid for this session' : 'No payment found for this session'
    ]);
})->middleware('auth');

// Formal training payment routes
Route::get('/formal-training/payment/{course}', [CourseAccessController::class, 'showPaymentForm'])
    ->name('formal.training.payment.form')
    ->middleware('auth');

Route::post('/formal-training/yoco/process', [CourseAccessController::class, 'processYocoPayment'])
    ->name('formal.training.yoco.process')
    ->middleware('auth');

Route::get('/formal-training/payment/success/{payment}', [CourseAccessController::class, 'paymentSuccess'])
    ->name('formal.training.payment.success')
    ->middleware('auth');

Route::get('/formal-training/payment/failed/{payment}', [CourseAccessController::class, 'paymentFailed'])
    ->name('formal.training.payment.failed')
    ->middleware('auth');