<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LinkedInAuthController extends Controller
{
    public function redirect()
    {
        if (empty(config('services.linkedin.client_id')) || 
            empty(config('services.linkedin.client_secret'))) {
            return redirect('/login')->withErrors([
                'linkedin' => 'LinkedIn authentication is not configured properly.'
            ]);
        }
        
        return Socialite::driver('linkedin')
            ->scopes(['r_liteprofile', 'r_emailaddress'])
            ->redirect();
    }

    public function callback()
    {
        try {
            if (empty(config('services.linkedin.client_id')) || 
                empty(config('services.linkedin.client_secret'))) {
                return redirect('/login')->withErrors([
                    'linkedin' => 'LinkedIn authentication is not configured properly.'
                ]);
            }
            
            $linkedinUser = Socialite::driver('linkedin')->user();

            $client = Client::where('linkedin_id', $linkedinUser->getId())->first();

            if (!$client) {
                $client = Client::where('email', $linkedinUser->getEmail())->first();

                if (!$client) {
                    $last = Client::orderBy('id', 'desc')->first();
                    $lastId = 0;

                    if ($last && preg_match('/^TSC(\d+)$/', $last->id, $match)) {
                        $lastId = (int)$match[1];
                    }

                    $newId = 'TSC' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

                    $name = $linkedinUser->getName();
                    $surname = '';
                    
                    if (isset($linkedinUser->user['firstName']['localized']['en_US'])) {
                        $name = $linkedinUser->user['firstName']['localized']['en_US'];
                    }
                    
                    if (isset($linkedinUser->user['lastName']['localized']['en_US'])) {
                        $surname = $linkedinUser->user['lastName']['localized']['en_US'];
                    } else {
                        $nameParts = explode(' ', $linkedinUser->getName(), 2);
                        $name = $nameParts[0] ?? '';
                        $surname = $nameParts[1] ?? '';
                    }

                    $client = Client::create([
                        'id' => $newId,
                        'name' => $name,
                        'surname' => $surname,
                        'email' => $linkedinUser->getEmail(),
                        'password' => Hash::make(Str::random(24)),
                        'registered_date' => now()->format('Y-m-d'),
                        'registered_time' => now()->format('H:i:s'),
                        'email_verified_at' => now(),
                        'linkedin_id' => $linkedinUser->getId(),
                    ]);
                } else {
                    $client->linkedin_id = $linkedinUser->getId();
                    $client->save();
                }
            }

            // Log in the user
            Auth::login($client);

            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'linkedin' => 'Failed to authenticate with LinkedIn. Please try again. Error: ' . $e->getMessage(),
            ]);
        }
    }
}