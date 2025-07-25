<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | TechnoSpeak Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('style/admin.css') }}" type="text/css">
    <link rel="icon" href="{{ asset('/images/icon.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>
<body>
    <div class="admin-container">
        @include('content-manager.components.sidebar')
        
        <div class="admin-main">
            @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Mobile menu toggle
        $(document).ready(function() {
            $('.mobile-menu-toggle').click(function() {
                $('.admin-sidebar').toggleClass('mobile-open');
            });
            
            // Active menu item highlighting
            const currentPath = window.location.pathname;
            $('.sidebar-menu li a').each(function() {
                if ($(this).attr('href') === currentPath) {
                    $(this).addClass('active');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>