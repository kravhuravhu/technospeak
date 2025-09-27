<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactMessage;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'contact_full_name' => 'required|string|max:255',
            'contact_email'     => 'required|email|max:255',
            'contact_message'   => 'required|string|max:5000',
        ]);

        $fields = [
            'Full Name' => $validated['contact_full_name'],
            'Email'     => $validated['contact_email'],
            'Message'   => $validated['contact_message'],
        ];

        Notification::route('mail', config('mail.bcc'))
            ->notify(new ContactMessage($fields));

        return back()->with('success', 'Your message has been sent!');
    }
}