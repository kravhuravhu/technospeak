<?php

namespace App\Http\Controllers\Admin;

use App\Models\TrainingType;
use App\Models\Instructor;
use App\Models\ResourceType;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrainingTypeController extends Controller
{
    public function index()
    {
        $instructors = Instructor::paginate(10);
        $resourceTypes = ResourceType::withCount('resources')
            ->paginate(10);
        $categories = CourseCategory::withCount('courses')
            ->withSum('courses as total_duration', 'total_duration')
            ->orderBy('name')
            ->paginate(10);
        $trainingTypes = TrainingType::withCount('sessions')->paginate(10);
        return view('content-manager.other-features.index', compact('instructors', 'resourceTypes', 'categories', 'trainingTypes'));
    }

    public function create()
    {
        return view('content-manager.other-features.training-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:training_types,name',
            'description' => 'nullable|string',
            'is_group_session' => 'required|boolean',
            'max_participants' => 'nullable|integer|min:1|required_if:is_group_session,true',
            'student_price' => 'required|numeric|min:0',
            'professional_price' => 'required|numeric|min:0',
        ]);

        TrainingType::create($request->all());

        return redirect()->route('content-manager.other-features.training-types.index')
                         ->with('success', 'Training type created successfully.');
    }

    public function show(TrainingType $trainingType)
    {
        $trainingType->load('sessions');
        return view('content-manager.training-types.show', compact('trainingType'));
    }

    public function edit(TrainingType $trainingType)
    {
        return view('content-manager.training-types.edit', compact('trainingType'));
    }

    public function update(Request $request, TrainingType $trainingType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:training_types,name,'.$trainingType->id,
            'description' => 'nullable|string',
            'is_group_session' => 'required|boolean',
            'max_participants' => 'nullable|integer|min:1|required_if:is_group_session,true',
            'student_price' => 'required|numeric|min:0',
            'professional_price' => 'required|numeric|min:0',
        ]);

        $trainingType->update($request->all());

        return redirect()->route('content-manager.other-features.training-types.index')
                         ->with('success', 'Training type updated successfully.');
    }

    public function destroy(TrainingType $trainingType)
    {
        if ($trainingType->sessions()->count() > 0) {
            return redirect()->back()
                             ->with('error', 'Cannot delete training type that has associated sessions.');
        }

        $trainingType->delete();

        return redirect()->route('content-manager.other-features.training-types.index')
                         ->with('success', 'Training type deleted successfully.');
    }
}