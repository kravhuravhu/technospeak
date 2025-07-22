<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'uname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required',
        ]);

        ContactMessage::create([
            'full_name' => $validated['uname'],
            'email' => $validated['email'],
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Your message has been received! We will get back to you soon.');
    }
}