<section class="nav_container {{ $whiteBg ? 'white_bg_nav_container' : '' }}">
    <nav>
        <div class="logo_container">
            <a href="#">
                <img src="{{ $whiteBg ? '/images/default-no-logo.png' : '/images/white-no-logo.png' }}" alt="technospeak_icon">
            </a>
        </div>
        <div class="menu-toggle" aria-label="Toggle navigation">
            <div class="menu-li {{ $whiteBg ? 'menu_li_white' : '' }}"></div>
            <div class="menu-li {{ $whiteBg ? 'menu_li_white' : '' }}"></div>
            <div class="menu-li {{ $whiteBg ? 'menu_li_white' : '' }}"></div>
        </div>
        <div class="nav_block">
            <div class="nav-links">
                <ul>
                    <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }} {{ $whiteBg ? 'bg-wt' : '' }}">Home</a></li>
                    <li><a href="/about" class="{{ request()->is('about') ? 'active' : '' }} {{ $whiteBg ? 'bg-wt' : '' }}">About Us</a></li>
                    <li><a href="/trainings" class="{{ request()->is('trainings') ? 'active' : '' }} {{ $whiteBg ? 'bg-wt' : '' }}">Trainings</a></li>
                    <li><a href="/pricing" class="{{ request()->is('pricing') ? 'active' : '' }} {{ $whiteBg ? 'bg-wt' : '' }}">Pricing</a></li>
                    @unless(Auth::check())
                        <li><a href="/register" class="{{ request()->is('register') ? 'active' : '' }} {{ $whiteBg ? 'bg-wt' : '' }}">Sign Up/In</a></li>
                    @endunless
                </ul>
            </div>
            @if(Auth::check())
                <div class="user-info">
                    <a href="/dashboard" class="active {{ $whiteBg ? 'bg-wt' : '' }}">
                        {{ Auth::user()->name }}
                    </a>
                </div>
            @endif
        </div>
    </nav>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('.menu-toggle');
        const navBlock = document.querySelector('.nav_block');

        if (toggle && navBlock) {
            toggle.addEventListener('click', () => {
                navBlock.classList.toggle('active');
                toggle.classList.toggle('open'); 
            });
        }

        document.addEventListener('click', function (e) {
            if (!navBlock.contains(e.target) && !toggle.contains(e.target)) {
                navBlock.classList.remove('active');
                toggle.classList.remove('open');
            }
        });

        /* sticky nav */
        const navContainer = document.querySelector('.nav_container');
        const nav = navContainer.querySelector('nav');

        let navHeight = nav.offsetHeight;

        window.addEventListener('scroll', function () {
            const scrollY = window.scrollY;

            if (scrollY > 0) {
            navContainer.classList.add('scrolled');
            } else {
            navContainer.classList.remove('scrolled');
            }
            if (scrollY >= navHeight) {
            navContainer.classList.add('sticky');
            } else {
            navContainer.classList.remove('sticky');
            }
        });

        window.addEventListener('resize', function () {
            navHeight = nav.offsetHeight;
        });

    });
</script>

