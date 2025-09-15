<?php

namespace App\Http\Middleware;

use Closure;

class AdminRateLimit
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->withHeaders([
                'X-Frame-Options' => 'DENY',
                'X-Content-Type-Options' => 'nosniff',
                'X-XSS-Protection' => '1; mode=block',
            ]);
    }
}
