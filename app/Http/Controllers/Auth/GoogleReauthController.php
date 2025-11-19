<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleReauthController extends Controller
{
    public function redirect()
    {
        try {
            Log::info('Google reauthentication initiated', [
                'user_id' => auth()->id(),
                'user_email' => auth()->user()->email
            ]);

            return Socialite::driver('google_reauth')
                ->with([
                    'prompt' => 'consent select_account',
                    'access_type' => 'offline'
                ])
                ->redirect();
        } catch (Exception $e) {
            Log::error('Google reauthentication redirect failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('dashboard')->withErrors([
                'google' => 'Failed to initialize Google reauthentication.'
            ]);
        }
    }

    public function callback()
    {
        try {
            Log::info('Google reauthentication callback started', [
                'user_id' => auth()->id(),
                'user_email' => auth()->user()->email
            ]);

            $googleUser = Socialite::driver('google_reauth')->user();

            Log::debug('Google user data received', [
                'google_email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'logged_in_email' => auth()->user()->email
            ]);

            if ($googleUser->getEmail() === auth()->user()->email) {
                Log::info('Google reauthentication successful', [
                    'user_id' => auth()->id(),
                    'user_email' => auth()->user()->email
                ]);

                return redirect()->route('profile.confirm-delete-google');
            }

            Log::warning('Google reauthentication failed - email mismatch', [
                'user_id' => auth()->id(),
                'logged_in_email' => auth()->user()->email,
                'google_email' => $googleUser->getEmail()
            ]);

            return redirect()->route('dashboard')->withErrors([
                'password' => 'Google account does not match logged-in user.'
            ]);

        } catch (Exception $e) {
            Log::error('Google reauthentication callback failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('dashboard')->withErrors([
                'google' => 'Reauthentication failed.'
            ]);
        }
    }
}