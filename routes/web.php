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
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\TrainingRegistrationController;
use App\Http\Controllers\CourseAccessController; 

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
Route::middleware(['auth'])->group(function () {
    // training function distribution
    Route::get('/dashboard', function () {
        $courseAccess = new CourseAccessController();
        return view('dashboard', [
            'freeCourses' => $courseAccess->getFreeCourses(),
            'paidCourses' => $courseAccess->getPaidCourses()
        ]);
    })->name('dashboard');
    
    Route::post('/onboarding/complete', [PreferenceController::class, 'set'])->name('completeOnboarding');
    Route::get('/skip-onboarding', function () {
        session(['skipped_preference' => true, 'skipped_userType' => true]);
        return redirect()->back();
    })->name('skipOnboarding');
   
    // Profile routes
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
 
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
        Route::resource('payments', PaymentsController::class);
        Route::post('payments/{payment}/approve', [PaymentsController::class, 'approve'])->name('payments.approve');
        
        // trainings
        Route::resource('trainings', TrainingSessionController::class);
        Route::get('trainings/{training}/registrations', [TrainingSessionController::class, 'registrations'])->name('trainings.registrations');
        Route::post('trainings/{training}/mark-attendance', [TrainingSessionController::class, 'markAttendance'])->name('trainings.mark-attendance');
        
        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});