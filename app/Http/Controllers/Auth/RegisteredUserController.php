<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Client;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:technospeak_db.clients,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $last = Client::orderBy('id', 'desc')->first();

        $lastId = 0;
        if ($last && preg_match('/^TSC(\d+)$/', $last->id, $match)) {
            $lastId = (int)$match[1];
        }

        $newId = 'TSC' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        $client = new Client([
            'id' => $newId,
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'registered_date' => now()->format('Y-m-d'),
            'registered_time' => now()->format('H:i:s'),
        ]);

        $client->save();

        // After inserting into DB
        $client = Client::find($newId);
        event(new Registered($client));

        // Login user
        Auth::login($client);

        return redirect(route('dashboard', absolute: false));
    }
}