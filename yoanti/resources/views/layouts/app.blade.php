<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yoanti - @yield('title', 'Jasa Pembuatan Website & Aplikasi Android')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --bg: #F8FAFC;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --card-bg: #FFFFFF;
            --border: #E2E8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            line-height: 1.6;
            scroll-behavior: smooth;
        }

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.5px;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background-color: var(--primary);
            color: white;
            padding: 0.875rem 1.75rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            font-size: 1rem;
            z-index: 1;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.4);
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-menu-btn {
            background: none;
            border: none;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #F1F5F9;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .user-menu-btn svg {
            color: var(--text-muted);
            transition: color 0.3s ease;
        }

        .user-menu-btn:hover {
            background: var(--primary);
        }

        .user-menu-btn:hover svg {
            color: white;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 120%;
            background-color: white;
            min-width: 220px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            border: 1px solid var(--border);
            z-index: 1000;
            overflow: hidden;
        }

        .dropdown-content.show {
            display: block;
            animation: fadeInMenu 0.2s ease-in-out;
        }

        @keyframes fadeInMenu {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-header {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            background: #F8FAFC;
        }

        .dropdown-header strong {
            display: block;
            color: var(--text-main);
            font-size: 0.95rem;
        }

        .dropdown-header span {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: capitalize;
        }

        .dropdown-content a {
            color: var(--text-main);
            padding: 0.75rem 1rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            transition: background 0.2s;
        }

        .dropdown-content a:hover {
            background-color: #F1F5F9;
            color: var(--primary);
        }

        .dropdown-content a.logout {
            color: #EF4444;
            border-top: 1px solid var(--border);
        }
        
        .dropdown-content a.logout:hover {
            background-color: #FEF2F2;
        }

        /* Footer */
        footer {
            background: #0F172A;
            color: #94A3B8;
            text-align: center;
            padding: 3rem 5%;
            font-size: 0.95rem;
        }

        footer .logo {
            color: white;
            justify-content: center;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <nav>
        <a href="{{ url('/') }}" class="logo">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Yoanti
        </a>
        <div class="nav-links">
            @if(session()->has('user') && isset(session('user')['role']) && session('user')['role'] === 'superadmin')
                <a href="{{ url('/superadmin/dashboard') }}" class="nav-link {{ request()->is('superadmin/dashboard') ? 'active' : '' }}" style="color: #BE185D;">Dashboard</a>
                <a href="{{ url('/superadmin/pesanan') }}" class="nav-link {{ request()->is('superadmin/pesanan') ? 'active' : '' }}" style="color: #BE185D;">Pesanan</a>
                <a href="{{ url('/superadmin/user') }}" class="nav-link {{ request()->is('superadmin/user') ? 'active' : '' }}" style="color: #BE185D;">User</a>
                <a href="{{ url('/superadmin/komentar') }}" class="nav-link {{ request()->is('superadmin/komentar') ? 'active' : '' }}" style="color: #BE185D;">Komentar</a>
            @else
                <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ url('/komentar') }}" class="nav-link {{ request()->is('komentar') ? 'active' : '' }}">Komentar</a>
            @endif
            
            @if(session()->has('user'))
                @if(isset(session('user')['role']) && session('user')['role'] === 'admin')
                    <a href="{{ url('/admin/permintaan') }}" class="nav-link {{ request()->is('admin/permintaan') ? 'active' : '' }}" style="color: #10B981;">Permintaan</a>
                @endif
                <div class="user-dropdown">
                    <button onclick="toggleUserDropdown()" class="user-menu-btn" title="Settings">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                    </button>
                    <div id="userMenuDropdown" class="dropdown-content">
                        <div class="dropdown-header">
                            <strong>{{ session('user')['name'] }}</strong>
                            <span>{{ session('user')['role'] ?? 'User' }}</span>
                        </div>
                        @if(!isset(session('user')['role']) || (session('user')['role'] !== 'admin' && session('user')['role'] !== 'superadmin'))
                            <a href="{{ url('/pesanan-saya') }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                Pesanan Saya
                            </a>
                        @endif
                        <a href="{{ url('/logout') }}" class="logout">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Logout
                        </a>
                    </div>
                </div>
            @else
                <div class="user-dropdown">
                    <button onclick="toggleUserDropdown()" class="user-menu-btn" title="Settings">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                    </button>
                    <div id="userMenuDropdown" class="dropdown-content">
                        <div class="dropdown-header">
                            <strong>Guest</strong>
                            <span>Belum masuk</span>
                        </div>
                        <a href="{{ url('/login') }}" class="{{ request()->is('login') ? 'active' : '' }}" style="color: var(--primary);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            Login
                        </a>
                        <a href="{{ url('/pesan') }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </nav>

    @if(session('success') && !request()->is('login'))
        <div style="background: #D1FAE5; color: #065F46; padding: 1rem; text-align: center; border-bottom: 1px solid #34D399;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error') && !request()->is('login') && !request()->is('register'))
        <div style="background: #FEE2E2; color: #991B1B; padding: 1rem; text-align: center; border-bottom: 1px solid #F87171;">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

    <footer>
        <div class="logo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Yoanti
        </div>
        <p>&copy; 2026 Yoanti Tech. Jasa Pembuatan Website & Aplikasi Android Profesional.</p>
    </footer>

    @stack('scripts')
    <script>
        function toggleUserDropdown() {
            document.getElementById("userMenuDropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.closest('.user-menu-btn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>

</html>
