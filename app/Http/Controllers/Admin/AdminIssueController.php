<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\IssueAssignment;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Notifications\IssueUpdated;
use App\Notifications\IssueAssigned;


class AdminIssueController extends Controller 
{
    public function index()
    {
        $issues = Issue::with(['client', 'assignedTo'])->latest()->paginate(10);
        $instructors = Instructor::all();
        
        return view('content-manager.issues.index', compact('issues', 'instructors'));
    }

    public function show(Issue $issue)
    {
        $responses = $issue->responses()->latest()->get();
        return view('content-manager.issues.show', compact('issue', 'responses'));
    }

    public function edit(Issue $issue)
    {
        $instructors = Instructor::all();
        return view('content-manager.issues.edit', compact('issue', 'instructors'));
    }

    public function update(Request $request, Issue $issue)
    {
        $original = $issue->getOriginal();
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
            'assigned_to' => 'nullable|exists:instructors,id',
            'resolution_details' => 'nullable|string',
            'admin_notes' => 'nullable|string'
        ]);

        // Track changes for notification
        $changes = [];
        if (array_key_exists('status', $validated) && $validated['status'] != $original['status']) {
            $changes['status'] = ucfirst(str_replace('_', ' ', $validated['status']));
            
            // Update status timestamps
            if ($validated['status'] == 'resolved' && $issue->status != 'resolved') {
                $validated['resolved_at'] = now();
            } elseif ($validated['status'] == 'closed' && $issue->status != 'closed') {
                $validated['closed_at'] = now();
            }
        }

        if (array_key_exists('assigned_to', $validated)) {
            $instructor = Instructor::find($validated['assigned_to']);
            $changes['assigned_to'] = $instructor ? $instructor->name : 'Unassigned';
        }

        $issue->update($validated);

        // Send notification if there are changes
        if (!empty($changes)) {
            $issue->client->notify(new IssueUpdated($issue, $changes));
        }

        return redirect()->route('content-manager.issues.index')
            ->with('success', 'Issue updated successfully');
    }

    public function assign(Request $request, Issue $issue)
    {
        $request->validate([
            'instructor_id' => 'required|exists:instructors,id'
        ]);

        $issue->update([
            'assigned_to' => $request->instructor_id,
            'status' => 'in_progress'
        ]);

        // Record in issue_assignments table
        \DB::table('issue_assignments')->insert([
            'issue_id' => $issue->id,
            'instructor_id' => $request->instructor_id,
            'assigned_at' => now(),
            'status' => 'active'
        ]);

        return back()->with('success', 'Issue assigned successfully');
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();
        return redirect()->route('content-manager.issues.index')
            ->with('success', 'Issue deleted successfully');
    }

    public function addResponse(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'response_type' => 'required|in:email,comment,solution,internal_note',
            'content' => 'required|string',
            'is_customer_visible' => 'sometimes|boolean'
        ]);

        $response = $issue->responses()->create([
            'responder_id' => auth()->id(),
            'response_type' => $validated['response_type'],
            'content' => $validated['content'],
            'is_customer_visible' => $request->has('is_customer_visible')
        ]);

        // If this is a solution, update issue status
        if ($validated['response_type'] == 'solution') {
            $issue->update([
                'status' => 'in_progress',
                'resolution_details' => $validated['content']
            ]);
        }

        return back()->with('success', 'Response added successfully');
    }

    public function markResolved(Request $request, Issue $issue)
    {
        $issue->update([
            'status' => 'resolved',
            'resolved_at' => now()
        ]);

        return back()->with('success', 'Issue marked as resolved');
    }
}