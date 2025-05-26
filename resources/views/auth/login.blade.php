<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login - Technospeak</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/auth_register.css" type="text/css"/>
        <link rel="stylesheet" href="style/home.css" type="text/css" />
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
            </div>
        </section>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const registerBtn = document.getElementById('loadRegister');
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

                    fetch(url)
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            const newForm = doc.querySelector('#formSwapArea');
                            const newWelcome = doc.querySelector('.welcome_');

                            if (!newForm || !newWelcome) {
                                console.error('Swap elements missing in fetched content.');
                                isSwapping = false;
                                return;
                            }

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

                registerBtn?.addEventListener('click', function (e) {
                    e.preventDefault();
                    swapContent('/register');
                });

                window.addEventListener('popstate', function (e) {
                    const url = e.state?.url || '/login';
                    swapContent(url, false);
                });
            });
        </script>
    </body>
</html>