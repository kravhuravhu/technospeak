<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Registration Form - Technospeak</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="@secureAsset('/style/auth_register.css')" type="text/css"/>
        <link rel="stylesheet" href="@secureAsset('/style/home.css')" type="text/css" />
        <link rel="icon" href="@secureAsset('/images/icon.png')" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <section class="register_container">
            <div class="main_container">
                <div class="welcome_" id="welcomeSwapArea">
                    <div class="logo_container">
                        <a href="#"><img src="../images/white-no-logo.png" alt="technospeak white logo"/></a>
                    </div>
                    <div class="title_content">
                        <h2>Welcome Back!</h2>
                        <p>Stay connected with us and pick up where you left off, please use the button below to log in!</p>
                        <div class="login_button">
                            <a href="/login" id="loadLogin">Login now</a>
                        </div>
                    </div>
                </div>

                <div class="form_container" id="formSwapArea">
                    <div class="title_container">
                        <h2>Create Account</h2>
                    </div>
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
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="input-icon">
                                <i class="fa fa-user"></i>
                                <input type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}" required>
                                @error('name') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="input-icon">
                                <i class="fa fa-user"></i>
                                <input type="text" name="surname" placeholder="Enter your surname" value="{{ old('surname') }}" required>
                                @error('surname') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="input-icon">
                                <i class="fa fa-envelope"></i>
                                <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                                @error('email') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="input-icon">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="password" placeholder="Enter password here" required>
                                @error('password') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="input-icon">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="password_confirmation" placeholder="Re-enter your password" required>
                            </div>
                            <button type="submit">Register</button>
                        </form>
                    </div>
                </div>

            </div>
        </section>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginBtn = document.getElementById('loadLogin');
            let isSwapping = false;

            function fadeOut(element, callback) {
                element.style.transition = 'opacity 0.4s ease';
                element.style.opacity = 0;
                setTimeout(() => callback(), 400);
            }

            function fadeIn(element) {
                element.style.opacity = 0;
                element.style.transition = 'opacity 0.4s ease';
                element.style.display = '';
                requestAnimationFrame(() => {
                    element.style.opacity = 1;
                });
            }

            function swapContent(url, push = true) {
                if (isSwapping) return;
                isSwapping = true;

                Promise.all([fetch(url).then(res => res.text())])
                    .then(([html]) => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newForm = doc.querySelector('#formSwapArea');
                        const newWelcome = doc.querySelector('.welcome_');

                        if (!newForm || !newWelcome) {
                            console.error('Swap elements missing in fetched content.');
                            isSwapping = false;
                            return;
                        }

                        // containers fresh each time
                        const currentForm = document.querySelector('#formSwapArea');
                        const currentWelcome = document.querySelector('.welcome_');

                        fadeOut(currentForm, () => {
                            currentForm.replaceWith(newForm);
                            fadeIn(newForm);
                            isSwapping = false;
                        });

                        fadeOut(currentWelcome, () => {
                            currentWelcome.replaceWith(newWelcome);
                            fadeIn(newWelcome);
                        });

                        if (push) {
                            window.history.pushState({ url: url }, '', url);
                        }
                    })
                    .catch(err => {
                        console.error('Error swapping content:', err);
                        isSwapping = false;
                    });
            }

            loginBtn.addEventListener('click', function (e) {
                e.preventDefault();
                swapContent('/login');
            });

            window.addEventListener('popstate', function (e) {
                const url = e.state?.url || '/register';
                swapContent(url, false);
            });
        });
        </script>
    </body>
</html>