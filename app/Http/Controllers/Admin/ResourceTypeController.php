<?php

namespace App\Http\Controllers\Admin;

use App\Models\ResourceType;
use App\Models\TrainingType;
use App\Models\Instructor;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceTypeController extends Controller
{
    public function index()
    {
        $instructors = Instructor::paginate(10);
        $trainingTypes = TrainingType::paginate(10);
        $categories = CourseCategory::withCount('courses')
            ->withSum('courses as total_duration', 'total_duration')
            ->orderBy('name')
            ->paginate(10);
        $resourceTypes = ResourceType::withCount('resources')->paginate(10);
        return view('content-manager.other-features.index', compact('instructors','trainingTypes','categories','resourceTypes'));
    }

    public function create()
    {
        return view('content-manager.other-features.resource-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:resource_types,name',
        ]);

        ResourceType::create($request->all());

        return redirect()->route('content-manager.other-features.resource-types.index')
                         ->with('success', 'Resource type created successfully.');
    }

    public function show(ResourceType $resourceType)
    {
        return view('content-manager.resource-types.show', compact('resourceType'));
    }

    public function edit(ResourceType $resourceType)
    {
        return view('content-manager.resource-types.edit', compact('resourceType'));
    }

    public function update(Request $request, ResourceType $resourceType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:resource_types,name,'.$resourceType->id,
        ]);

        $resourceType->update($request->all());

        return redirect()->route('content-manager.other-features.resource-types.index')
                         ->with('success', 'Resource type updated successfully.');
    }

    public function destroy(ResourceType $resourceType)
    {
        if ($resourceType->resources()->count() > 0) {
            return redirect()->back()
                             ->with('error', 'Cannot delete resource type that has associated resources.');
        }

        $resourceType->delete();

        return redirect()->route('content-manager.other-features.resource-types.index')
                         ->with('success', 'Resource type deleted successfully.');
    }
}