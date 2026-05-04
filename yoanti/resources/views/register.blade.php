@extends('layouts.app')
@section('title', 'Buat Akun')

@push('styles')
    <style>
        .auth-page {
            min-height: calc(100dvh - var(--nav-height));
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: clamp(1.5rem, 4vw, 2.5rem) 1rem;
            background: linear-gradient(160deg, #EFF6FF 0%, #F8FAFC 100%);
        }

        .auth-wrapper {
            width: 100%;
            max-width: 520px;
        }

        .auth-logo-area {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .auth-logo-area .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .auth-logo-area .brand svg {
            color: var(--primary);
        }

        .auth-card {
            background: #fff;
            padding: clamp(1.5rem, 5vw, 2.25rem);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--border);
        }

        /* Step Indicator */
        .step-indicator {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.35rem;
            flex: 1;
            position: relative;
        }

        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 16px;
            left: calc(50% + 16px);
            right: calc(-50% + 16px);
            height: 2px;
            background: var(--border);
            z-index: 0;
            transition: background 0.3s;
        }

        .step-item.completed:not(:last-child)::after {
            background: var(--primary);
        }

        .step-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #F1F5F9;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            z-index: 1;
            color: var(--text-muted);
            transition: all 0.3s;
        }

        .step-dot.active {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        .step-dot.completed {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
        }

        .step-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
            text-align: center;
        }

        .step-label.active {
            color: var(--primary);
        }

        /* Form */
        .form-step {
            display: none;
            animation: stepIn 0.3s ease;
        }

        .form-step.active {
            display: block;
        }

        @keyframes stepIn {
            from {
                opacity: 0;
                transform: translateX(12px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .step-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.25rem;
            letter-spacing: -0.02em;
        }

        .step-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            font-size: 0.84rem;
            color: var(--text-main);
        }

        .form-control {
            width: 100%;
            min-height: 48px;
            padding: 0.7rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-size: 0.9rem;
            background: #F8FAFC;
            color: var(--text-main);
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Role Cards */
        .role-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .role-card {
            border: 2px solid var(--border);
            border-radius: 14px;
            padding: 1.1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #F8FAFC;
        }

        .role-card:active {
            transform: scale(0.98);
        }

        .role-card.selected {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }

        .role-card.selected .role-icon {
            color: var(--primary);
        }

        .role-card.selected .role-name {
            color: var(--primary);
        }

        .role-icon {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .role-name {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--text-main);
        }

        .role-desc {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.2rem;
        }

        /* Alert */
        .alert-error {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        /* Checkbox */
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-top: 1rem;
            padding: 1rem;
            background: #F8FAFC;
            border: 1.5px solid var(--border);
            border-radius: 12px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 0.1rem;
            accent-color: var(--primary);
            flex-shrink: 0;
        }

        .checkbox-group label {
            font-size: 0.83rem;
            line-height: 1.5;
            color: var(--text-muted);
        }

        .checkbox-group label a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        /* Buttons */
        .step-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .btn-back {
            min-height: 48px;
            border-radius: 12px;
            font-weight: 600;
            flex: 0 0 auto;
            background: white;
            color: var(--text-main);
            border: 1.5px solid var(--border);
            cursor: pointer;
            padding: 0 1.25rem;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
        }

        .btn-back:hover {
            background: #F1F5F9;
            border-color: #CBD5E1;
        }

        .btn-next {
            min-height: 48px;
            border-radius: 12px;
            font-weight: 700;
            flex: 1;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            color: white;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.25rem;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        @media (max-width: 480px) {
            .auth-page {
                padding: 1rem 0.75rem;
            }

            .auth-card {
                padding: 1.25rem;
                border-radius: 16px;
            }

            .step-indicator {
                margin-bottom: 1.5rem;
            }

            .step-dot {
                width: 28px;
                height: 28px;
                font-size: 0.75rem;
            }

            .step-label {
                font-size: 0.65rem;
            }

            .step-title {
                font-size: 1.1rem;
            }

            .step-desc {
                font-size: 0.8rem;
                margin-bottom: 1.25rem;
            }

            .role-icon {
                font-size: 1.5rem;
            }

            .role-name {
                font-size: 0.8rem;
            }

            .form-control {
                min-height: 44px;
                font-size: 16px;
                padding: 0.6rem 0.9rem;
            }

            .btn-next,
            .btn-back {
                min-height: 44px;
                font-size: 0.9rem;
            }

            .role-card {
                padding: 0.85rem;
            }
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
    </style>
@endpush

@section('content')
    <div class="auth-page">
        <div class="auth-wrapper">
            <div class="auth-logo-area">
                <a href="{{ url('/') }}" class="brand">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Yoanti
                </a>
            </div>

            <div class="auth-card">
                <div class="step-indicator" id="stepIndicator">
                    <div class="step-item active" id="step-item-1">
                        <div class="step-dot active" id="dot-1">1</div>
                        <span class="step-label active">Akun</span>
                    </div>
                    <div class="step-item" id="step-item-2">
                        <div class="step-dot" id="dot-2">2</div>
                        <span class="step-label">Profil</span>
                    </div>
                    <div class="step-item" id="step-item-3">
                        <div class="step-dot" id="dot-3">3</div>
                        <span class="step-label">Persetujuan</span>
                    </div>
                </div>

                @if (session('error'))
                    <div class="alert-error">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <form id="registerForm" action="{{ url('/register') }}" method="POST">
                    @csrf

                    <div class="form-step active" id="formStep1">
                        <p class="step-title">Buat Akun</p>
                        <p class="step-desc">Pilih peran Anda dan buat kredensial masuk</p>

                        <div class="role-cards">
                            <div class="role-card selected" onclick="selectRole('job_seeker', this)">
                                <div class="role-name">Pencari Jasa</div>
                                <div class="role-desc">Saya butuh layanan digital</div>
                            </div>

                            {{-- Tombol Untuk Pegawai (Penyedia Jasa) --}}
                            <div class="role-card" onclick="selectRole('job_provider', this)">
                                <div class="role-name">Penyedia Jasa</div>
                                <div class="role-desc">Saya menyediakan layanan</div>
                            </div>
                        </div>
                        <input type="hidden" name="role" id="roleTypeInput" value="job_seeker">

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" id="reg-username" class="form-control"
                                placeholder="Contoh: budi123" required value="{{ old('username') }}">
                            <div id="error-username" class="error-message">Username wajib diisi</div>
                        </div>
                        <div class="form-group">
                            <label>Kata Sandi</label>
                            <div style="position: relative;">
                                <input type="password" name="password" id="reg-password" class="form-control"
                                    placeholder="Minimal 6 karakter" required style="padding-right: 40px;">
                                <button type="button" onclick="togglePasswordVisibility('reg-password', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-muted); display: flex; align-items: center; justify-content: center; padding: 5px;">
                                    <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <svg class="eye-off-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                        <line x1="1" y1="1" x2="23" y2="23"></line>
                                    </svg>
                                </button>
                            </div>
                            <div id="error-password" class="error-message">Kata sandi minimal 6 karakter</div>
                        </div>

                        <div class="step-buttons">
                            <button type="button" class="btn-primary btn-next" onclick="nextStep(1)">
                                Lanjut &rarr;
                            </button>
                        </div>
                    </div>

                    <div class="form-step" id="formStep2">
                        <p class="step-title">Info Profil</p>
                        <p class="step-desc">Lengkapi data diri Anda</p>

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" id="reg-name" class="form-control"
                                placeholder="Nama lengkap Anda" required value="{{ old('name') }}">
                            <div id="error-name" class="error-message">Nama lengkap wajib diisi</div>
                        </div>
                        <div class="form-group">
                            <label>Pekerjaan / Profesi</label>
                            <input type="text" name="profession" id="reg-profession" class="form-control"
                                placeholder="Contoh: Mahasiswa, Pengusaha" required value="{{ old('profession') }}">
                            <div id="error-profession" class="error-message">Pekerjaan wajib diisi</div>
                        </div>
                        <div class="form-group">
                            <label>Keahlian</label>
                            <input type="text" name="skills" id="reg-skills" class="form-control"
                                placeholder="Contoh: Web Design, Marketing" required value="{{ old('skills') }}">
                            <div id="error-skills" class="error-message">Keahlian wajib diisi</div>
                        </div>
                        <div class="form-group">
                            <label>Tempat Kerja / Instansi</label>
                            <input type="text" name="workplace" class="form-control"
                                placeholder="Nama perusahaan atau instansi" value="{{ old('workplace') }}">
                        </div>
                        <div class="form-group">
                            <label>Metode Pembayaran (Untuk Penarikan/Pembayaran)</label>
                            <select name="payment_method" id="reg-payment-method" class="form-control" required>
                                <option value="" disabled selected>Pilih Metode</option>
                                <option value="BCA">BCA</option>
                                <option value="BNI">BNI</option>
                                <option value="BRI">BRI</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="DANA">DANA</option>
                                <option value="OVO">OVO</option>
                                <option value="GoPay">GoPay</option>
                            </select>
                            <div id="error-payment-method" class="error-message">Pilih metode pembayaran</div>
                        </div>
                        <div class="form-group">
                            <label>Nomor WhatsApp (Opsional)</label>
                            <input type="text" name="phone_number" id="reg-phone-number" class="form-control"
                                placeholder="Contoh: 6281234567890" value="{{ old('phone_number') }}">
                        </div>

                        <div class="step-buttons">
                            <button type="button" class="btn-back" onclick="prevStep(2)">&larr;</button>
                            <button type="button" class="btn-primary btn-next" onclick="nextStep(2)">
                                Lanjut &rarr;
                            </button>
                        </div>
                    </div>

                    <div class="form-step" id="formStep3">
                        <p class="step-title">Persetujuan</p>
                        <p class="step-desc">Baca dan setujui ketentuan kami sebelum melanjutkan</p>

                        <div class="checkbox-group">
                            <input type="checkbox" id="agreeTerms" name="terms" required>
                            <label for="agreeTerms">
                                Saya telah membaca dan menyetujui
                                <a href="{{ url('/terms') }}" target="_blank">Syarat & Ketentuan</a>
                                serta
                                <a href="{{ url('/privacy') }}" target="_blank">Kebijakan Privasi</a>
                                Yoanti.
                            </label>
                        </div>

                        <div class="step-buttons">
                            <button type="button" class="btn-back" onclick="prevStep(3)">&larr;</button>
                            <button type="submit" class="btn-primary btn-next">
                                Buat Akun ✓
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <p class="auth-footer">
                Sudah punya akun? <a href="{{ url('/login') }}">Masuk di sini</a>
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentStep = 1;

        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const eyeIcon = button.querySelector('.eye-icon');
            const eyeOffIcon = button.querySelector('.eye-off-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                input.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        }

        function selectRole(role, el) {
            document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('roleTypeInput').value = role;
        }

        function nextStep(step) {
            // Reset errors
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid', 'shake'));

            if (step === 1) {
                const usernameInput = document.getElementById('reg-username');
                const passwordInput = document.getElementById('reg-password');
                let hasError = false;

                if (!usernameInput.value.trim()) {
                    showError(usernameInput, 'error-username');
                    hasError = true;
                }

                if (passwordInput.value.length < 6) {
                    showError(passwordInput, 'error-password');
                    hasError = true;
                }

                if (hasError) return;
            }

            if (step === 2) {
                const nameInput = document.getElementById('reg-name');
                const professionInput = document.getElementById('reg-profession');
                const skillsInput = document.getElementById('reg-skills');
                const paymentMethodInput = document.getElementById('reg-payment-method');

                let hasError = false;

                if (!nameInput.value.trim()) {
                    showError(nameInput, 'error-name');
                    hasError = true;
                }

                if (!professionInput.value.trim()) {
                    showError(professionInput, 'error-profession');
                    hasError = true;
                }

                if (!skillsInput.value.trim()) {
                    showError(skillsInput, 'error-skills');
                    hasError = true;
                }

                if (!paymentMethodInput.value) {
                    showError(paymentMethodInput, 'error-payment-method');
                    hasError = true;
                }

                if (hasError) return;
            }

            goToStep(step + 1);
        }

        function showError(input, errorId) {
            input.classList.add('is-invalid', 'shake');
            const errorEl = document.getElementById(errorId);
            if (errorEl) errorEl.style.display = 'block';

            // Remove shake after animation
            setTimeout(() => input.classList.remove('shake'), 400);
        }

        function prevStep(step) {
            goToStep(step - 1);
        }

        function goToStep(target) {
            // Sembunyikan semua class form-step
            document.querySelectorAll('.form-step').forEach(s => {
                s.classList.remove('active');
            });

            // Aktifkan step yang dituju
            const targetStep = document.getElementById('formStep' + target);
            if (targetStep) {
                targetStep.classList.add('active');
            }

            // Update indikator UI
            for (let i = 1; i <= 3; i++) {
                const dot = document.getElementById('dot-' + i);
                const item = document.getElementById('step-item-' + i);

                if (!dot || !item) continue;

                const label = item.querySelector('.step-label');
                dot.className = 'step-dot';
                label.className = 'step-label';

                if (i < target) {
                    dot.classList.add('completed');
                    dot.innerHTML =
                        `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
                    item.classList.add('completed');
                } else if (i === target) {
                    dot.classList.add('active');
                    dot.innerHTML = i;
                    label.classList.add('active');
                    item.classList.remove('completed');
                } else {
                    dot.innerHTML = i;
                    item.classList.remove('completed');
                }
            }
            currentStep = target;
        }

        // Failsafe: Mencegah error submit jika pengguna menekan tombol ENTER pada input di step 1 atau 2
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            if (form) {
                form.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter' && currentStep !== 3) {
                        e.preventDefault();
                        nextStep(currentStep);
                    }
                });
            }
        });
    </script>
@endpush
