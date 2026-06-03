@extends('layouts.app')
@section('title', 'Lupa Password')

@push('styles')
    <style>
        .auth-page {
            min-height: calc(100dvh - var(--nav-height));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(1.5rem, 5vw, 3rem) 1rem;
            background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.1), transparent 40%),
                        radial-gradient(circle at bottom left, rgba(79, 70, 229, 0.1), transparent 40%),
                        var(--bg);
        }

        .auth-wrapper {
            width: 100%;
            max-width: 440px;
        }

        .auth-logo-area {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo-area .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .auth-logo-area .brand svg { color: var(--primary); }

        .auth-logo-area p {
            margin-top: 0.5rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            padding: clamp(2rem, 5vw, 3rem);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.04), 0 1px 3px rgba(0,0,0,0.02);
            border: 1px solid rgba(255,255,255,0.6);
        }

        .auth-card h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.35rem;
            letter-spacing: -0.02em;
        }

        .auth-card .auth-subtitle {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 1.75rem;
        }

        .form-group {
            margin-bottom: 1.1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.45rem;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-main);
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            min-height: 52px;
            padding: 0 1rem 0 2.75rem;
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 14px;
            font-size: 0.95rem;
            background: rgba(255, 255, 255, 0.7);
            color: var(--text-main);
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .form-control::placeholder { color: #A0AEC0; }

        .alert-error {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-auth {
            width: 100%;
            min-height: 52px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 1.25rem;
            letter-spacing: -0.01em;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer a:hover { text-decoration: underline; }

        @media (max-width: 480px) {
            .auth-page { padding: 1rem 0.75rem; }
            .auth-card { padding: 1.25rem; border-radius: 16px; border: 1.5px solid var(--border); background: #fff; }
            .form-control { min-height: 44px; font-size: 16px; }
            .btn-auth { min-height: 48px; font-size: 0.95rem; }
        }

        .error-message {
            color: #DC2626;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.25rem;
            display: none;
            animation: fadeIn 0.2s ease;
        }

        .form-control.is-invalid {
            border-color: #DC2626 !important;
            background-color: #FEF2F2;
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
    </style>
@endpush

@section('content')
    <section class="auth-page">
        <div class="auth-wrapper">
            <div class="auth-logo-area">
                <a href="{{ url('/') }}" class="brand">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Yoanti
                </a>
            </div>

            <div class="auth-card">
                <h1>Lupa Password</h1>
                <p class="auth-subtitle">Masukkan data Anda untuk membuat password baru.</p>

                @if (session('error'))
                    <div class="alert-error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ url('/lupa-password') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input type="text" id="username" name="username" class="form-control"
                                placeholder="Masukkan username" required value="{{ old('username') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Masukkan nama" required value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Nomor Telepon</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <input type="text" id="phone_number" name="phone_number" class="form-control"
                                placeholder="Masukkan nomor telepon" required value="{{ old('phone_number') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input type="password" id="new_password" name="new_password" class="form-control"
                                placeholder="Masukkan password baru" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary btn-auth">
                        Ubah Password
                    </button>
                </form>
            </div>

            <p class="auth-footer">
                Ingat password? <a href="{{ url('/login') }}">Kembali ke Login</a>
            </p>
        </div>
    </section>
@endsection
