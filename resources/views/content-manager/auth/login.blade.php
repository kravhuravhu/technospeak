@extends('layouts.auth')

@section('form')
<div class="form_container" id="formSwapArea">
    <div class="title_container title_mixed_content"><h2>Admin Login</h2></div>

    <div class="form_wrapper">
        <form method="POST" action="{{ route('content-manager.login') }}">
            @csrf

            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
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
