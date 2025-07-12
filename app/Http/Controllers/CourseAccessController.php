<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\CourseController;
use Illuminate\Support\Facades\Auth;

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

    public function getFreeCourses()
    {
        $currentGuard = Auth::getDefaultDriver();
        
        $courses = $this->adminCourseController->trainingCallFree();
        
        Auth::shouldUse($currentGuard);
        
        return $courses;
    }

    public function getPaidCourses()
    {
        $currentGuard = Auth::getDefaultDriver();
        
        $courses = $this->adminCourseController->trainingCallPaid();
        
        Auth::shouldUse($currentGuard);
        
        return $courses;
    }
}