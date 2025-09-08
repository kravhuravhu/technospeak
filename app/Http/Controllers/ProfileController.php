<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): RedirectResponse
    {
        return redirect()->route('dashboard')->with([
            'status' => 'profile-updated',
            'section' => 'usr_settings'
        ]);

    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()->route('dashboard')->with([
            'status' => 'profile-updated',
            'section' => 'usr_settings'
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if (
            $user->courseSubscriptions()->exists() ||
            $user->trainingRegistrations()->exists() ||
            $user->payments()->exists()
        ) {
            // Archive instead of deleting
            $user->status = 'archived';
            $user->archived_at = now();
            $user->email = $user->email . '.arch_' . time();
            $user->save();

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/')->with('accountDeleted', true);
        }

        // safe to delete
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Cache::forget('client_' . $user->id);

        $user->delete();

        return Redirect::to('/')->with('success', 'Your Account was deleted successfully.');
    }
}
