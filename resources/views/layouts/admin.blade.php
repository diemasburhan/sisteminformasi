<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token for AJAX Auto-save -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Sistem Informasi LPKIA')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
</head>
<body>

    <div class="admin-layout">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-logo">
                    <i class="fa-solid fa-graduation-cap" style="color: var(--secondary)"></i>
                    <span>ADMIN<span>LPKIA</span></span>
                </a>
            </div>

            <ul class="admin-sidebar-menu">
                <li class="admin-menu-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="admin-menu-link">
                        <i class="fa-solid fa-gauge"></i> Dashboard
                    </a>
                </li>
                
                <!-- Posts Submenu -->
                <li class="admin-menu-item {{ Request::is('admin/posts*') ? 'active' : '' }}">
                    <a href="#" class="admin-menu-link" onclick="toggleSubmenu('postsSubmenu', event)">
                        <i class="fa-solid fa-file-lines"></i> Posts 
                        <i class="fa-solid fa-chevron-down" style="margin-left: auto; font-size: 0.75rem;"></i>
                    </a>
                    <ul class="admin-submenu" id="postsSubmenu" style="display: {{ Request::is('admin/posts*') ? 'block' : 'none' }};">
                        <li class="admin-submenu-item {{ Route::is('admin.posts.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.posts.index') }}" class="admin-submenu-link"><i class="fa-solid fa-list"></i> All Posts</a>
                        </li>
                        <li class="admin-submenu-item {{ Route::is('admin.posts.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.posts.create') }}" class="admin-submenu-link"><i class="fa-solid fa-plus"></i> Add New</a>
                        </li>
                    </ul>
                </li>

                <!-- Pages Submenu -->
                <li class="admin-menu-item {{ Request::is('admin/pages*') ? 'active' : '' }}">
                    <a href="#" class="admin-menu-link" onclick="toggleSubmenu('pagesSubmenu', event)">
                        <i class="fa-solid fa-newspaper"></i> Pages 
                        <i class="fa-solid fa-chevron-down" style="margin-left: auto; font-size: 0.75rem;"></i>
                    </a>
                    <ul class="admin-submenu" id="pagesSubmenu" style="display: {{ Request::is('admin/pages*') ? 'block' : 'none' }};">
                        <li class="admin-submenu-item {{ Route::is('admin.pages.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.pages.index') }}" class="admin-submenu-link"><i class="fa-solid fa-list"></i> All Pages</a>
                        </li>
                        <li class="admin-submenu-item {{ Route::is('admin.pages.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.pages.create') }}" class="admin-submenu-link"><i class="fa-solid fa-plus"></i> Add New</a>
                        </li>
                    </ul>
                </li>

                <li class="admin-menu-item">
                    <a href="#" class="admin-menu-link" onclick="showToast('Fitur Library Media tersedia dalam versi integrasi lengkap cloud.', 'info')">
                        <i class="fa-solid fa-images"></i> Media Library
                    </a>
                </li>

                <li class="admin-menu-item {{ Route::is('admin.settings.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}" class="admin-menu-link">
                        <i class="fa-solid fa-gears"></i> Settings
                    </a>
                </li>
            </ul>

            <div class="admin-sidebar-footer">
                <span>Versi 1.0.0</span>
                <a href="{{ route('home') }}" target="_blank" style="color: var(--secondary-light); font-weight: 600;"><i class="fa-solid fa-globe"></i> Lihat Situs</a>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="admin-main">
            <!-- Navbar -->
            <header class="admin-navbar">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <button class="menu-toggle" id="adminSidebarToggle" style="color: var(--text-dark); display: none;">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h2 class="admin-navbar-title">@yield('page_title', 'Dashboard')</h2>
                </div>
                
                <div class="admin-navbar-user">
                    <div class="admin-user-info">
                        <div class="admin-user-name">{{ Auth::user()->name }}</div>
                        <div class="admin-user-role">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST" style="margin-left: 10px;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Inner Page Content -->
            <div class="admin-content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Toast Notifications Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Toast notifications and general Admin scripts -->
    <script>
        // Toggle Sidebar on Mobile
        const sidebarToggle = document.getElementById('adminSidebarToggle');
        const adminSidebar = document.getElementById('adminSidebar');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                adminSidebar.classList.toggle('active');
            });
        }

        // Adjust sidebar toggle display
        function checkMobile() {
            if (window.innerWidth <= 1024) {
                sidebarToggle.style.display = 'block';
            } else {
                sidebarToggle.style.display = 'none';
                adminSidebar.classList.remove('active');
            }
        }
        window.addEventListener('resize', checkMobile);
        window.addEventListener('load', checkMobile);

        // Sidebar Submenu toggle helper
        function toggleSubmenu(id, event) {
            event.preventDefault();
            const submenu = document.getElementById(id);
            if (submenu.style.display === 'block') {
                submenu.style.display = 'none';
            } else {
                submenu.style.display = 'block';
            }
        }

        // Beautiful Toast Notification System
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast-message ${type}`;
            
            let icon = '<i class="fa-solid fa-circle-check"></i>';
            if (type === 'danger') {
                icon = '<i class="fa-solid fa-circle-exclamation"></i>';
            } else if (type === 'info') {
                icon = '<i class="fa-solid fa-circle-info"></i>';
            }

            toast.innerHTML = `${icon} <span>${message}</span>`;
            container.appendChild(toast);

            // Show animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);

            // Fade out and remove
            setTimeout(() => {
                toast.style.transform = 'translateY(100px)';
                toast.style.opacity = '0';
                setTimeout(() => {
                    toast.remove();
                }, 400);
            }, 4000);
        }
    </script>
    @yield('scripts')
</body>
</html>
