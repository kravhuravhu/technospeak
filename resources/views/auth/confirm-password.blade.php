@extends('layouts.auth')

@section('welcome')
    @if (!Request::is('confirm-password'))
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
            Confirm Your Password
        </h2>
        <p style="font-weight:200;">This is a secure area of the application. Please confirm your password before continuing.</p>
    </div>
    
    <div class="form_wrapper">
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password Confirmation -->
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                @error('password') <p>{{ $message }}</p> @enderror
            </div>

            <button type="submit" style="padding:15px 20px;font-size:1em;font-weight:400;">Confirm</button>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" style="color: grey;">← Back to login</a>
            </div>
        </form>
    </div>
</div>
@endsection
