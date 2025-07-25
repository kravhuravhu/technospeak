<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseResource;
use Illuminate\Http\Request;

class CourseResourceController extends Controller
{
    public function destroy(Course $course, CourseResource $resource)
    {
        if ($resource->course_id !== $course->id) {
            abort(403, 'Unauthorized action.');
        }

        $resource->delete();

        return redirect()->route('content-manager.courses.show', $course->id)
                         ->with('success', 'Resource deleted successfully.');
    }
}
