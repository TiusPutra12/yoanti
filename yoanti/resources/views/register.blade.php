@extends('layouts.app')
@section('title', 'Register')

@push('styles')
<style>
    .auth-section { padding: 4rem 5%; min-height: 80vh; display: flex; align-items: center; justify-content: center; }
    .auth-container { background: var(--card-bg); padding: 3rem; border-radius: 24px; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05); border: 1px solid var(--border); width: 100%; max-width: 600px; }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; }
    .form-control { width: 100%; padding: 0.8rem 1.2rem; border: 1.5px solid var(--border); border-radius: 10px; font-size: 1rem; }
    .form-control:focus { outline: none; border-color: var(--primary); }
    .alert { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; }
    .alert-error { background: #FEE2E2; color: #991B1B; border: 1px solid #F87171; }
    
    /* Multi-step Styles */
    .step-indicator { display: flex; justify-content: space-between; margin-bottom: 2rem; position: relative; }
    .step-indicator::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 2px; background: var(--border); z-index: 1; transform: translateY(-50%); }
    .step-dot { width: 30px; height: 30px; border-radius: 50%; background: var(--card-bg); border: 2px solid var(--border); display: flex; align-items: center; justify-content: center; font-weight: bold; z-index: 2; position: relative; color: var(--text-muted); transition: all 0.3s ease; }
    .step-dot.active { border-color: var(--primary); background: var(--primary); color: white; }
    .step-dot.completed { border-color: var(--primary); background: var(--card-bg); color: var(--primary); }
    
    .form-step { display: none; animation: fadeIn 0.4s; }
    .form-step.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    .role-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
    .role-card { border: 2px solid var(--border); border-radius: 12px; padding: 1.5rem; text-align: center; cursor: pointer; transition: all 0.3s; }
    .role-card:hover { border-color: var(--primary); }
    .role-card.selected { border-color: var(--primary); background: rgba(37, 99, 235, 0.05); }
    .role-card img { width: 60px; height: 60px; margin-bottom: 1rem; opacity: 0.8; }
    
    .step-buttons { display: flex; justify-content: space-between; margin-top: 2rem; }
    .btn-secondary { background: white; color: var(--text); border: 1px solid var(--border); padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 500; cursor: pointer; transition: all 0.3s; }
    .btn-secondary:hover { background: var(--bg-hover); }
    
    .checkbox-group { display: flex; align-items: flex-start; gap: 0.8rem; margin-top: 1rem; }
    .checkbox-group input[type="checkbox"] { margin-top: 0.3rem; width: 18px; height: 18px; cursor: pointer; }
    .checkbox-group label { font-weight: 400; font-size: 0.95rem; line-height: 1.5; cursor: pointer; }
    .checkbox-group a { color: var(--primary); font-weight: 600; text-decoration: underline; }
</style>
@endpush

@section('content')
<section class="auth-section">
    <div class="auth-container">
        <h2 style="text-align: center; margin-bottom: 0.5rem;">Daftar Akun Baru</h2>
        <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Lengkapi data diri Anda untuk bergabung</p>
        
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="step-indicator">
            <div class="step-dot active" data-step="1">1</div>
            <div class="step-dot" data-step="2">2</div>
            <div class="step-dot" data-step="3">3</div>
            <div class="step-dot" data-step="4">4</div>
        </div>

        <form action="{{ url('/register') }}" method="POST" id="registerForm">
            @csrf
            
            <!-- Step 1: Role Selection -->
            <div class="form-step active" id="step1">
                <h3 style="margin-bottom: 1.5rem;">Pilih Peran Anda</h3>
                
                <input type="hidden" name="role" id="roleInput" required value="{{ old('role') }}">
                <div class="role-cards">
                    <div class="role-card {{ old('role') == 'job_provider' ? 'selected' : '' }}" onclick="selectRole('job_provider', this)">
                        <h4>Pemberi Pekerjaan</h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.5rem;">Saya ingin mencari talenta untuk mengerjakan proyek saya.</p>
                    </div>
                    <div class="role-card {{ old('role') == 'job_seeker' ? 'selected' : '' }}" onclick="selectRole('job_seeker', this)">
                        <h4>Pencari Pekerjaan</h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.5rem;">Saya ingin menawarkan keahlian saya dan mencari proyek.</p>
                    </div>
                </div>
                
                <div class="step-buttons" style="justify-content: flex-end;">
                    <button type="button" class="btn-primary" onclick="nextStep(1)">Selanjutnya</button>
                </div>
            </div>

            <!-- Step 2: Personal Info -->
            <div class="form-step" id="step2">
                <h3 style="margin-bottom: 1.5rem;">Data Pribadi</h3>
                
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Buat username unik" value="{{ old('username') }}" required minlength="3">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 4 karakter" required minlength="4">
                </div>
                
                <div class="step-buttons">
                    <button type="button" class="btn-secondary" onclick="prevStep(2)">Kembali</button>
                    <button type="button" class="btn-primary" onclick="nextStep(2)">Selanjutnya</button>
                </div>
            </div>

            <!-- Step 3: Professional Info -->
            <div class="form-step" id="step3">
                <h3 style="margin-bottom: 1.5rem;">Profesional & Keahlian</h3>
                
                <div class="form-group">
                    <label>Pekerjaan Saat Ini</label>
                    <input type="text" name="profession" id="profession" class="form-control" placeholder="Contoh: Web Developer, Designer" value="{{ old('profession') }}" required>
                </div>
                <div class="form-group">
                    <label>Keahlian (Pisahkan dengan koma)</label>
                    <input type="text" name="skills" id="skills" class="form-control" placeholder="Contoh: Laravel, Vue JS, Figma" value="{{ old('skills') }}" required>
                </div>
                <div class="form-group">
                    <label>Tempat Bekerja Saat Ini (Opsional)</label>
                    <input type="text" name="workplace" class="form-control" placeholder="Contoh: PT Teknologi Bangsa" value="{{ old('workplace') }}">
                </div>
                
                <div class="step-buttons">
                    <button type="button" class="btn-secondary" onclick="prevStep(3)">Kembali</button>
                    <button type="button" class="btn-primary" onclick="nextStep(3)">Selanjutnya</button>
                </div>
            </div>

            <!-- Step 4: Payment & Legal -->
            <div class="form-step" id="step4">
                <h3 style="margin-bottom: 1.5rem;">Verifikasi Pembayaran & Persetujuan</h3>
                
                <div class="form-group">
                    <label>Metode Pembayaran (Bank / E-Wallet)</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="">-- Pilih Bank / E-Wallet --</option>
                        <option value="BCA" {{ old('payment_method') == 'BCA' ? 'selected' : '' }}>BCA</option>
                        <option value="Mandiri" {{ old('payment_method') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                        <option value="BNI" {{ old('payment_method') == 'BNI' ? 'selected' : '' }}>BNI</option>
                        <option value="BRI" {{ old('payment_method') == 'BRI' ? 'selected' : '' }}>BRI</option>
                        <option value="GoPay" {{ old('payment_method') == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                        <option value="OVO" {{ old('payment_method') == 'OVO' ? 'selected' : '' }}>OVO</option>
                        <option value="DANA" {{ old('payment_method') == 'DANA' ? 'selected' : '' }}>DANA</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nomor Rekening / Nomor E-Wallet</label>
                    <input type="text" name="payment_account" id="payment_account" class="form-control" placeholder="Contoh: 1234567890" value="{{ old('payment_account') }}" required>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }} required>
                    <label for="terms">
                        Saya sudah mengerti dan setuju tentang <a href="{{ url('/terms') }}" target="_blank">Syarat dan Ketentuan</a> serta <a href="{{ url('/privacy') }}" target="_blank">Kebijakan Privasi</a> yang ada di web ini.
                    </label>
                </div>
                
                <div class="step-buttons">
                    <button type="button" class="btn-secondary" onclick="prevStep(4)">Kembali</button>
                    <button type="submit" class="btn-primary" id="submitBtn">Daftar Sekarang</button>
                </div>
            </div>
        </form>

        <p style="text-align: center; margin-top: 2rem; font-size: 0.9rem; color: var(--text-muted);">
            Sudah punya akun? <a href="{{ url('/login') }}" style="color: var(--primary); font-weight: 600;">Login di sini</a>
        </p>
    </div>
</section>

<script>
    function selectRole(role, element) {
        document.getElementById('roleInput').value = role;
        document.querySelectorAll('.role-card').forEach(card => card.classList.remove('selected'));
        element.classList.add('selected');
    }

    function nextStep(currentStep) {
        // Validation before moving to next step
        if (currentStep === 1) {
            if (!document.getElementById('roleInput').value) {
                alert('Silakan pilih peran Anda terlebih dahulu.');
                return;
            }
        } else if (currentStep === 2) {
            if (!document.getElementById('name').value || !document.getElementById('username').value || !document.getElementById('password').value) {
                alert('Mohon lengkapi semua data wajib (Nama, Username, Password).');
                return;
            }
            if (document.getElementById('password').value.length < 4) {
                alert('Password minimal 4 karakter.');
                return;
            }
        } else if (currentStep === 3) {
            if (!document.getElementById('profession').value || !document.getElementById('skills').value) {
                alert('Mohon lengkapi Pekerjaan dan Keahlian Anda.');
                return;
            }
        }

        // Hide current step, show next
        document.getElementById('step' + currentStep).classList.remove('active');
        document.getElementById('step' + (currentStep + 1)).classList.add('active');
        
        // Update dots
        updateDots(currentStep + 1);
    }

    function prevStep(currentStep) {
        document.getElementById('step' + currentStep).classList.remove('active');
        document.getElementById('step' + (currentStep - 1)).classList.add('active');
        updateDots(currentStep - 1);
    }

    function updateDots(activeStep) {
        document.querySelectorAll('.step-dot').forEach(dot => {
            let step = parseInt(dot.getAttribute('data-step'));
            if (step < activeStep) {
                dot.className = 'step-dot completed';
            } else if (step === activeStep) {
                dot.className = 'step-dot active';
            } else {
                dot.className = 'step-dot';
            }
        });
    }

    document.getElementById('registerForm').addEventListener('submit', function(e) {
        if (!document.getElementById('terms').checked) {
            e.preventDefault();
            alert('Anda harus menyetujui Syarat dan Ketentuan untuk melanjutkan.');
        }
    });

    // Handle initial state if there are validation errors (redirects back with old input)
    window.onload = function() {
        if('{{ old('role') }}' && '{{ session('error') }}' || '{{ $errors->any() }}') {
            // Keep them on step 1 to see the global errors, but if we wanted to be clever we could figure out which step had the error.
            // For now, let's just make sure the selected role is styled correctly (handled by blade template logic)
        }
    }
</script>
@endsection
