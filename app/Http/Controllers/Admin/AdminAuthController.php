<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('admin');
    }

    public function showLogin()
    {
        return view('content-manager.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
             Auth::shouldUse('admin');
            $request->session()->regenerate();
            return redirect()->intended(route('content-manager.admin'));
        }
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            Auth::shouldUse('admin');
            $request->session()->regenerate();

            $request->session()->forget('url.intended');

            return redirect()->route('content-manager.admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('content-manager.login');
    }
}