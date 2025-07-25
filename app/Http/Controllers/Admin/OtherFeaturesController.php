<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\CourseCategory;
use App\Models\ResourceType;
use App\Models\TrainingType;

class OtherFeaturesController extends Controller
{
    public function index()
    {
        return view('content-manager.other-features.index', [
            'instructors' => Instructor::paginate(10),
            'categories' => CourseCategory::withCount('courses')->paginate(10),
            'resourceTypes' => ResourceType::withCount('resources')->paginate(10),
            'trainingTypes' => TrainingType::withCount('sessions')->paginate(10)
        ]);
    }
}