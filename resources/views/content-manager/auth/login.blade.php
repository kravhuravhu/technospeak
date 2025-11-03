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
            </div>
            @error('email') <p>{{ $message }}</p> @enderror
            
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            @error('password') <p>{{ $message }}</p> @enderror

            <button type="submit">Login</button>
        </form>
    </div>
</div>
@endsection
