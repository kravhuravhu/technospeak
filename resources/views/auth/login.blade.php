<div class="welcome_" id="welcomeSwapArea">
    <div class="logo_container">
        <a href="#"><img src="../images/white-no-logo.png" alt="technospeak white logo"/></a>
    </div>
    <div class="title_content">
        <h2>New here?</h2>
        <p>Create an account to start your journey with us.</p>
        <div class="login_button">
            <a href="/register" id="loadRegister">Register now</a>
        </div>
    </div>
</div>

<div class="form_container" id="formSwapArea">
    <div class="title_container">
        <h2>Sign in</h2>
    </div>
    <div class="hrzntl"><hr><span>Or</span><hr></div>
    <div class="icons">
        <a href="#"><i class="fa-brands fa-google"></i></a>
        <a href="#"><i class="fa-brands fa-linkedin"></i></a>
    </div>
    <div class="dscpt"><p>Or continue with using your email</p></div>
    <div class="form_wrapper">
        <form method="POST" action="{{ route('login') }}">
            @csrf
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
            <button type="submit">Login</button>
        </form>
    </div>
</div>
