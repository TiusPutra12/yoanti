<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#2563EB">
    <meta name="description" content="Yoanti - Jasa Pembuatan Website & Aplikasi Android Profesional">
    <title>Yoanti - @yield('title', 'Jasa Pembuatan Website & Aplikasi Android')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --primary-light: rgba(37, 99, 235, 0.1);
            --bg: #F8FAFC;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --card-bg: #FFFFFF;
            --border: #E2E8F0;
            --nav-height: 68px;
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.1);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);

            /* Global Validation Variables */
            --error: #DC2626;
            --error-bg: #FEF2F2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        html {
            font-size: 16px;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            line-height: 1.6;
            scroll-behavior: smooth;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ── GLOBAL BUTTON STYLES ── */
        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* ── NAVBAR ── */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 clamp(1rem, 5%, 2.5rem);
            height: var(--nav-height);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 1px 0 rgba(226, 232, 240, 0.8), 0 4px 20px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: -0.5px;
            z-index: 1002;
            flex-shrink: 0;
        }

        .logo svg {
            color: var(--primary);
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-links {
            display: flex;
            gap: 0.25rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            position: relative;
            padding: 0.5rem 0.75rem;
            border-radius: var(--radius-sm);
        }

        .nav-link:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .nav-link.active {
            color: var(--primary);
            background: var(--primary-light);
        }

        /* Hamburger */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-main);
            cursor: pointer;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            z-index: 1002;
            border-radius: var(--radius-sm);
            transition: background 0.2s;
        }

        .mobile-menu-btn:hover {
            background: #F1F5F9;
        }

        /* User Dropdown */
        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-menu-btn {
            background: #F1F5F9;
            border: 1.5px solid var(--border);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            cursor: pointer;
        }

        .user-menu-btn svg {
            color: var(--text-muted);
            transition: color 0.2s;
        }

        .user-menu-btn:hover {
            background: #E2E8F0;
            border-color: #CBD5E1;
        }

        .user-menu-btn:hover svg {
            color: var(--primary);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            background-color: #FFFFFF;
            min-width: 240px;
            box-shadow: var(--shadow-lg), 0 0 0 1px rgba(0, 0, 0, 0.05);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            z-index: 1000;
            overflow: hidden;
            transform-origin: top right;
        }

        .dropdown-content.show {
            display: block;
            animation: dropdownFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-8px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .dropdown-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            background: #F8FAFC;
        }

        .dropdown-header strong {
            display: block;
            color: var(--text-main);
            font-size: 0.95rem;
            font-weight: 700;
        }

        .dropdown-header span {
            font-size: 0.78rem;
            color: var(--text-muted);
            text-transform: capitalize;
            font-weight: 500;
        }

        .dropdown-content a {
            color: var(--text-main);
            padding: 0.8rem 1.25rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background 0.15s;
        }

        .dropdown-content a:hover {
            background-color: #F8FAFC;
            color: var(--primary);
        }

        .dropdown-content a.logout {
            color: #DC2626;
            border-top: 1px solid var(--border);
        }

        .dropdown-content a.logout:hover {
            background-color: #FEF2F2;
        }

        /* ── TOAST NOTIFICATIONS ── */
        .toast-container {
            position: fixed;
            top: calc(var(--nav-height) + 1rem);
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: 90%;
            max-width: 420px;
            pointer-events: none;
        }

        .toast {
            padding: 0.9rem 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: var(--shadow-md);
            animation: toastAnim 4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            pointer-events: auto;
        }

        @keyframes toastAnim {
            0% {
                opacity: 0;
                transform: translateY(-16px);
            }

            8% {
                opacity: 1;
                transform: translateY(0);
            }

            85% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-16px);
            }
        }

        .toast-success {
            background: #ECFDF5;
            color: #059669;
            border: 1px solid #A7F3D0;
        }

        .toast-error {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
        }

        /* ── FOOTER ── */
        footer {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            color: #94A3B8;
            padding: clamp(2.5rem, 6vw, 4rem) clamp(1rem, 5%, 2.5rem);
            border-top: 1px solid #1E293B;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 2rem;
            align-items: center;
        }

        footer .logo {
            color: white;
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        footer .logo svg {
            color: var(--primary);
        }

        .footer-tagline {
            font-size: 0.875rem;
            color: #64748B;
            line-height: 1.5;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            align-items: flex-end;
        }

        .footer-links a {
            color: #64748B;
            text-decoration: none;
            font-size: 0.825rem;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: #CBD5E1;
        }

        .footer-copyright {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #1E293B;
            text-align: center;
            font-size: 0.8rem;
            color: #475569;
        }

        /* ── GLOBAL VALIDATION UTILITIES ── */
        .error-message {
            color: var(--error);
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.25rem;
            display: none;
            animation: fadeIn 0.2s ease;
        }

        .form-control.is-invalid {
            border-color: var(--error) !important;
            background-color: var(--error-bg);
        }

        .shake {
            animation: shake 0.4s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-3px, 0, 0); }
            40%, 60% { transform: translate3d(3px, 0, 0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── MOBILE RESPONSIVE ── */
        @media (max-width: 768px) {
            :root {
                --nav-height: 64px;
            }

            .mobile-menu-btn {
                display: flex;
            }

            .nav-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100dvh;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 1.5rem;
                transform: translateY(-100%);
                transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
                z-index: 1001;
                opacity: 0;
                visibility: hidden;
            }

            .nav-wrapper.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }

            .nav-links {
                flex-direction: column;
                gap: 0.35rem; /* Reduced gap */
                text-align: center;
                width: 100%;
                padding: 0 1.25rem;
            }

            .nav-link {
                font-size: 1rem; /* Slightly smaller font for mobile info density */
                padding: 0.75rem 1.25rem;
                width: 100%;
                display: block;
                text-align: center;
                border-radius: var(--radius-md);
            }

            .user-dropdown {
                width: 100%;
                padding: 0 1.5rem;
            }

            .user-menu-btn {
                width: 100%;
                height: 52px;
                border-radius: var(--radius-md);
                font-weight: 600;
                gap: 0.5rem;
                font-size: 1rem;
                font-family: 'Inter', sans-serif;
            }

            .user-menu-btn::after {
                content: 'Akun Saya';
                font-size: 1rem;
                font-weight: 600;
            }

            .dropdown-content {
                position: relative;
                top: 0;
                right: 0;
                width: 100%;
                box-shadow: none;
                border: 1.5px solid var(--border);
                margin-top: 0.75rem;
                border-radius: var(--radius-md);
            }

            .footer-inner {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-links {
                align-items: center;
                flex-direction: row;
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.5rem 1.5rem;
            }
        }

        @media (max-width: 480px) {
            html {
                font-size: 15px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <nav>
        <a href="{{ url('/') }}" class="logo">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Yoanti
        </a>

        <button type="button" class="mobile-menu-btn" onclick="toggleMobileNav()" id="hamburgerBtn" aria-label="Menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <div class="nav-wrapper" id="navWrapper">
            <div class="nav-links">
                @if (session()->has('user') && isset(session('user')['role']) && session('user')['role'] === 'superadmin')
                    <a href="{{ url('/superadmin/dashboard') }}"
                        class="nav-link {{ request()->is('superadmin/dashboard') ? 'active' : '' }}"
                        style="color: #BE185D;">Dashboard</a>
                    <a href="{{ url('/superadmin/pesanan') }}"
                        class="nav-link {{ request()->is('superadmin/pesanan') ? 'active' : '' }}"
                        style="color: #BE185D;">Pesanan</a>
                    <a href="{{ url('/superadmin/user') }}"
                        class="nav-link {{ request()->is('superadmin/user') ? 'active' : '' }}"
                        style="color: #BE185D;">User</a>
                    <a href="{{ url('/superadmin/komentar') }}"
                        class="nav-link {{ request()->is('superadmin/komentar') ? 'active' : '' }}"
                        style="color: #BE185D;">Komentar</a>
                @else
                    <a href="{{ url('/') }}"
                        class="nav-link {{ request()->is('/') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ url('/komentar') }}"
                        class="nav-link {{ request()->is('komentar') ? 'active' : '' }}">Komentar</a>
                @endif

                @if (session()->has('user') && isset(session('user')['role']) && session('user')['role'] === 'admin')
                    <a href="{{ url('/admin/permintaan') }}"
                        class="nav-link {{ request()->is('admin/permintaan') ? 'active' : '' }}"
                        style="color: #059669;">Permintaan</a>
                @endif
            </div>

            <div class="user-dropdown">
                <button type="button" onclick="toggleUserDropdown(event)" class="user-menu-btn" title="Menu Pengguna">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </button>
                <div id="userMenuDropdown" class="dropdown-content">
                    @if (session()->has('user'))
                        <div class="dropdown-header">
                            <strong>{{ session('user')['name'] }}</strong>
                            <span>{{ session('user')['role'] ?? 'User' }}</span>
                        </div>
                        @if (
                            !isset(session('user')['role']) ||
                                (session('user')['role'] !== 'admin' && session('user')['role'] !== 'superadmin'))
                            <a href="{{ url('/pesanan-saya') }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                                    <path d="M3 6h18" />
                                    <path d="M16 10a4 4 0 0 1-8 0" />
                                </svg>
                                Pesanan Saya
                            </a>
                        @endif
                        <a href="{{ url('/logout') }}" class="logout">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Keluar
                        </a>
                    @else
                        <div class="dropdown-header">
                            <strong>Tamu</strong>
                            <span>Belum masuk</span>
                        </div>
                        <a href="{{ url('/login') }}" style="color: var(--primary);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <polyline points="10 17 15 12 10 7" />
                                <line x1="15" y1="12" x2="3" y2="12" />
                            </svg>
                            Masuk ke Akun
                        </a>
                        <a href="{{ url('/pesan') }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                            </svg>
                            Mulai Pemesanan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="toast-container">
        @if (session('success') && !request()->is('login'))
            <div class="toast toast-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error') && !request()->is('login') && !request()->is('register'))
            <div class="toast toast-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                {{ session('error') }}
            </div>
        @endif
    </div>

    @yield('content')

    <footer>
        <div class="footer-inner">
            <div>
                <a href="{{ url('/') }}" class="logo">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Yoanti
                </a>
                <p class="footer-tagline">Solusi digital profesional untuk bisnis masa depan.</p>
            </div>
            <div class="footer-links">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ url('/komentar') }}">Testimoni</a>
                <a href="{{ url('/pesan') }}">Kontak</a>
                <a href="{{ url('/privacy') }}">Privasi</a>
                <a href="{{ url('/terms') }}">Syarat</a>
            </div>
        </div>
        <div class="footer-copyright">
            &copy; {{ date('Y') }} Yoanti Tech. Semua hak dilindungi.
        </div>
    </footer>

    @stack('scripts')
    <script>
        function toggleUserDropdown(e) {
            if (e) e.stopPropagation();
            const dropdown = document.getElementById("userMenuDropdown");
            if (dropdown) dropdown.classList.toggle("show");
        }

        function toggleMobileNav() {
            const nav = document.getElementById("navWrapper");
            const btn = document.getElementById("hamburgerBtn");
            if (!nav || !btn) return;

            nav.classList.toggle("active");
            if (nav.classList.contains("active")) {
                btn.innerHTML =
                    `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`;
                document.body.style.overflow = "hidden";
            } else {
                btn.innerHTML =
                    `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>`;
                document.body.style.overflow = "";
            }
        }

        // Handle click di luar menu/dropdown
        window.addEventListener('click', function(event) {
            // Dropdown Menu Profil
            if (!event.target.closest('.user-dropdown')) {
                document.querySelectorAll(".dropdown-content.show").forEach(el => el.classList.remove('show'));
            }
            // Mobile Navigation Toggle
            if (!event.target.closest('nav') && !event.target.closest('.mobile-menu-btn')) {
                const nav = document.getElementById("navWrapper");
                const btn = document.getElementById("hamburgerBtn");
                if (nav && nav.classList.contains("active")) {
                    nav.classList.remove("active");
                    if (btn) btn.innerHTML =
                        `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>`;
                    document.body.style.overflow = "";
                }
            }
        });
    </script>
</body>

</html>
