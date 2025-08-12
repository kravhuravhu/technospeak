<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $title ?? 'Auth Page' }} - Technospeak</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="@secureAsset('style/auth_register.css')" type="text/css" />
    <link rel="stylesheet" href="@secureAsset('style/home.css')" type="text/css" />
    <link rel="icon" href="@secureAsset('images/icon.png')" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <section class="register_container">
        <div class="main_container"  style="{{ Request::is('forgot-password') || Request::is('reset-password*') || Request::is('confirm-password') ? 'width: auto;' : '' }}">
            @yield('welcome')
            @yield('form')
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
