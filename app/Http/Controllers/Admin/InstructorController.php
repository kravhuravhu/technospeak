<?php

namespace App\Http\Controllers\Admin;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::all();
        return view('content-manager.other-features.index', compact('instructors'));
    }

    public function create()
    {
        return view('content-manager.instructors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email',
            'bio' => 'nullable|string',
            'thumbnail' => 'nullable|url',
            'features' => 'nullable|json',
        ]);

        $data = $request->all();

        if (!empty($data['features'])) {
            $data['features'] = json_decode($data['features'], true);
        }

        Instructor::create($data);

        return redirect()->route('content-manager.other-features.index')->with('success', 'Instructor created successfully.');
    }

    public function show($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('content-manager.instructors.show', compact('instructor'));
    }

    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);
        return view('content-manager.instructors.edit', compact('instructor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email,' . $id,
            'bio' => 'nullable|string',
            'thumbnail' => 'nullable|url',
            'features' => 'nullable|json',
        ]);
        $data = $request->all();

        if (!empty($data['features'])) {
            $data['features'] = json_decode($data['features'], true);
        }

        $instructor = Instructor::findOrFail($id);

        $instructor->update($data);

        return redirect()->route('content-manager.other-features.index')->with('success', 'Instructor updated successfully.');
    }

    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->delete();

        return redirect()->route('content-manager.other-features.index')->with('success', 'Instructor deleted successfully.');
    }
}
