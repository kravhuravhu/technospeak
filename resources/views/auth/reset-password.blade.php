@extends('layouts.auth')

@section('welcome')
    @if (!Request::is('reset-password*'))
        <div class="welcome_" id="welcomeSwapArea">
            <div class="logo_container">
                <a href="#"><img src="@secureAsset('/images/white-no-logo.png')" alt="technospeak white logo"/></a>
            </div>
        </div>
    @endif
@endsection

@section('form')
<div class="form_container" id="formSwapArea" style="border-radius: 15px;margin:0 auto;padding:15px 25px;">
    <div class="logo_container">
        <a href="#"><img src="@secureAsset('/images/default-no-logo.png')" height="60px" alt="technospeak white logo"/></a>
    </div>

    <div class="title_container" style="flex-direction:column;">
        <h2 style="padding:30px;font-size:1.7em;">
            <style>
                h2::after {
                    content: none!important;
                }
            </style>
            Reset Password Here
        </h2>
        <p style="font-weight:200;">Enter your registered email address and new password to reset.</p>
    </div>
    
    <div class="form_wrapper">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            @if (session('status'))
                <p class="text-green-600">{{ session('status') }}</p>
            @endif

            <!-- Email Address -->
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                @error('email') <p>{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your new password" required autocomplete="new-password">
                @error('password') <p>{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input type="password" name="password_confirmation" placeholder="Confirm your new password" required autocomplete="new-password">
                @error('password_confirmation') <p>{{ $message }}</p> @enderror
            </div>

            <button type="submit" style="padding:15px 20px;font-size:1em;font-weight:400;">Reset Password</button>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" style="color: grey;">← Back to login</a>
            </div>
        </form>
    </div>
</div>
@endsection
