@extends('layouts.app')
@section('title', 'Masuk')

@push('styles')
    <style>
        .auth-page {
            min-height: calc(100dvh - var(--nav-height));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(1.5rem, 5vw, 3rem) 1rem;
            background: linear-gradient(160deg, #EFF6FF 0%, #F8FAFC 100%);
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
            background: #fff;
            padding: clamp(1.5rem, 5vw, 2.25rem);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.06), 0 0 0 1px rgba(0,0,0,0.04);
            border: 1px solid var(--border);
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
            min-height: 50px;
            padding: 0 1rem 0 2.75rem;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 0.95rem;
            background: #F8FAFC;
            color: var(--text-main);
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .form-control::placeholder { color: #A0AEC0; }

        .toggle-pass {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 0.25rem;
            border-radius: 6px;
            transition: color 0.2s;
        }
        .toggle-pass:hover { color: var(--primary); }

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

        /* Validation Styles */
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
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Yoanti
                </a>
                <p>Platform jasa digital profesional</p>
            </div>

            <div class="auth-card">
                <h1>Selamat datang!</h1>
                <p class="auth-subtitle">Masuk untuk melanjutkan ke akun Anda</p>

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

                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input type="text" id="username" name="username" class="form-control"
                                placeholder="Masukkan username" required autocomplete="username"
                                value="{{ old('username') }}">
                        </div>
                        <div id="error-username" class="error-message">Username wajib diisi</div>
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Masukkan kata sandi" required autocomplete="current-password">
                            <button type="button" class="toggle-pass" onclick="togglePassword()" id="togglePassBtn" aria-label="Tampilkan kata sandi">
                                <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <div id="error-password" class="error-message">Kata sandi wajib diisi</div>
                    </div>

                    <button type="submit" class="btn-primary btn-auth">
                        Masuk Sekarang
                    </button>
                </form>
            </div>

            <p class="auth-footer">
                Belum punya akun? <a href="{{ url('/register') }}">Daftar sekarang</a>
            </p>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>`;
            }
        }

        document.querySelector('form').onsubmit = function(e) {
            let hasError = false;
            const username = document.getElementById('username');
            const password = document.getElementById('password');

            // Reset
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid', 'shake'));

            if (!username.value.trim()) {
                showError(username, 'error-username');
                hasError = true;
            }
            if (!password.value.trim()) {
                showError(password, 'error-password');
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
                return false;
            }
        };

        function showError(input, errorId) {
            input.classList.add('is-invalid', 'shake');
            document.getElementById(errorId).style.display = 'block';
            setTimeout(() => input.classList.remove('shake'), 400);
        }
    </script>
@endpush
