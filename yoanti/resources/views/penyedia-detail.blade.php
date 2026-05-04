@extends('layouts.app')
@section('title', 'Profil Penyedia Jasa - ' . $provider['name'])

@push('styles')
    <style>
        :root {
            --primary: #4F46E5;
            --primary-light: #EEF2FF;
            --primary-dark: #3730A3;
            --wa-color: #25D366;
            --wa-hover: #1EBE5D;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --bg-body: #F8FAFC;
            --surface: #FFFFFF;
        }

        body {
            background-color: var(--bg-body);
        }

        .profile-page {
            padding: 2rem 1rem 4rem;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            transition: color 0.2s ease;
        }

        .btn-back:hover {
            color: var(--primary);
        }

        /* GRID LAYOUT UTAMA */
        .layout-wrapper {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(0, 1.1fr);
            gap: 2.5rem;
            align-items: start;
        }

        /* =======================================
                   KOLOM KIRI: PROFIL & PORTOFOLIO
                   ======================================= */
        .profile-card {
            background: var(--surface);
            border-radius: 20px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 2.5rem;
        }

        .profile-cover {
            height: 160px;
            background: linear-gradient(135deg, var(--primary), #3B82F6);
            position: relative;
        }

        .profile-cover::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.2) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.5;
        }

        .profile-content {
            padding: 0 2rem 2.5rem;
            position: relative;
        }

        .profile-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: -55px;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .profile-avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: var(--surface);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 800;
            border: 4px solid var(--surface);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        }

        .profile-name-wrap {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 0.5rem;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            letter-spacing: -0.02em;
        }

        .profile-rating {
            background: #FFFBEB;
            color: #D97706;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            border: 1px solid #FDE68A;
        }

        .profile-rating svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        .profile-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: 500;
        }

        .meta-item svg {
            color: var(--primary);
        }

        .profile-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .skill-badge {
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 0.3rem 0.8rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-wa {
            background: var(--wa-color);
            color: white;
            box-shadow: 0 4px 14px rgba(37, 211, 102, 0.25);
        }

        .btn-wa:hover {
            background: var(--wa-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.35);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25);
            width: 100%;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.35);
        }

        .section-header {
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-header h2 {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }

        .section-header .line {
            flex: 1;
            height: 2px;
            background: #E2E8F0;
            border-radius: 2px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .product-card {
            background: var(--surface);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1);
        }

        .product-img-box {
            position: relative;
            padding-top: 60%;
            background: var(--bg-body);
            overflow: hidden;
        }

        .product-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .badge-type {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background: rgba(255, 255, 255, 0.95);
            color: var(--primary);
            padding: 0.3rem 0.6rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 800;
            backdrop-filter: blur(4px);
        }

        .product-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.4rem;
        }

        .product-price {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.75rem;
        }

        .product-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        /* =======================================
                   KOLOM KANAN: CHAT PANEL (FIXED/STICKY)
                   ======================================= */
        .chat-panel {
            position: sticky;
            top: 2rem;
            height: calc(100vh - 4rem);
            background: var(--surface);
            border-radius: 20px;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08);
            border: 1px solid #E2E8F0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            padding: 1.25rem 1.5rem;
            background: var(--surface);
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 10;
        }

        .chat-header h2 {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }

        .chat-header .badge {
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 800;
        }

        .chat-body {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            background: #F8FAFC;
            padding-bottom: 4rem;
            /* Extra padding agar dropdown terbawah tidak terpotong */
            scroll-behavior: smooth;
            scrollbar-width: thin;
            scrollbar-color: #CBD5E1 transparent;
        }

        .chat-body::-webkit-scrollbar {
            width: 6px;
        }

        .chat-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }

        .chat-body::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }

        .comment-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .comment-item:last-child {
            margin-bottom: 0;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #E2E8F0;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .comment-content {
            flex: 1;
            background: var(--surface);
            padding: 1rem 1.25rem;
            border-radius: 0 16px 16px 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .comment-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .comment-meta {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 0.3rem;
        }

        .comment-author {
            font-weight: 800;
            color: var(--text-main);
            font-size: 0.9rem;
        }

        .comment-date {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .comment-text {
            font-size: 0.9rem;
            color: #334155;
            line-height: 1.5;
            word-break: break-word;
        }

        /* Dropdown Titik 3 */
        .dropdown-wrapper {
            position: relative;
        }

        .btn-kebab {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 0.2rem;
            cursor: pointer;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-kebab:hover {
            background: #F1F5F9;
            color: var(--text-main);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: var(--surface);
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            min-width: 140px;
            z-index: 20;
            overflow: hidden;
            animation: dropdownFade 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top right;
        }

        .dropdown-menu.show {
            display: block;
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-5px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            width: 100%;
            padding: 0.75rem 1rem;
            border: none;
            background: none;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
            text-align: left;
            cursor: pointer;
            transition: background 0.2s;
        }

        .dropdown-item:hover {
            background: #F8FAFC;
            color: var(--primary);
        }

        .dropdown-item.text-danger {
            color: #DC2626;
        }

        .dropdown-item.text-danger:hover {
            background: #FEF2F2;
            color: #B91C1C;
        }

        /* Balasan Klien */
        .reply-box {
            margin-top: 1rem;
            padding: 1rem;
            background: var(--primary-light);
            border-radius: 12px;
            border: 1px solid #C7D2FE;
        }

        .reply-author-wrap {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.4rem;
        }

        .badge-pro {
            background: var(--primary);
            color: white;
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            font-size: 0.6rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .btn-reply-toggle {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            padding: 0;
            margin-top: 0.75rem;
            transition: color 0.2s;
        }

        .btn-reply-toggle:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .reply-form {
            display: none;
            margin-top: 1rem;
            animation: slideDown 0.3s ease;
        }

        .reply-form.active {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Area Input Fixed (Bawah) */
        .chat-footer {
            padding: 1rem 1.25rem;
            background: var(--surface);
            border-top: 1px solid #E2E8F0;
            z-index: 10;
        }

        .chat-input-form {
            display: flex;
            align-items: flex-end;
            gap: 0.75rem;
            margin: 0;
        }

        .chat-textarea {
            flex: 1;
            min-height: 48px;
            max-height: 120px;
            border-radius: 24px;
            padding: 0.8rem 1.25rem;
            border: 1px solid #CBD5E1;
            background: #F8FAFC;
            font-family: inherit;
            font-size: 0.95rem;
            resize: vertical;
            transition: all 0.2s;
            line-height: 1.4;
        }

        .chat-textarea:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--surface);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .chat-send-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        }

        .chat-send-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.4);
        }

        .chat-send-btn svg {
            margin-left: -2px;
            margin-top: 2px;
        }

        /* =======================================
                   MODAL EDIT (UX/UI MODERN)
                   ======================================= */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: var(--surface);
            width: 90%;
            max-width: 500px;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: translateY(20px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-overlay.active .modal-content {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }

        .btn-close-modal {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .btn-close-modal:hover {
            background: #F1F5F9;
            color: #EF4444;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .layout-wrapper {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .chat-panel {
                position: relative;
                top: 0;
                height: 600px;
                max-height: 80vh;
            }
        }

        @media (max-width: 640px) {
            .profile-header-top {
                flex-direction: column;
                align-items: center;
                text-align: center;
                margin-top: -60px;
            }

            .profile-name-wrap,
            .profile-meta,
            .profile-skills {
                justify-content: center;
            }

            .profile-actions {
                width: 100%;
                margin-top: 1.25rem;
            }

            .btn-wa {
                width: 100%;
            }

            .chat-textarea {
                border-radius: 16px;
            }
        }
        .btn-review-link:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        /* Modal Ulasan */
        .reviews-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reviews-modal.active {
            display: flex;
            animation: fadeIn 0.3s ease-out;
        }

        .reviews-modal-content {
            background: #fff;
            width: 100%;
            max-width: 600px;
            max-height: 80vh;
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .reviews-modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #F1F5F9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #F8FAFC;
        }

        .reviews-modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .btn-close-modal {
            background: #fff;
            border: 1px solid #E2E8F0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #64748B;
            transition: all 0.2s;
        }

        .btn-close-modal:hover {
            background: #F1F5F9;
            color: var(--primary);
            transform: rotate(90deg);
        }

        .reviews-modal-body {
            padding: 1.5rem 2rem;
            overflow-y: auto;
            flex: 1;
        }
    </style>
@endpush

@section('content')
    <div class="profile-page">
        <div class="container">

            <a href="{{ url('/penyedia-jasa') }}" class="btn-back">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Kembali ke Direktori
            </a>

            <div class="layout-wrapper">

                <!-- KOLOM KIRI (Profil & Portofolio) -->
                <div class="main-content">
                    <div class="profile-card">
                        <div class="profile-cover" 
                            style="{{ isset($provider['cover_photo']) && $provider['cover_photo'] ? 'background-image: url(' . asset($provider['cover_photo']) . '); background-size: cover; background-position: center;' : '' }}">
                        </div>
                        <div class="profile-content">
                            <div class="profile-header-top">
                                <div class="profile-avatar" style="overflow: hidden; display: flex; align-items: center; justify-content: center; background: #F1F5F9; color: var(--primary);">
                                    @if(isset($provider['avatar']) && $provider['avatar'])
                                        <img src="{{ asset($provider['avatar']) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        {{ strtoupper(substr($provider['name'], 0, 1)) }}
                                    @endif
                                </div>
                                <div class="profile-actions">
                                    @php
                                        $phone = preg_replace('/[^0-9]/', '', $provider['phone_number'] ?? '');
                                        $waLink = $phone
                                            ? 'https://wa.me/' .
                                                $phone .
                                                '?text=' .
                                                urlencode('Halo ' . $provider['name'] . ', saya melihat profil Anda.')
                                            : '#';
                                    @endphp
                                    <a href="{{ $waLink }}" class="btn btn-wa"
                                        @if (!$phone) onclick="alert('Nomor tidak tersedia.'); return false;" @else target="_blank" @endif>
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                            </path>
                                        </svg>
                                        Hubungi WhatsApp
                                    </a>
                                </div>
                            </div>

                            <div class="profile-info">
                                <div class="profile-name-wrap">
                                    <h1 class="profile-name">{{ $provider['name'] }}</h1>
                                    @if (isset($provider['average_rating']) && $provider['average_rating'] > 0)
                                        <div class="profile-rating">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"
                                                style="color: #F59E0B;">
                                                <path
                                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                                                </path>
                                            </svg>
                                            <span>{{ $provider['average_rating'] }} ({{ $provider['review_count'] }})</span>
                                        </div>
                                    @endif
                                    <div class="profile-sales" style="display: flex; align-items: center; gap: 0.4rem; background: #ECFDF5; color: #059669; padding: 0.35rem 0.75rem; border-radius: 999px; font-size: 0.85rem; font-weight: 700; border: 1px solid #A7F3D0;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                            <path d="M3 6h18"></path>
                                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                                        </svg>
                                        {{ $salesCount }} Terjual
                                    </div>
                                </div>
                                <div class="profile-meta">
                                    <div class="meta-item">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        {{ $provider['profession'] ?? 'Penyedia Jasa' }}
                                    </div>
                                    @if (!empty($provider['workplace']))
                                        <div class="meta-item">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                            {{ $provider['workplace'] }}
                                        </div>
                                    @endif
                                </div>
                                @if (!empty($provider['skills']) && $provider['skills'] !== '-')
                                    <div class="profile-skills">
                                        @foreach (explode(',', $provider['skills']) as $skill)
                                            <span class="skill-badge">{{ trim($skill) }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="section-header">
                        <h2>Layanan & Portofolio</h2>
                        <div class="line"></div>
                    </div>

                    <div class="product-grid">
                        @forelse($providerProducts as $product)
                            <div class="product-card">
                                <div class="product-img-box">
                                    <span class="badge-type">{{ $product['type'] ?? 'Layanan' }}</span>
                                    <img src="{{ asset($product['image']) }}" alt="{{ $product['title'] }}" class="product-img"
                                        onerror="this.src='https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=500&q=80'">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-title">{{ Str::limit($product['title'], 40) }}</h3>
                                    <div class="product-price">{{ $product['price'] ?? 'Hubungi untuk harga' }}</div>
                                    <p class="product-desc">{{ $product['description'] ?? '' }}</p>
                                    @if(session()->has('user') && session('user')['role'] === 'job_seeker')
                                        <form action="{{ url('/produk/beli') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                            <input type="hidden" name="product_title" value="{{ $product['title'] }}">
                                            <input type="hidden" name="product_price" value="{{ $product['price'] }}">
                                            <input type="hidden" name="provider_username" value="{{ $provider['username'] }}">
                                            <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 0.5rem;">Pesan Layanan</button>
                                        </form>
                                    @elseif(!session()->has('user'))
                                        <a href="{{ url('/login') }}" class="btn btn-primary" style="display: block; text-align: center; margin-bottom: 0.5rem;">Login untuk Pesan</a>
                                    @else
                                        <button class="btn btn-primary" style="width: 100%; margin-bottom: 0.5rem; opacity: 0.5; cursor: not-allowed;" disabled>Pesan Layanan</button>
                                    @endif
                                    
                                    <button type="button" onclick="openReviewsModal('{{ $product['id'] }}', '{{ $product['title'] }}')" class="btn-review-link" style="width: 100%; border: 1px solid var(--primary); background: transparent; color: var(--primary); font-size: 0.85rem; font-weight: 600; padding: 0.4rem; border-radius: 8px; transition: all 0.2s; cursor: pointer; display: block; text-align: center;">Lihat Ulasan</button>
                                </div>
                            </div>
                        @empty
                            <div
                                style="grid-column: 1/-1; padding: 3rem; text-align: center; background: #fff; border-radius: 16px; border: 2px dashed #E2E8F0; color: #64748B;">
                                Belum ada portofolio atau layanan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- KOLOM KANAN (Chat Panel Fixed/Sticky) -->
                <div class="chat-panel" id="ulasan">

                    <!-- Header Chat -->
                    <div class="chat-header">
                        <h2>Komentar Akun</h2>
                        <span class="badge">{{ count($providerComments) }}</span>
                    </div>

                    <!-- Area Tengah (Scrollable) -->
                    <div class="chat-body" id="chatBody">
                        @if (session('success') || session('error'))
                            <div
                                style="padding: 0.8rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.85rem; {{ session('success') ? 'background: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0;' : 'background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA;' }}">
                                {{ session('success') ?? session('error') }}
                            </div>
                        @endif

                        @forelse($providerComments as $comment)
                            <div class="comment-item">
                                <div class="user-avatar" style="overflow: hidden; display: flex; align-items: center; justify-content: center; background: #F1F5F9; color: var(--primary);">
                                    @php
                                        $currentAvatar = $userAvatars[$comment['user_username']] ?? ($comment['user_avatar'] ?? null);
                                    @endphp
                                    @if($currentAvatar)
                                        <img src="{{ asset($currentAvatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        {{ strtoupper(substr($comment['user_name'], 0, 1)) }}
                                    @endif
                                </div>
                                <div class="comment-content">

                                    <div class="comment-header-row">
                                        <div class="comment-meta">
                                            <span class="comment-author">{{ $comment['user_name'] }}</span>
                                            <span
                                                class="comment-date">{{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}</span>
                                        </div>

                                        @if (session()->has('user') &&
                                                (session('user')['username'] === $comment['user_username'] || session('user')['role'] === 'superadmin'))
                                            <div class="dropdown-wrapper">
                                                <button type="button" class="btn-kebab" onclick="toggleDropdown(this)">
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <circle cx="12" cy="12" r="1.5"></circle>
                                                        <circle cx="12" cy="5" r="1.5"></circle>
                                                        <circle cx="12" cy="19" r="1.5"></circle>
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if (session('user')['username'] === $comment['user_username'])
                                                        <button type="button" class="dropdown-item"
                                                            onclick="openEditModal('{{ $comment['id'] }}', `{{ addslashes($comment['comment']) }}`)">
                                                            <svg width="16" height="16" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path
                                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                </path>
                                                                <path
                                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                </path>
                                                            </svg>
                                                            Edit
                                                        </button>
                                                    @endif
                                                    <form action="{{ url('/penyedia-jasa/komentar/delete') }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus ulasan ini?');"
                                                        style="margin: 0;">
                                                        @csrf
                                                        <input type="hidden" name="comment_id"
                                                            value="{{ $comment['id'] }}">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <svg width="16" height="16" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path
                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                </path>
                                                                <line x1="10" y1="11" x2="10"
                                                                    y2="17"></line>
                                                                <line x1="14" y1="11" x2="14"
                                                                    y2="17"></line>
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="comment-text">{{ nl2br(htmlspecialchars($comment['comment'])) }}</div>

                                    @if (session()->has('user') && session('user')['username'] === $provider['username'])
                                        <button type="button" class="btn-reply-toggle"
                                            onclick="toggleReply('{{ $comment['id'] }}')">
                                            Balas Klien
                                        </button>
                                        <div id="reply-container-{{ $comment['id'] }}" style="display: none; gap: 0.75rem; align-items: flex-start; margin-top: 1rem;">
                                            <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.8rem; flex-shrink: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #F1F5F9; color: var(--primary);">
                                                @if(isset(session('user')['avatar']) && session('user')['avatar'])
                                                    <img src="{{ asset(session('user')['avatar']) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    {{ strtoupper(substr(session('user')['name'], 0, 1)) }}
                                                @endif
                                            </div>
                                            <form id="reply-{{ $comment['id'] }}" class="reply-form" style="flex: 1;"
                                                action="{{ url('/penyedia-jasa/komentar/reply') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="comment_id" value="{{ $comment['id'] }}">
                                                <textarea name="reply_comment" class="chat-textarea" style="width: 100%; border-radius: 12px; margin-bottom: 0.5rem;"
                                                    placeholder="Ketik balasan Anda..." required></textarea>
                                                <div style="text-align: right;">
                                                    <button type="submit" class="btn btn-primary"
                                                        style="padding: 0.5rem 1rem; font-size: 0.8rem; width: auto;">Kirim
                                                        Balasan</button>
                                                </div>
                                            </form>
                                        </div>
                                        <script>
                                            function toggleReply(id) {
                                                const container = document.getElementById('reply-container-' + id);
                                                container.style.display = container.style.display === 'none' ? 'flex' : 'none';
                                            }
                                        </script>
                                    @endif

                                    @if (isset($comment['replies']) && count($comment['replies']) > 0)
                                        @foreach ($comment['replies'] as $reply)
                                            <div class="reply-box">
                                                <div style="display: flex; gap: 0.75rem; align-items: flex-start; margin-bottom: 0.5rem;">
                                                    <div class="user-avatar" style="width: 28px; height: 28px; font-size: 0.75rem; flex-shrink: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #F1F5F9; color: var(--primary);">
                                                        @php
                                                            $replyAvatar = $userAvatars[$reply['username']] ?? ($reply['avatar'] ?? null);
                                                        @endphp
                                                        @if($replyAvatar)
                                                            <img src="{{ asset($replyAvatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                                        @else
                                                            {{ strtoupper(substr($reply['name'], 0, 1)) }}
                                                        @endif
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <div class="reply-author-wrap" style="margin-bottom: 0.2rem;">
                                                            <div style="display: flex; align-items: center; gap: 0.5rem; flex: 1;">
                                                                <span class="comment-author"
                                                                    style="color: var(--primary);">{{ $reply['name'] }}</span>
                                                                <span class="badge-pro">Penyedia</span>
                                                            </div>

                                                            @if (session()->has('user') &&
                                                                    (session('user')['username'] === $reply['username'] || session('user')['role'] === 'superadmin'))
                                                                <div class="dropdown-wrapper">
                                                                    <button type="button" class="btn-kebab"
                                                                        onclick="toggleDropdown(this)">
                                                                        <svg width="16" height="16" viewBox="0 0 24 24"
                                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round">
                                                                            <circle cx="12" cy="12" r="1.5">
                                                                            </circle>
                                                                            <circle cx="12" cy="5" r="1.5">
                                                                            </circle>
                                                                            <circle cx="12" cy="19" r="1.5">
                                                                            </circle>
                                                                        </svg>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        @if (session('user')['username'] === $reply['username'])
                                                                            <button type="button" class="dropdown-item"
                                                                                onclick="openEditModal('{{ $reply['id'] }}', `{{ addslashes($reply['comment']) }}`)">
                                                                                <svg width="14" height="14"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                    <path
                                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                                    </path>
                                                                                    <path
                                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                                    </path>
                                                                                </svg>
                                                                                Edit
                                                                            </button>
                                                                        @endif
                                                                        <form action="{{ url('/penyedia-jasa/komentar/delete') }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Hapus balasan ini?')"
                                                                            style="margin:0;">
                                                                            @csrf
                                                                            <input type="hidden" name="comment_id"
                                                                                value="{{ $reply['id'] }}">
                                                                            <button type="submit"
                                                                                class="dropdown-item text-danger">
                                                                                <svg width="14" height="14"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                                    <path
                                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                                    </path>
                                                                                    <line x1="10" y1="11"
                                                                                        x2="10" y2="17"></line>
                                                                                    <line x1="14" y1="11"
                                                                                        x2="14" y2="17"></line>
                                                                                </svg>
                                                                                Hapus
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="comment-text" style="font-size: 0.85rem;">
                                                            {{ nl2br(htmlspecialchars($reply['comment'])) }}</div>
                                                        <div class="comment-date" style="margin-top: 0.4rem;">
                                                            {{ \Carbon\Carbon::parse($reply['created_at'])->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div
                                style="height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--text-muted); opacity: 0.6;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" style="margin-bottom: 1rem;">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <p style="font-size: 0.95rem; text-align: center;">Belum ada obrolan atau
                                    ulasan.<br>Jadilah yang pertama!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Area Input (Fixed di Bawah) -->
                    @if (session()->has('user') && session('user')['role'] === 'job_seeker')
                        <div class="chat-footer">
                            <div style="display: flex; gap: 0.75rem; align-items: center; width: 100%;">
                                <div class="user-avatar" style="width: 40px; height: 40px; flex-shrink: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #F1F5F9; color: var(--primary);">
                                    @if(isset(session('user')['avatar']) && session('user')['avatar'])
                                        <img src="{{ asset(session('user')['avatar']) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        {{ strtoupper(substr(session('user')['name'], 0, 1)) }}
                                    @endif
                                </div>
                                <form action="{{ url('/penyedia-jasa/komentar') }}" method="POST" class="chat-input-form" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="provider_username" value="{{ $provider['username'] }}">
                                    <textarea name="comment" class="chat-textarea" rows="1" placeholder="Ketik ulasan Anda..." required></textarea>
                                    <button type="submit" class="chat-send-btn" title="Kirim Ulasan">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <line x1="22" y1="2" x2="11" y2="13"></line>
                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Jika belum login atau bukan job_seeker -->
                        <div class="chat-footer" style="text-align: center; padding: 1.5rem;">
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Silakan login sebagai
                                Pencari Jasa untuk memberikan ulasan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ==========================================
                 MODAL EDIT COMMENT (DENGAN CSS BARU)
                 ========================================== -->
    <div id="modalEdit" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Ulasan</h3>
                <button type="button" class="btn-close-modal" onclick="closeEditModal()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form action="{{ url('/penyedia-jasa/komentar/update') }}" method="POST">
                @csrf
                <input type="hidden" name="comment_id" id="edit_comment_id">
                <textarea name="comment" id="edit_comment_text" class="chat-textarea"
                    style="width: 100%; min-height: 120px; border-radius: 16px; margin-bottom: 1.5rem;" required></textarea>
                <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                    <button type="button" class="btn" style="background: #F1F5F9; color: #475569;"
                        onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn btn-primary" style="width: auto; padding: 0.75rem 1.5rem;">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Ulasan Produk -->
    <div id="reviewsModal" class="reviews-modal">
        <div class="reviews-modal-content">
            <div class="reviews-modal-header">
                <div>
                    <h3 id="modalProductTitle">Ulasan Produk</h3>
                    <p style="font-size: 0.8rem; color: #64748B; margin: 0.2rem 0 0 0;">Daftar testimoni untuk layanan ini</p>
                </div>
                <button type="button" class="btn-close-modal" onclick="closeReviewsModal()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="reviews-modal-body" id="modalReviewsBody">
                <!-- Content populated by JS -->
            </div>
        </div>
    </div>

    <!-- Script untuk Interaksi UI -->
    <script>
        // Data ulasan produk untuk JS
        const productReviews = @json($productReviews);
        const userAvatars = @json($userAvatars);

        function openReviewsModal(productId, productTitle) {
            const modal = document.getElementById('reviewsModal');
            const body = document.getElementById('modalReviewsBody');
            const title = document.getElementById('modalProductTitle');
            
            title.innerText = 'Ulasan: ' + productTitle;
            body.innerHTML = '';

            const filteredReviews = productReviews.filter(r => r.product_id === productId);

            if (filteredReviews.length === 0) {
                body.innerHTML = `<div style="text-align: center; padding: 3rem 1rem; color: #94A3B8;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem; opacity: 0.5;">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.3 8.38 8.38 0 0 1 3.8.9L21 3z"></path>
                    </svg>
                    <p>Belum ada ulasan untuk layanan ini.</p>
                </div>`;
            } else {
                filteredReviews.forEach(review => {
                    const avatarPath = userAvatars[review.user_username] || review.user_avatar;
                    const stars = Array.from({length: 5}, (_, i) => {
                        const fill = (i + 1) <= review.rating ? '#F59E0B' : '#E2E8F0';
                        return `<svg width="14" height="14" viewBox="0 0 24 24" fill="${fill}"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>`;
                    }).join('');

                    body.innerHTML += `
                        <div class="comment-item" style="margin-bottom: 1.5rem; border-bottom: 1px solid #F1F5F9; padding-bottom: 1rem;">
                            <div style="display: flex; gap: 1rem; align-items: flex-start;">
                                <div class="user-avatar" style="width: 40px; height: 40px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #F1F5F9; color: var(--primary); flex-shrink: 0; border-radius: 50%;">
                                    ${avatarPath ? `<img src="/${avatarPath}" style="width: 100%; height: 100%; object-fit: cover;">` : review.user_name.charAt(0).toUpperCase()}
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.2rem;">
                                        <span style="font-weight: 700; color: var(--text-main);">${review.user_name}</span>
                                        <span style="font-size: 0.75rem; color: #94A3B8;">${review.created_at}</span>
                                    </div>
                                    <div style="display: flex; gap: 2px; margin-bottom: 0.5rem;">${stars}</div>
                                    <div style="font-size: 0.9rem; color: #475569; line-height: 1.5;">${review.comment}</div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeReviewsModal() {
            document.getElementById('reviewsModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        // Toggle menu dropdown titik tiga
        function toggleDropdown(btn) {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                if (menu !== btn.nextElementSibling) {
                    menu.classList.remove('show');
                }
            });
            btn.nextElementSibling.classList.toggle('show');
        }

        // Menutup dropdown jika user klik di luar area menu
        window.onclick = function(event) {
            if (!event.target.matches('.btn-kebab') && !event.target.closest('.btn-kebab')) {
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    menu.classList.remove('show');
                });
            }
        }

        // Logika membuka modal Edit dengan CSS yang baru
        function openEditModal(id, text) {
            document.getElementById('edit_comment_id').value = id;
            document.getElementById('edit_comment_text').value = text;

            // Tampilkan modal
            document.getElementById('modalEdit').classList.add('active');

            // Tutup semua menu dropdown yang sedang terbuka
            document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.remove('show'));
        }

        function closeEditModal() {
            document.getElementById('modalEdit').classList.remove('active');
        }

        // Auto-scroll obrolan ke paling bawah saat halaman di muat agar ulasan terbaru (jika di bawah) langsung terlihat
        window.onload = function() {
            var chatBody = document.getElementById("chatBody");
            if (chatBody) {
                chatBody.scrollTop = chatBody.scrollHeight;
            }
        };
    </script>
@endsection
