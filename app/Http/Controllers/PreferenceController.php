<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function set(Request $request)
    {
        $user = Auth::user();

        $rules = [];

    
        if ($request->has('preferred_category_id')) {
            $rules['preferred_category_id'] = 'required|exists:course_categories,id';
        }

        if ($request->has('userType')) {
            $rules['userType'] = 'required|in:Student,Professional';
        }

        $validated = $request->validate($rules);

        if (isset($validated['preferred_category_id'])) {
            $user->preferred_category_id = $validated['preferred_category_id'];
        }

        if (isset($validated['userType'])) {
            $user->userType = $validated['userType'];
        }

        $user->save();

        return redirect()->route('dashboard');
    }

    public function skip()
    {
        session([
            'skipped_preference' => true,
            'skipped_userType' => true
        ]);

        return redirect()->route('dashboard');
    }
}
