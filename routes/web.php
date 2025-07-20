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
use App\Http\Controllers\IssueController; 

// Public routes
Route::get('/', [WelcomeController::class, 'index']);
Route::get('/about', function () { return view('about'); });
Route::get('/trainings', function () { return view('trainings'); });
Route::get('/pricing', function () { return view('pricing'); });
Route::get('/privacy', function () { return view('privacy'); });
Route::get('/terms', function () { return view('terms'); });

// Training registration
Route::post('/training/register', [TrainingRegistrationController::class, 'store'])->name('training.register');

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
                    'title' => $course->title,
                    'thumbnail' => $course->thumbnail,
                    'formatted_duration' => $course->formatted_duration,
                    'progress' => $progress
                ];
            });

        return view('dashboard', [
            'freeCourses' => $freeCourses,
            'paidCourses' => $paidCourses,
            'enrolledCourses' => $enrolledCourses,
            'recommendedCourses' => $recommendedCourses
        ]);
    })->name('dashboard');

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

    // Issue submission
    Route::post('/issues', [IssueController::class, 'submitIssue']);
    
    // Issue management
    Route::get('/issues/{id}', [IssueController::class, 'getIssue']);
    Route::put('/issues/{id}/status', [IssueController::class, 'updateStatus']);
    Route::post('/issues/{id}/responses', [IssueController::class, 'addResponse']);
});

Route::post('/courses/enroll', [CourseAccessController::class, 'enroll'])
    ->middleware('auth')
    ->name('courses.enroll');
 

// Stripe routes
Route::prefix('stripe')->group(function () {
    Route::get('/checkout/{clientId}/{planId}', [StripeController::class, 'checkout'])
        ->name('stripe.checkout');
    Route::post('/webhook', [StripeWebhookController::class, 'handle']);
    Route::get('/success', [StripeController::class, 'success'])->name('stripe.success');
});

require __DIR__.'/auth.php';
 
// Admin routes
Route::prefix('content')->name('content-manager.')->group(function() {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    Route::middleware([AdminAuth::class])->group(function() {
        Route::get('admin', [AdminController::class, 'admin'])->name('admin');
        
        // Courses
        Route::resource('courses', CourseController::class);
        Route::resource('courses.episodes', EpisodeController::class);
        
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
        Route::resource('issues', \App\Http\Controllers\Admin\IssueController::class);

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

// Enrollments
Route::delete('client-courses/delete', [ClientController::class, 'destroyEnrollment'])->name('content-manager.client-courses.destroy');

// success payment
Route::get('/success-payment', function() {
    return view('success-payment'); 
})->name('payment.success');