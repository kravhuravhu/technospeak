<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Models\Course;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        Route::bind('course', function ($value) {
            if (preg_match('/^[0-9a-fA-F-]{36}$/', $value)) {
                return Course::where('uuid', $value)->firstOrFail();
            }

            return Course::findOrFail($value);
        });
    }
}
