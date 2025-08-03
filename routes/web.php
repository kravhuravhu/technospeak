<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\TrainingSessionController;
use App\Http\Controllers\Admin\AdminIssueController;
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
use App\Http\Controllers\IssueController; 
use App\Http\Controllers\Admin\CourseResourceController;
use App\Models\Instructor;
use App\Models\TrainingSession;
use App\Http\Controllers\SubscriptionController; 
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Middleware\AdminOrInstructorAuth;

// Public routes
Route::get('/', [WelcomeController::class, 'index']);
Route::get('/about', function () { return view('about'); });
Route::get('/trainings', function () { return view('trainings'); });
Route::get('/pricing', function () { return view('pricing'); });
Route::get('/privacy', function () { return view('privacy'); });
Route::get('/terms', function () { return view('terms'); });

// Training registration
Route::post('/training/register', [TrainingRegistrationController::class, 'store'])->name('training.register');

// Subscription routes
Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe')
->middleware('auth');

Route::post('/service/purchase', [ServiceController::class, 'purchase'])
    ->name('service.purchase')
    ->middleware('auth');

Route::get('/subscription/free', [SubscriptionController::class, 'subscribeFree'])
    ->name('subscription.subscribe.free')
    ->middleware('auth');

// Auth routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        $courseAccess = new CourseAccessController();
        $freeCourses = $courseAccess->getFreeCourses();
        $paidCourses = $courseAccess->getPaidCourses();
        $recommendedCourses = $courseAccess->getrecommendedCourses();

        $enrolledCourses = $user->courseSubscriptions()
            ->with(['course' => function($query) {
                $query->with(['category', 'instructor', 'episodes']);
            }])
            ->get()
            ->map(function($subscription) {
                $course = $subscription->course;
                
                $progress = $subscription->progress_percent ?? 0;
                
                return (object) [
                    'id' => $course->id,
                    'uuid' => $course->uuid,
                    'title' => $course->title,
                    'thumbnail' => $course->thumbnail,
                    'formatted_duration' => $course->formatted_duration,
                    'progress' => $progress
                ];
            });

        // show instrs data too
        $instructors = Instructor::all();

        // get upcoming sessions
        $now = now();

        $future = TrainingSession::with('type')
            ->where('scheduled_for', '>', $now)
            ->orderBy('scheduled_for')
            ->limit(4)
            ->get();

        if ($future->count() < 4) {
            $remaining = 4 - $future->count();

            $past = TrainingSession::with('type')
                ->where('scheduled_for', '<=', $now)
                ->orderByDesc('scheduled_for')
                ->limit($remaining)
                ->get();

            $upcomingSessions = $future->concat($past);
        } else {
            $upcomingSessions = $future;
        }

        return view('dashboard', [
            'freeCourses' => $freeCourses,
            'paidCourses' => $paidCourses,
            'enrolledCourses' => $enrolledCourses,
            'recommendedCourses' => $recommendedCourses,
            'instructors' => $instructors,
            'upcomingSessions' => $upcomingSessions,
        ]);
    })->name('dashboard');

    // view enrolled
    Route::prefix('enrolled-courses')->group(function () {
        Route::get('/{course}', [CourseAccessController::class, 'show'])->name('enrolled-courses.show');
        Route::delete('/{course}', [CourseAccessController::class, 'destroy'])->name('enrolled-courses.destroy');
        Route::post('/{course}/episodes/{episode}/complete', 
            [CourseAccessController::class, 'markEpisodeCompleted'])
            ->name('enrolled-courses.episodes.complete');
    });

    // view enrolled resource
    Route::get('/api/user/resources', [CourseAccessController::class, 'getUserResources']);

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
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Issue management
    Route::get('/my-issues', [IssueController::class, 'index'])->name('issues.index');
    Route::get('/issues/{issue}', [IssueController::class, 'show'])->name('issues.show');
    Route::post('/issues', [IssueController::class, 'store'])->name('issues.store');

    // Contact section
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.submit');

    // Personal Guide routes
    Route::post('/personal-guide', [PersonalGuideController::class, 'store'])->name('personal-guide.store');
    Route::post('/personal-guide/{id}/process-payment', [PersonalGuideController::class, 'processPayment'])->name('personal-guide.payment');
    
    // Task Assistance routes
    Route::post('/task-assistance', [TaskAssistanceController::class, 'store'])->name('task-assistance.store');
    Route::post('/task-assistance/{id}/process-payment', [TaskAssistanceController::class, 'processPayment'])->name('task-assistance.payment');

});

// Subscription routes
Route::post('/subscription/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe')
    ->middleware('auth');

Route::post('/service/purchase', [ServiceController::class, 'purchase'])
    ->name('service.purchase')
    ->middleware('auth');

Route::get('/subscription/free', [SubscriptionController::class, 'subscribeFree'])
    ->name('subscription.subscribe.free')
    ->middleware('auth');

Route::post('/courses/enroll', [CourseAccessController::class, 'enroll'])
    ->middleware('auth')
    ->name('courses.enroll');
 
// Stripe routes
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
        Route::resource('clients', \App\Http\Controllers\Admin\ClientController::class)
            ->names([
                'index' => 'clients.clients',
                'create' => 'clients.create',
                'store' => 'clients.store',
                'show' => 'clients.show',
                'edit' => 'clients.edit',
                'update' => 'clients.update',
                'destroy' => 'clients.destroy'
            ]);
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
        
        // issues
        Route::resource('issues', \App\Http\Controllers\Admin\AdminIssueController::class);  
        Route::post('issues/{issue}/assign', [\App\Http\Controllers\Admin\AdminIssueController::class, 'assign'])->name('issues.assign');
        Route::post('issues/{issue}/add-response', [\App\Http\Controllers\Admin\AdminIssueController::class, 'addResponse'])->name('issues.add-response');
        Route::post('issues/{issue}/mark-resolved', [\App\Http\Controllers\Admin\AdminIssueController::class, 'markResolved'])->name('issues.mark-resolved');

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

    // Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    //     Route::resource('issues', AdminIssueController::class)->except(['create', 'store']);
    //     Route::post('issues/{issue}/assign', [AdminIssueController::class, 'assign'])->name('issues.assign');
    //     Route::post('issues/{issue}/close', [AdminIssueController::class, 'close'])->name('issues.close');
    //     Route::post('issues/{issue}/response', [AdminIssueController::class, 'addResponse'])->name('issues.response');
    // });
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
