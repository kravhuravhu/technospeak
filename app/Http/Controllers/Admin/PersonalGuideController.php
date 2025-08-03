<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalGuideRequest;
use Illuminate\Http\Request;

class PersonalGuideController extends Controller
{
    public function index()
    {
        $requests = PersonalGuideRequest::with('client')->latest()->paginate(10);
        return view('admin.personal-guide.index', compact('requests'));
    }
    
    public function show(PersonalGuideRequest $personalGuide)
    {
        return view('admin.personal-guide.show', compact('personalGuide'));
    }
    
    public function update(Request $request, PersonalGuideRequest $personalGuide)
    {
        $validated = $request->validate([
            'instructor_id' => 'required|exists:users,id',
            'scheduled_time' => 'required|date',
            'meeting_link' => 'required|url',
        ]);
        
        $personalGuide->update([
            'instructor_id' => $validated['instructor_id'],
            'scheduled_time' => $validated['scheduled_time'],
            'meeting_link' => $validated['meeting_link'],
            'status' => 'scheduled'
        ]);
        
        // Send confirmation email
        Mail::to($personalGuide->client->email)->send(new GuideConfirmation($personalGuide));
        
        return redirect()->route('admin.personal-guide.index')->with('success', 'Request scheduled successfully');
    }
}