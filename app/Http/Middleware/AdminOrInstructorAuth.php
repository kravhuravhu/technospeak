<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOrInstructorAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check() || Auth::guard('instructor')->check()) {
            return $next($request);
        }
        return redirect()->route('content-manager.login');
    }
}
