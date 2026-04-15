@extends('layouts.app')
@section('title', 'Super Admin - Dashboard')

@push('styles')
    <style>
        .sa-page {
            padding: clamp(1.5rem, 4vw, 3rem) clamp(1rem, 5%, 2rem);
            background: var(--bg);
            min-height: calc(100dvh - var(--nav-height));
        }

        .sa-page-header {
            margin-bottom: clamp(1.5rem, 4vw, 2.5rem);
        }

        .sa-welcome {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .sa-page-header h1 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 20px;
            padding: clamp(1.25rem, 4vw, 2rem);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.5rem;
        }

        .stat-icon.blue   { background: #EFF6FF; color: #2563EB; }
        .stat-icon.green  { background: #ECFDF5; color: #10B981; }
        .stat-icon.purple { background: #F5F3FF; color: #7C3AED; }

        .stat-info h2 {
            font-size: clamp(2rem, 5vw, 2.75rem);
            font-weight: 900;
            color: var(--text-main);
            letter-spacing: -0.02em;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-info p {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Quick Links */
        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 200px), 1fr));
            gap: 1rem;
        }

        .quick-link-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.25rem;
            border: 1.5px solid var(--border);
            text-decoration: none;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: var(--transition);
        }

        .quick-link-card:hover {
            border-color: var(--primary);
            background: #F8FAFF;
            transform: translateX(4px);
        }

        .ql-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ql-text h3 { font-size: 0.9rem; font-weight: 700; }
        .ql-text p  { font-size: 0.75rem; color: var(--text-muted); margin-top: 0.1rem; }

        .section-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        @media (max-width: 480px) {
            .stat-card { flex-direction: row; }
        }
    </style>
@endpush

@section('content')
    <div class="sa-page">
        <div class="sa-page-header">
            <p class="sa-welcome">Selamat datang,
                <strong>{{ session('user')['name'] ?? 'Super Admin' }}</strong>
            </p>
            <h1>Overview Dashboard</h1>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h2>{{ count($users) }}</h2>
                    <p>Total Pengguna</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                        <path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h2>{{ count($orders) }}</h2>
                    <p>Total Pesanan</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    @php
                        $totalComments = count($comments);
                        foreach ($comments as $c) { $totalComments += count($c['replies'] ?? []); }
                    @endphp
                    <h2>{{ $totalComments }}</h2>
                    <p>Total Komentar</p>
                </div>
            </div>
        </div>

        <p class="section-label">Navigasi Cepat</p>
        <div class="quick-links-grid">
            <a href="{{ url('/superadmin/user') }}" class="quick-link-card">
                <div class="ql-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="ql-text">
                    <h3>Kelola Pengguna</h3>
                    <p>{{ count($users) }} akun terdaftar</p>
                </div>
            </a>
            <a href="{{ url('/superadmin/pesanan') }}" class="quick-link-card">
                <div class="ql-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </div>
                <div class="ql-text">
                    <h3>Kelola Pesanan</h3>
                    <p>{{ count($orders) }} riwayat pesanan</p>
                </div>
            </a>
            <a href="{{ url('/superadmin/komentar') }}" class="quick-link-card">
                <div class="ql-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="ql-text">
                    <h3>Moderasi Komentar</h3>
                    <p>{{ $totalComments }} komentar & balasan</p>
                </div>
            </a>
        </div>
    </div>
@endsection
