<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\User; // Assuming you have a User model for instructors
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index()
    {
        $issues = Issue::with('client')->latest()->paginate(10);
        return view('content-manager.issues.index', compact('issues'));
    }

    public function show(Issue $issue)
    {
        return view('content-manager.issues.show', compact('issue'));
    }

    public function edit(Issue $issue)
    {
        $instructors = User::where('role', 'instructor')->get(); // Adjust based on your user roles
        return view('content-manager.issues.edit', compact('issue', 'instructors'));
    }

    public function update(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $issue->update($validated);

        return redirect()->route('content-manager.issues.index')
            ->with('success', 'Issue updated successfully');
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();
        
        return redirect()->route('content-manager.issues.index')
            ->with('success', 'Issue deleted successfully');
    }
}