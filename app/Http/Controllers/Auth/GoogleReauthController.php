<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleReauthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirectUrl(route('google.reauth.callback'))
            ->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        if ($googleUser->getEmail() === auth()->user()->email) {
            return redirect()->route('profile.confirm-delete');
        }

        return redirect()->route('usr_settings')->withErrors([
            'password' => 'Google account does not match logged-in user.'
        ]);
    }
}
