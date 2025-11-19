<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Laravel\Socialite\Two\GoogleProvider;

class SocialiteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $socialite = $this->app->make(SocialiteFactory::class);

        $socialite->extend('google_reauth', function ($app) use ($socialite) {
            $config = $app['config']['services.google_reauth'];

            return $socialite->buildProvider(GoogleProvider::class, [
                'client_id'     => $config['client_id'],
                'client_secret' => $config['client_secret'],
                'redirect'      => $config['redirect'],
            ]);
        });
    }
}
