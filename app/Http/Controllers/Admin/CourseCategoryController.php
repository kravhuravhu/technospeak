<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use App\Models\ResourceType;
use App\Models\TrainingType;
use App\Models\Instructor;

class CourseCategoryController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('admin');
    }
    
    public function index()
    {
        $instructors = Instructor::paginate(10);
        $trainingTypes = TrainingType::paginate(10);
        $resourceTypes = ResourceType::withCount('resources')
            ->paginate(10);
        $categories = CourseCategory::withCount('courses')
            ->withSum('courses as total_duration', 'total_duration')
            ->orderBy('name')
            ->paginate(10);

        return view('content-manager.other-features.index', compact('instructors','categories','trainingTypes','resourceTypes'));
    }

    public function create()
    {
        return view('content-manager.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:course_categories,name',
        ]);

        CourseCategory::create($request->all());

        return redirect()->route('content-manager.other-features.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function show(CourseCategory $category)
    {
        $category->load(['courses' => function($query) {
            $query->withCount('episodes');
        }]);

        return view('content-manager.categories.show', compact('category'));
    }

    public function edit(CourseCategory $category)
    {
        $category->loadCount('courses');
        $category->loadSum('courses as total_duration', 'total_duration');

        return view('content-manager.categories.edit', compact('category'));
    }

    public function update(Request $request, CourseCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:course_categories,name,'.$category->id,
        ]);

        $category->update($request->all());

        return redirect()->route('content-manager.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(CourseCategory $category)
    {
        if ($category->courses()->exists()) {
            return back()->with('error', 
                'Cannot delete category with existing courses. Move or delete the courses first.');
        }

        $category->delete();

        return redirect()->route('content-manager.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}