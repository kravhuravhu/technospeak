<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\IssueAssignment;
use App\Models\IssueResponse;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\IssueConfirmation;
use Illuminate\Support\Facades\Mail;

class IssueController extends Controller
{
    public function submitIssue(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:microsoft,google,canva,system,general',
            'urgency' => 'required|in:low,medium,high'
        ]);
        
        $client = Auth::user();
        
        $issue = Issue::create([
            'client_id' => $client->id,
            'email' => $client->email,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'urgency' => $validated['urgency'],
            'status' => 'open'
        ]);
        
        // Send confirmation email
        Mail::to($client->email)->send(new IssueConfirmation($issue));
        
        return response()->json([
            'success' => true,
            'issue_id' => $issue->id,
            'message' => 'Issue submitted successfully. Our team will contact you soon.'
        ]);
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
}