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
    public function showForm()
    {
        return view('dashboard.get-help'); // Adjust to your actual view path
    }
    
    public function submitIssue(Request $request)
    {
        $validated = $request->validate([
            'issueTitle' => 'required|string|max:255',
            'issueDescription' => 'required|string',
            'issueCategory' => 'required|in:microsoft,google,canva,system,general,other',
            'urgency' => 'required|in:low,medium,high'
        ]);
        
        $issue = Issue::create([
            'client_id' => Auth::id(),
            'title' => $validated['issueTitle'],
            'description' => $validated['issueDescription'],
            'category' => $validated['issueCategory'],
            'urgency' => $validated['urgency'],
            'status' => 'open'
        ]);

        // Get the authenticated client
        $client = Client::find(Auth::id());
        
        // Send email confirmation
        if ($client && $client->email) {
            Mail::to($client->email)
                ->send(new IssueConfirmation($client, $issue));
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Your issue has been submitted successfully!'
        ]);
    }
    
    public function getUserIssues()
    {
        $issues = Issue::where('client_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('dashboard.my-issues', compact('issues'));
    }
}