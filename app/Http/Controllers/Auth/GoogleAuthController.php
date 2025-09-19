<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $client = Client::where('google_id', $googleUser->getId())->first();

            if (!$client) {
                $client = Client::where('email', $googleUser->getEmail())->first();

                if (!$client) {
                    $last = Client::orderBy('id', 'desc')->first();
                    $lastId = 0;

                    if ($last && preg_match('/^TSC(\d+)$/', $last->id, $match)) {
                        $lastId = (int)$match[1];
                    }

                    $newId = 'TSC' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

                    $nameParts = explode(' ', $googleUser->getName(), 2);
                    $name = $nameParts[0] ?? '';
                    $surname = $nameParts[1] ?? '';

                    $client = Client::create([
                        'id' => $newId,
                        'name' => $name,
                        'surname' => $surname,
                        'email' => $googleUser->getEmail(),
                        'password' => Hash::make(Str::random(24)),
                        'registered_date' => now()->format('Y-m-d'),
                        'registered_time' => now()->format('H:i:s'),
                        'email_verified_at' => now(),
                        'google_id' => $googleUser->getId(),
                    ]);
                } else {
                    $client->google_id = $googleUser->getId();
                    $client->save();
                }
            }

            // Log in the user
            Auth::login($client);

            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'google' => 'Failed to authenticate with Google. Please try again.',
            ]);
        }
    }

}