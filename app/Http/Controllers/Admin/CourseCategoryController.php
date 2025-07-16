<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('admin');
    }

    public function index()
    {
        $categories = CourseCategory::withCount('courses')
            ->orderBy('name')
            ->paginate(10);

        return view('content-manager.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('content-manager.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:course_categories,name',
        ]);

        CourseCategory::create($validated);

        return redirect()->route('content-manager.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(CourseCategory $category)
    {
        return view('content-manager.categories.edit', compact('category'));
    }

    public function update(Request $request, CourseCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:course_categories,name,'.$category->id,
        ]);

        $category->update($validated);

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