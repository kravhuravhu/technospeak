<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserQuestion;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'question' => 'required',
        ]);

        UserQuestion::create([
            'email' => $validated['email'],
            'question' => $validated['question'],
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Your question has been submitted! We will respond shortly.');
    }
}