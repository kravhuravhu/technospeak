@extends('layouts.auth')

@section('welcome')
<div class="welcome_" id="welcomeSwapArea">
    <div class="logo_container">
        <a href="#"><img src="@secureAsset('/images/white-no-logo.png')" alt="technospeak white logo"/></a>
    </div>
    <div class="title_content">
        <h2>New here?</h2>
        <p>Create an account to start your journey with us.</p>
        <div class="login_button">
            <a href="/register" id="loadRegister">Register now</a>
        </div>
    </div>
</div>
@endsection

@section('form')
<div class="form_container" id="formSwapArea">
    <div class="title_container title_mixed_content"><h2>Sign in</h2></div>
    <div class="social-login-container">
        <a href="{{ route('google.login') }}" class="social-login-btn google-btn">
            <span class="social-icon">
                <i class="fa-brands fa-google"></i>
            </span>
            <span class="social-text">Continue with Google</span>
        </a>
        <a href="{{ route('linkedin.login') }}" class="social-login-btn linkedin-btn">
            <span class="social-icon">
                <i class="fa-brands fa-linkedin"></i>
            </span>
            <span class="social-text">Continue with LinkedIn</span>
        </a>
    </div>
    <div class="hrzntl"><hr><span>Or</span><hr></div>
    <div class="dscpt"><p>Continue with using your email</p></div>
    <div class="form_wrapper">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email" required>
                @error('email') <p>{{ $message }}</p> @enderror
            </div>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
                @error('password') <p>{{ $message }}</p> @enderror
            </div>
            <div class="input-icon">
                <div class="container-rm-fgp">
                    <div class="rm block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span class="ml-2 text-sm">Remember me</span>
                        </label>
                    </div>
                    <div class="fgp">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Forgot your password?</a>
                        @endif
                    </div>
                </div>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</div>
@endsection