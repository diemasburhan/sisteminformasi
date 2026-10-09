<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem Informasi LPKIA')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-lpkiaa.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('styles')
</head>

@php
    $themeColor = \App\Models\Setting::get('theme_color', 'default');
    $layoutStyle = \App\Models\Setting::get('layout_style', 'full-width');
@endphp

<body class="theme-{{ $themeColor }} layout-{{ $layoutStyle }}">

    <main>
        @yield('content')
    </main>

    <!-- MinSI FAQ Bot Component -->
    @include('components.minsi-widget')

    <!-- Mobile Drawer Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const menuToggle = document.getElementById('menuToggle');
            const navMenu = document.getElementById('navMenu');

            if (!menuToggle || !navMenu) {
                return;
            }

            menuToggle.addEventListener('click', function () {

                navMenu.style.display =
                    navMenu.style.display === 'flex' ? 'none' : 'flex';

                if (navMenu.style.display === 'flex') {

                    navMenu.style.flexDirection = 'column';
                    navMenu.style.position = 'absolute';
                    navMenu.style.top = '80px';
                    navMenu.style.left = '0';
                    navMenu.style.width = '100%';
                    navMenu.style.backgroundColor = 'var(--bg-white)';

                }

            });

            window.addEventListener('resize', function () {

                if (window.innerWidth > 768) {
                    navMenu.style.display = '';
                }

            });

        });
    </script>

    @yield('scripts')

</body>
</html>