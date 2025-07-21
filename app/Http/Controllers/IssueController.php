<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\IssueAssignment;
use App\Models\IssueResponse;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewIssueSubmitted;
use App\Models\Admin;
use App\Notifications\IssueConfirmation;

class IssueController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'issueTitle' => 'required|string|max:255',
            'issueDescription' => 'required|string',
            'issueCategory' => 'required|in:microsoft,google,canva,system,general,other',
            'urgency' => 'required|in:low,medium,high'
        ]);

        /** @var Client $client */
        $client = Auth::user();
        
        $issue = Issue::create([
            'client_id' => $client->id2,
            'email' => $client->email,
            'title' => $validated['issueTitle'],
            'description' => $validated['issueDescription'],
            'category' => $validated['issueCategory'],
            'urgency' => $validated['urgency'],
            'status' => 'open'
        ]);
        
        // Send confirmation to client
        $client->notify(new IssueConfirmation($issue));
        
        // Notify all admins
        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->notify(new NewIssueSubmitted($issue));
        }
        
        return response()->json([
            'success' => true,
            'issue_id' => $issue->id,
            'message' => 'Issue submitted successfully. Check your email for confirmation.'
        ]);
    }

    
    protected function notifyAdmins(Issue $issue)
    {
        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->notify(new NewIssueSubmitted($issue));
        }
    }
    
    public function userIssues()
    {
        /** @var Client $client */
        $client = Auth::user();
        
        $issues = Issue::where('client_id', $client->id2)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return response()->json($issues);
    }
    
    public function getIssue($id)
    {
        $issue = Issue::with(['client', 'responses', 'assignments'])->findOrFail($id);
        return response()->json($issue);
    }
    
    public function updateStatus(Request $request, $id)
    {
        $issue = Issue::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:open,assigned,in_progress,resolved,closed',
            'admin_id' => 'required_if:status,assigned|nullable|integer',
            'resolution_details' => 'required_if:status,resolved|nullable|string'
        ]);
        
        $issue->update([
            'status' => $validated['status'],
            'resolution_details' => $validated['resolution_details'] ?? null,
            'resolved_at' => $validated['status'] === 'resolved' ? now() : null,
            'closed_at' => $validated['status'] === 'closed' ? now() : null
        ]);
        
        if ($validated['status'] === 'assigned') {
            IssueAssignment::create([
                'issue_id' => $issue->id,
                'admin_id' => $validated['admin_id'],
                'status' => 'active'
            ]);
            
            $issue->update(['assigned_to' => $validated['admin_id']]);
        }
        
        return response()->json(['success' => true]);
    }
    
    public function addResponse(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'response_type' => 'required|in:email,comment,solution,internal_note',
            'is_customer_visible' => 'boolean'
        ]);
        
        IssueResponse::create([
            'issue_id' => $id,
            'responder_id' => Auth::id(),
            'response_type' => $validated['response_type'],
            'content' => $validated['content'],
            'is_customer_visible' => $validated['is_customer_visible'] ?? false
        ]);
        
        return response()->json(['success' => true]);
    }

    public function index()
    {
        $issues = auth()->user()->issues()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('issues.index', compact('issues'));
    }

    public function show(Issue $issue)
    {
        // Ensure the authenticated user owns this issue
        if ($issue->client_id !== auth()->id()) {
            abort(403);
        }

        return view('issues.show', compact('issue'));
    }

    public function assign(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'instructor_id' => 'required|exists:instructors,id',
            'admin_notes' => 'nullable|string'
        ]);

        // Close any existing active assignments
        IssueAssignment::where('issue_id', $issue->id)
            ->active()
            ->update([
                'status' => 'reassigned',
                'unassigned_at' => now()
            ]);

        // Create new assignment
        $assignment = IssueAssignment::create([
            'issue_id' => $issue->id,
            'instructor_id' => $validated['instructor_id'],
            'status' => 'active'
        ]);

        // Update issue status
        $issue->update([
            'status' => 'assigned',
            'assigned_to' => $validated['instructor_id'],
            'admin_notes' => $validated['admin_notes']
        ]);

        // Notify instructor
        Notification::send($assignment->instructor, new IssueAssigned($issue));

        return redirect()->back()->with('success', 'Issue assigned successfully');
    }

    public function close(Issue $issue)
    {
        $issue->update([
            'status' => 'closed',
            'closed_at' => now()
        ]);

        // Notify client
        $issue->client->notify(new IssueClosed($issue));

        return redirect()->back()->with('success', 'Issue closed successfully');
    }
}