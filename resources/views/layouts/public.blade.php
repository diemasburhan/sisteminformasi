<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Sistem Informasi LPKIA')</title>
    <!-- Load Poppins and Roboto from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
</head>
@php
    $themeColor = \App\Models\Setting::get('theme_color', 'default');
    $layoutStyle = \App\Models\Setting::get('layout_style', 'full-width');
@endphp
<body class="theme-{{ $themeColor }} layout-{{ $layoutStyle }}">

    <!-- Header Navigation -->
    <header class="site-header">
        <div class="container header-container">
            <a href="{{ route('home') }}" class="logo-section" style="display: flex; align-items: center; text-decoration: none;">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Prodi Sistem Informasi LPKIA" style="height: 54px; max-width: 100%; object-fit: contain;">
            </a>
            
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <nav class="nav-menu" id="navMenu">
                @php
                    $navMenuJson = \App\Models\Setting::get('navigation_menu');
                    $navMenuItems = $navMenuJson ? json_decode($navMenuJson, true) : [
                        ["label" => "Home", "url" => "/", "children" => []],
                        ["label" => "Akademik", "url" => "#", "children" => [
                            ["label" => "Kurikulum", "url" => "/#kurikulum"],
                            ["label" => "Jadwal Kuliah", "url" => "/#jadwal"],
                            ["label" => "Kalender Akademik", "url" => "/#shortcut-menu"]
                        ]],
                        ["label" => "Profil Prodi", "url" => "/page/tentang-kami", "children" => []],
                        ["label" => "Berita", "url" => "/berita", "children" => []],
                        ["label" => "Kontak", "url" => "/page/kontak", "children" => []]
                    ];
                @endphp

                @foreach($navMenuItems as $item)
                    @if(isset($item['children']) && count($item['children']) > 0)
                        <!-- Dropdown Menu -->
                        <div class="nav-dropdown">
                            <a href="#" class="nav-link">
                                {{ $item['label'] }} <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i>
                            </a>
                            <div class="dropdown-content">
                                @foreach($item['children'] as $child)
                                    <a href="{{ $child['url'] }}">{{ $child['label'] }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Regular Link -->
                        <a href="{{ $item['url'] }}" class="nav-link {{ Request::url() == url($item['url']) || Request::is(trim($item['url'], '/')) ? 'active' : '' }}">{{ $item['label'] }}</a>
                    @endif
                @endforeach
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-gauge"></i> Admin Panel
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">
                        <i class="fa-solid fa-right-to-bracket"></i> Portal Login
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container footer-grid">
            <div class="footer-widget">
                <h3>Sistem Informasi LPKIA</h3>
                <p>Membangun profesional teknologi informasi global yang berintegritas, ahli dalam tata kelola IT, rekayasa perangkat lunak, dan analitik data digital.</p>
                <div class="social-links">
                    <a href="https://facebook.com/lpkia" target="_blank" class="social-icon" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://instagram.com/lpkia" target="_blank" class="social-icon" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://youtube.com/lpkia" target="_blank" class="social-icon" aria-label="Youtube"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://linkedin.com/school/lpkia" target="_blank" class="social-icon" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <div class="footer-widget">
                <h3>Akses Cepat</h3>
                <ul>
                    <li><a href="{{ route('home') }}"><i class="fa-solid fa-chevron-right"></i> Beranda</a></li>
                    <li><a href="{{ route('home') }}#kurikulum"><i class="fa-solid fa-chevron-right"></i> Kurikulum Jurusan</a></li>
                    <li><a href="{{ route('home') }}#jadwal"><i class="fa-solid fa-chevron-right"></i> Jadwal Perkuliahan</a></li>
                    <li><a href="{{ route('public.page.show', 'tentang-kami') }}"><i class="fa-solid fa-chevron-right"></i> Profil Program Studi</a></li>
                </ul>
            </div>
            
            <div class="footer-widget">
                <h3>Kontak & Informasi</h3>
                <p><i class="fa-solid fa-map-location-dot"></i> {{ \App\Models\Setting::get('site_address', 'Jl. Soekarno-Hatta No. 456, Bandung') }}</p>
                <p><i class="fa-solid fa-phone"></i> {{ \App\Models\Setting::get('site_phone', '(022) 7564200') }}</p>
                <p><i class="fa-solid fa-envelope"></i> {{ \App\Models\Setting::get('site_email', 'info@lpkia.ac.id') }}</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Program Studi Sistem Informasi LPKIA. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- Mobile Drawer Script -->
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');

        menuToggle.addEventListener('click', () => {
            navMenu.style.display = navMenu.style.display === 'flex' ? 'none' : 'flex';
            if (navMenu.style.display === 'flex') {
                navMenu.style.flexDirection = 'column';
                navMenu.style.position = 'absolute';
                navMenu.style.top = '80px';
                navMenu.style.left = '0';
                navMenu.style.width = '100%';
                navMenu.style.backgroundColor = 'var(--bg-white)';
                navMenu.style.padding = '20px';
                navMenu.style.gap = '15px';
                navMenu.style.borderBottom = '3px solid var(--primary)';
                navMenu.style.boxShadow = 'var(--shadow-md)';
            }
        });

        // Hide mobile menu on resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                navMenu.style.display = 'flex';
                navMenu.style.flexDirection = 'row';
                navMenu.style.position = 'static';
                navMenu.style.padding = '0';
                navMenu.style.gap = '28px';
                navMenu.style.backgroundColor = 'transparent';
                navMenu.style.borderBottom = 'none';
                navMenu.style.boxShadow = 'none';
            } else {
                navMenu.style.display = 'none';
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
