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

        /* Sembunyikan elemen mobile dari desktop */
        .mobile-nav-profile,
        .mobile-nav-footer,
        .nav-divider,
        .nav-link svg,
        .mobile-close-btn,
        .mobile-close-container,
        .mobile-only {
            display: none !important;
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

        /* ── NOTIFICATIONS POPUP ── */
        .notif-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 2000;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .notif-modal-overlay.show {
            display: flex;
            opacity: 1;
        }

        .notif-modal {
            background: #FFFFFF;
            width: 100%;
            max-width: 480px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg), 0 0 0 1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transform: scale(0.9) translateY(20px);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            max-height: 85vh;
            display: flex;
            flex-direction: column;
        }

        .notif-modal-overlay.show .notif-modal {
            transform: scale(1) translateY(0);
        }

        .notif-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #F8FAFC;
        }

        .notif-modal-header h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin: 0;
        }

        .notif-close-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .notif-close-btn:hover {
            background: #F1F5F9;
            color: var(--primary);
            transform: rotate(90deg);
        }

        .notif-modal-body {
            overflow-y: auto;
            flex: 1;
            padding: 0.5rem 0;
        }

        .notif-card {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #F1F5F9;
            display: flex;
            gap: 1.25rem;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            text-decoration: none;
        }

        .notif-card:last-child {
            border-bottom: none;
        }

        .notif-card:hover {
            background: #F8FAFC;
        }

        .notif-card.unread {
            background: rgba(37, 99, 235, 0.03);
        }

        .notif-card.unread::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary);
        }

        .notif-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .notif-card:hover .notif-card-icon {
            transform: scale(1.1) rotate(-5deg);
            background: var(--primary);
            color: white;
        }

        .notif-card-content {
            flex: 1;
        }

        .notif-card-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-main);
            margin-bottom: 0.25rem;
            display: block;
        }

        .notif-card-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 0.5rem;
            display: block;
        }

        .notif-card-time {
            font-size: 0.75rem;
            color: #94A3B8;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .notif-modal-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: center;
            background: #F8FAFC;
        }

        .btn-mark-read {
            background: white;
            border: 1px solid var(--border);
            padding: 0.6rem 1.2rem;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-mark-read:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .notif-empty {
            padding: 4rem 2rem;
            text-align: center;
        }

        .notif-empty-icon {
            width: 80px;
            height: 80px;
            background: #F1F5F9;
            color: #CBD5E1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        .notif-empty h4 {
            color: var(--text-main);
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .notif-empty p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .notif-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            background: #DC2626;
            color: white;
            font-size: 0.6rem;
            font-weight: 800;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 2px solid #F1F5F9;
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
            animation: shake 0.4s cubic-bezier(.36, .07, .19, .97) both;
        }

        @keyframes shake {

            10%,
            90% {
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                transform: translate3d(-3px, 0, 0);
            }

            40%,
            60% {
                transform: translate3d(3px, 0, 0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
                background: #FFFFFF;
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                gap: 0;
                transform: translateX(100%);
                transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                z-index: 1005;
                opacity: 1;
                visibility: hidden;
                overflow-y: hidden;
                /* Dilarang scroll penuh, nav-links yang akan di-scroll */
            }

            .nav-wrapper.active {
                transform: translateX(0);
                opacity: 1;
                visibility: visible;
            }

            /* Container Tombol Close Universal */
            .mobile-close-container {
                display: flex !important;
                width: 100%;
                justify-content: flex-end;
                padding: 15px;
                position: absolute;
                top: 0;
                left: 0;
                z-index: 20;
                pointer-events: none;
            }

            .mobile-close-btn-universal {
                width: 38px;
                height: 38px;
                border-radius: 8px;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                pointer-events: auto;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                transition: transform 0.2s;
            }

            .mobile-close-btn-universal:active {
                transform: scale(0.9);
            }

            /* Hapus dropdown desktop dari mobile */
            .user-dropdown,
            .notification-dropdown {
                display: none !important;
            }

            /* ── MOBILE PROFILE HEADER (LOGGED IN) ── */
            .mobile-nav-profile {
                width: 100%;
                position: relative;
                background: #111827;
                margin-bottom: 2rem;
                display: block !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .mobile-nav-cover {
                width: 100%;
                height: 140px;
                background: linear-gradient(135deg, #1E3A8A 0%, #3B82F6 100%);
                position: relative;
                overflow: hidden;
            }

            .mobile-nav-cover::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 60%;
                background: linear-gradient(to top, #111827, transparent);
            }

            .mobile-nav-cover img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .mobile-nav-avatar-wrapper {
                position: relative;
                display: flex;
                justify-content: center;
                margin-top: -45px;
                z-index: 2;
            }

            .mobile-nav-avatar {
                width: 90px;
                height: 90px;
                border-radius: 50%;
                border: 4px solid #111827;
                background: #fff;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            }

            .mobile-nav-avatar img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .mobile-nav-info {
                text-align: center;
                padding: 1rem 1.5rem 1.5rem;
                background: #111827;
            }

            .mobile-nav-name {
                display: block;
                font-weight: 800;
                color: #fff;
                font-size: 1.1rem;
                margin-bottom: 0.2rem;
            }

            .mobile-nav-username {
                display: block;
                font-size: 0.85rem;
                color: #94A3B8;
                font-weight: 500;
            }

            .mobile-nav-header-btn {
                background: none;
                border: none;
                color: #fff;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                padding: 4px;
                transition: transform 0.2s;
            }

            .mobile-nav-header-btn:active {
                transform: scale(0.9);
            }

            .mobile-nav-header-btn.logout {
                color: #fff;
            }

            .mobile-nav-header-btn .badge {
                position: absolute;
                top: -4px;
                right: -4px;
                background: #EF4444;
                color: white;
                font-size: 0.6rem;
                min-width: 15px;
                height: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                border: 1.5px solid #111827;
                font-weight: 800;
            }

            /* ── NAV LINKS (FLEX SCROLLABLE) ── */
            .nav-links {
                flex-direction: column;
                gap: 0.75rem;
                text-align: left;
                width: 100%;
                padding: 0 1.5rem 1.5rem;
                flex: 1;
                overflow-y: auto;
            }

            .nav-link {
                font-size: 0.95rem;
                padding: 0.9rem 1.25rem;
                width: 100%;
                display: flex;
                align-items: center;
                gap: 1rem;
                text-align: left;
                background: #F8FAFC;
                border: 1px solid #F1F5F9;
                border-radius: 14px;
                color: var(--text-main);
                font-weight: 600;
                transition: var(--transition);
            }

            .nav-link:active {
                background: var(--primary-light);
                color: var(--primary);
                transform: scale(0.98);
            }

            .nav-link svg {
                display: block !important;
                color: #64748b;
                width: 20px;
                height: 20px;
                opacity: 0.8;
            }

            .nav-link.active {
                background: var(--primary);
                color: white;
                border-color: var(--primary);
            }

            .nav-link.active svg {
                color: white;
                opacity: 1;
            }

            .nav-divider {
                width: calc(100% - 3rem);
                height: 1px;
                background: #E2E8F0;
                margin: 0.5rem 1.5rem 1.5rem;
                display: block !important;
            }

            /* ── BOTTOM NAV FOOTER (GUEST LOGIN) ── */
            .mobile-nav-footer {
                display: flex !important;
            }

            .mobile-only {
                display: flex !important;
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

            <!-- Tombol Close Universal untuk Mobile (Bisa ditekan saat login maupun logout) -->
            <div class="mobile-close-container mobile-only">
                <button type="button" class="mobile-close-btn-universal" onclick="toggleMobileNav()"
                    style="{{ session()->has('user') ? 'background: rgba(255, 255, 255, 0.2); color: white; backdrop-filter: blur(4px); box-shadow: none;' : 'background: #FFFFFF; color: #0F172A; border: 1px solid #E2E8F0;' }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            @if (session()->has('user'))
                @php
                    $notifsContent = \Illuminate\Support\Facades\Storage::exists('notifications.json')
                        ? \Illuminate\Support\Facades\Storage::get('notifications.json')
                        : '[]';
                    $allNotifs = json_decode($notifsContent, true) ?: [];
                    $myNotifs = array_filter($allNotifs, function ($n) {
                        return $n['username'] === session('user')['username'];
                    });
                    $myNotifs = array_reverse($myNotifs); // terbaru di atas
                    $unreadCount = count(
                        array_filter($myNotifs, function ($n) {
                            return !$n['is_read'];
                        }),
                    );
                    $topNotifs = array_slice($myNotifs, 0, 5); // tampilkan 5 teratas
                @endphp
                <div class="mobile-nav-profile">
                    <div class="mobile-nav-cover">
                        @if (isset(session('user')['cover_photo']) && session('user')['cover_photo'])
                            <img src="{{ asset(session('user')['cover_photo']) }}" alt="Cover">
                        @endif
                    </div>
                    <div class="mobile-nav-avatar-wrapper">
                        <div class="mobile-nav-avatar">
                            @if (isset(session('user')['avatar']) && session('user')['avatar'])
                                <img src="{{ asset(session('user')['avatar']) }}" alt="Avatar">
                            @else
                                <span
                                    style="font-size: 2rem; font-weight: 800; color: var(--primary);">{{ strtoupper(substr(session('user')['name'], 0, 1)) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mobile-nav-info">
                        <span class="mobile-nav-name">{{ session('user')['name'] }}</span>
                        <div
                            style="position: relative; display: flex; align-items: center; justify-content: center; margin-top: 0.35rem; min-height: 24px;">
                            <span class="mobile-nav-username">@ {{ session('user')['username'] }}</span>
                            <div
                                style="position: absolute; right: 0; display: flex; align-items: center; gap: 0.85rem;">
                                <button type="button" onclick="toggleNotifModal(true)" class="mobile-nav-header-btn"
                                    title="Notifikasi">
                                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                    </svg>
                                    @if ($unreadCount > 0)
                                        <span class="badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                                    @endif
                                </button>
                                <a href="{{ url('/logout') }}" class="mobile-nav-header-btn logout" title="Keluar">
                                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- GUEST MOBILE HEADER (Agar bagian atas tidak putih kosong saat logout) -->
                <div class="mobile-nav-profile guest-profile mobile-only"
                    style="background: #F8FAFC; box-shadow: none; border-bottom: 1px solid #E2E8F0; margin-bottom: 1rem; width: 100%;">
                    <div style="padding: 3.5rem 1.5rem 1.5rem; text-align: left;">
                        <h3
                            style="color: var(--text-main); font-weight: 800; font-size: 1.3rem; margin-bottom: 0.25rem;">
                            Selamat Datang!</h3>
                        <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5;">Jelajahi layanan
                            profesional kami dan mulai wujudkan proyek impian Anda.</p>
                    </div>
                </div>
            @endif

            <div class="nav-links">
                <!-- MENU UTAMA DESKTOP & MOBILE -->
                @if (session()->has('user') && isset(session('user')['role']) && session('user')['role'] === 'superadmin')
                    <a href="{{ url('/superadmin/dashboard') }}"
                        class="nav-link {{ request()->is('superadmin/dashboard') ? 'active' : '' }}"
                        style="color: #BE185D;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M3 9h18M9 21V9" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ url('/superadmin/pesanan') }}"
                        class="nav-link {{ request()->is('superadmin/pesanan') ? 'active' : '' }}"
                        style="color: #BE185D;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                        </svg>
                        Pesanan
                    </a>
                    <a href="{{ url('/superadmin/user') }}"
                        class="nav-link {{ request()->is('superadmin/user') ? 'active' : '' }}"
                        style="color: #BE185D;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                        User
                    </a>
                    <a href="{{ url('/superadmin/komentar') }}"
                        class="nav-link {{ request()->is('superadmin/komentar') ? 'active' : '' }}"
                        style="color: #BE185D;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path
                                d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.3 8.38 8.38 0 0 1 3.8.9L21 3z" />
                        </svg>
                        Komentar
                    </a>
                @else
                    @if (session()->has('user') && isset(session('user')['role']) && session('user')['role'] === 'job_provider')
                        <a href="{{ url('/penyedia/dashboard') }}"
                            class="nav-link {{ request()->is('penyedia/dashboard') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ url('/penyedia/pesanan') }}"
                            class="nav-link {{ request()->is('penyedia/pesanan') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Pesanan Masuk
                        </a>
                    @else
                        <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ url('/produk') }}"
                            class="nav-link {{ request()->is('produk') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                                <path d="M3 6h18" />
                            </svg>
                            Produk
                        </a>
                    @endif

                    <a href="{{ url('/komentar') }}"
                        class="nav-link {{ request()->is('komentar') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path
                                d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.3 8.38 8.38 0 0 1 3.8.9L21 3z" />
                        </svg>
                        Testimoni
                    </a>

                    @if (session()->has('user') && in_array(session('user')['role'], ['admin', 'superadmin', 'job_seeker']))
                        <a href="{{ url('/penyedia-jasa') }}"
                            class="nav-link {{ request()->is('penyedia-jasa') ? 'active' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            Penyedia Jasa
                        </a>
                    @endif
                @endif

                @if (session()->has('user') && isset(session('user')['role']) && session('user')['role'] === 'admin')
                    <a href="{{ url('/admin/permintaan') }}"
                        class="nav-link {{ request()->is('admin/permintaan') ? 'active' : '' }}"
                        style="color: #059669;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                        Permintaan
                    </a>
                @endif

                <!-- ========================================== -->
                <!-- MENU EKSKLUSIF MOBILE (ANDROID) LOGGED IN -->
                <!-- ========================================== -->
                @if (session()->has('user'))
                    <div class="nav-divider mobile-only"></div>

                    @if (isset(session('user')['role']) && session('user')['role'] === 'job_provider')
                        <a href="{{ url('/penyedia-jasa/' . session('user')['username']) }}"
                            class="nav-link mobile-only">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Lihat Profil Saya
                        </a>
                    @endif

                    @if (
                        !isset(session('user')['role']) ||
                            (session('user')['role'] !== 'admin' && session('user')['role'] !== 'superadmin'))
                        <a href="{{ url('/pesanan-saya') }}" class="nav-link mobile-only">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                                <path d="M3 6h18" />
                                <path d="M16 10a4 4 0 0 1-8 0" />
                            </svg>
                            Pesanan Saya
                        </a>
                    @endif

                    <a href="{{ url('/pengaturan-akun') }}" class="nav-link mobile-only">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                        Pengaturan Akun
                    </a>
                @endif
            </div>

            <!-- ========================================== -->
            <!-- MENU FOOTER GUEST MOBILE (TERKUNCI DI BAWAH) -->
            <!-- ========================================== -->
            @if (!session()->has('user'))
                <div class="mobile-nav-footer mobile-only"
                    style="width: 100%; padding: 1.5rem; background: #FFFFFF; border-top: 1px solid #E2E8F0; display: flex; flex-direction: column; gap: 0.75rem; margin-top: auto;">
                    <a href="{{ url('/login') }}" class="btn-primary"
                        style="width: 100%; border-radius: 12px; padding: 0.85rem; font-size: 0.95rem; font-weight: 700;">
                        Masuk ke Akun
                    </a>
                    <a href="{{ url('/pesan') }}"
                        style="width: 100%; border-radius: 12px; padding: 0.85rem; font-size: 0.95rem; font-weight: 700; background: #F8FAFC; color: var(--text-main); border: 1px solid var(--border); text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: background 0.2s;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path
                                d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                        </svg>
                        Mulai Pemesanan
                    </a>
                </div>
            @endif

            @if (session()->has('user'))
                <button type="button" onclick="toggleNotifModal(true)" class="user-menu-btn notification-dropdown"
                    style="position: relative; margin-right: 0.5rem;" title="Notifikasi">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    @if ($unreadCount > 0)
                        <span class="notif-badge" id="notifBadge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </button>
            @endif

            <div class="user-dropdown">
                <button type="button" onclick="toggleUserDropdown(event)" class="user-menu-btn"
                    title="Menu Pengguna" style="padding: 0; overflow: hidden;">
                    @if (session()->has('user') && isset(session('user')['avatar']) && session('user')['avatar'])
                        <img src="{{ asset(session('user')['avatar']) }}" alt="Avatar"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    @endif
                </button>
                <div id="userMenuDropdown" class="dropdown-content">
                    @if (session()->has('user'))
                        <div class="dropdown-header">
                            <strong>{{ session('user')['name'] }}</strong>
                            <span>{{ session('user')['role'] ?? 'User' }}</span>
                        </div>
                        @if (isset(session('user')['role']) && session('user')['role'] === 'job_provider')
                            <a href="{{ url('/penyedia-jasa/' . session('user')['username']) }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Lihat Profil Saya
                            </a>
                        @endif

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
                        <a href="{{ url('/pengaturan-akun') }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                </path>
                            </svg>
                            Pengaturan Akun
                        </a>
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

    @if (session()->has('user'))
        <!-- NOTIFICATION MODAL -->
        <div id="notifModalOverlay" class="notif-modal-overlay" onclick="toggleNotifModal(false)">
            <div class="notif-modal" onclick="event.stopPropagation()">
                <div class="notif-modal-header">
                    <h3>Notifikasi</h3>
                    <button type="button" class="notif-close-btn" onclick="toggleNotifModal(false)">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="notif-modal-body">
                    @if (count($myNotifs) > 0)
                        @foreach ($myNotifs as $n)
                            <div class="notif-card {{ $n['is_read'] ? '' : 'unread' }}">
                                <div class="notif-card-icon">
                                    @if ($n['type'] === 'order')
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                            </path>
                                        </svg>
                                    @elseif($n['type'] === 'comment')
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5">
                                            <path
                                                d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                            </path>
                                        </svg>
                                    @else
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="notif-card-content">
                                    <span class="notif-card-title">{{ $n['title'] }}</span>
                                    <span class="notif-card-desc">{{ $n['message'] }}</span>
                                    <div class="notif-card-time">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        {{ $n['created_at'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="notif-empty">
                            <div class="notif-empty-icon">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                            </div>
                            <h4>Belum ada notifikasi</h4>
                            <p>Notifikasi tentang aktivitas akun Anda akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
                @if ($unreadCount > 0)
                    <div class="notif-modal-footer">
                        <button type="button" class="btn-mark-read" onclick="markAllRead(event)">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Tandai Semua Sudah Dibaca
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @stack('scripts')
    <script>
        function toggleUserDropdown(e) {
            if (e) e.stopPropagation();
            const dropdown = document.getElementById("userMenuDropdown");
            if (dropdown) dropdown.classList.toggle("show");
            // Tutup modal notif jika sedang buka
            toggleNotifModal(false);
        }

        function toggleNotifModal(show) {
            const overlay = document.getElementById("notifModalOverlay");
            if (!overlay) return;

            if (show) {
                overlay.style.display = 'flex';
                setTimeout(() => overlay.classList.add("show"), 10);
                document.body.style.overflow = "hidden";
            } else {
                overlay.classList.remove("show");
                setTimeout(() => {
                    overlay.style.display = 'none';
                    // Kembalikan scroll body jika tidak ada menu lain yang aktif
                    const mobileNav = document.getElementById("navWrapper");
                    if (!mobileNav || !mobileNav.classList.contains("active")) {
                        document.body.style.overflow = "";
                    }
                }, 300);
            }
        }

        function markAllRead(e) {
            if (e) e.stopPropagation();
            fetch("{{ url('/notifikasi/read') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    const badge = document.getElementById('notifBadge');
                    if (badge) badge.style.display = 'none';
                    document.querySelectorAll('.notif-card.unread').forEach(el => el.classList.remove('unread'));
                    const footer = document.querySelector('.notif-modal-footer');
                    if (footer) footer.style.display = 'none';

                    // Notifikasi mobile juga dihilangkan badgenya
                    const mobileBadge = document.querySelector('.mobile-nav-header-btn .badge');
                    if (mobileBadge) mobileBadge.style.display = 'none';
                }
            });
        }

        function toggleMobileNav() {
            const nav = document.getElementById("navWrapper");
            const btn = document.getElementById("hamburgerBtn");
            if (!nav || !btn) return;

            nav.classList.toggle("active");
            if (nav.classList.contains("active")) {
                document.body.style.overflow = "hidden";
            } else {
                document.body.style.overflow = "";
            }
        }

        // Handle click di luar menu/dropdown
        window.addEventListener('click', function(event) {
            // Dropdown Menu Profil
            if (!event.target.closest('.user-dropdown')) {
                const userDropdown = document.getElementById("userMenuDropdown");
                if (userDropdown) userDropdown.classList.remove('show');
            }

            // Mobile Navigation Toggle
            if (!event.target.closest('nav') && !event.target.closest('.mobile-menu-btn') && !event.target.closest(
                    '.mobile-close-btn-universal')) {
                const nav = document.getElementById("navWrapper");
                if (nav && nav.classList.contains("active")) {
                    nav.classList.remove("active");
                    // Jangan kembalikan overflow jika modal notif sedang buka
                    const notifOverlay = document.getElementById("notifModalOverlay");
                    if (!notifOverlay || !notifOverlay.classList.contains("show")) {
                        document.body.style.overflow = "";
                    }
                }
            }
        });
    </script>
</body>

</html>
