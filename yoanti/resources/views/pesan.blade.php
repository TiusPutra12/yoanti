@extends('layouts.app')
@section('title', 'Konsultasi Project')

@push('styles')
    <style>
        .order-page {
            padding: clamp(2rem, 6vw, 4rem) clamp(1rem, 5%, 2rem);
            background: #F8FAFC;
            min-height: calc(100dvh - var(--nav-height));
        }

        .order-header {
            text-align: center;
            margin-bottom: clamp(1.5rem, 4vw, 2.5rem);
        }

        .order-header .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            padding: 0.35rem 0.9rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            margin-bottom: 0.75rem;
        }

        .order-header h1 {
            font-size: clamp(1.6rem, 4vw, 2.25rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .order-header p {
            color: var(--text-muted);
            font-size: clamp(0.875rem, 2vw, 1rem);
        }

        .form-card {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: clamp(1.5rem, 5vw, 2.5rem);
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 240px), 1fr));
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.45rem;
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.85rem;
        }

        .form-group label .required {
            color: #EF4444;
            margin-left: 0.2rem;
        }

        .form-control {
            width: 100%;
            min-height: 50px;
            padding: 0.75rem 1rem;
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
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .form-control::placeholder {
            color: #A0AEC0;
        }

        textarea.form-control {
            min-height: 130px;
            resize: vertical;
            padding: 0.9rem 1rem;
            line-height: 1.6;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
            cursor: pointer;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.5rem 0;
        }

        .form-section-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .submit-area {
            margin-top: 1.75rem;
        }

        .btn-submit {
            border: none;
            width: 100%;
            min-height: 56px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            letter-spacing: -0.01em;
            cursor: pointer;
        }

        .form-note {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            justify-content: center;
        }

        @media (max-width: 480px) {
            .order-page { padding: 1.5rem 0.75rem; }
            .form-card {
                padding: 1.5rem;
                border-radius: 16px;
                border: 1px solid var(--border);
                background: #fff;
            }
            .form-control { min-height: 48px; font-size: 16px; }
            .btn-submit { min-height: 52px; font-size: 0.95rem; }
            .order-header h1 { font-size: 1.5rem; }
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
    <div class="order-page">
        <div class="order-header">
            <div class="badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <path
                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                </svg>
                Konsultasi Gratis
            </div>
            <h1>Ceritakan Project Anda</h1>
            <p>Kami akan menghubungi Anda melalui WhatsApp dalam 1×24 jam</p>
        </div>

        <div class="form-card">
            <form id="orderForm" onsubmit="sendToWhatsApp(event)">
                <p class="form-section-title">Data Diri</p>
                <div class="form-grid" style="gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="name" class="form-control" placeholder="Budi Santoso" value="{{ session('user')['name'] ?? '' }}" required {{ session()->has('user') ? 'readonly' : '' }}>
                    </div>
                    <div class="form-group">
                        <label>Instansi / Perusahaan <span class="required">*</span></label>
                        <input type="text" id="company" class="form-control" placeholder="Nama instansi Anda" value="{{ session('user')['workplace'] ?? '' }}" required {{ session()->has('user') && isset(session('user')['workplace']) && session('user')['workplace'] !== '' ? 'readonly' : '' }}>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label>Alamat Domisili <span class="required">*</span></label>
                    <input type="text" id="address" class="form-control" placeholder="Kota / Provinsi" required>
                </div>

                <hr class="divider">
                <p class="form-section-title">Detail Project</p>

                <div class="form-grid" style="gap: 1rem; margin-bottom: 1rem;">
                    <div class="form-group">
                        <label>Jenis Layanan <span class="required">*</span></label>
                        <select id="programType" class="form-control" required>
                            <option value="" disabled selected>Pilih layanan...</option>
                            <option value="Pembuatan Website">Pembuatan Website</option>
                            <option value="Aplikasi Android">Aplikasi Android</option>
                            <option value="Sistem Informasi">Sistem Informasi (ERP/CRM)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Estimasi Budget <span class="required">*</span></label>
                        <select id="budget" class="form-control" required>
                            <option value="" disabled selected>Pilih kisaran budget...</option>
                            <option value="< Rp 5 Juta">Di bawah Rp 5 Juta</option>
                            <option value="Rp 5 Juta - Rp 15 Juta">Rp 5 Juta – Rp 15 Juta</option>
                            <option value="> Rp 15 Juta">Di atas Rp 15 Juta</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label>Deskripsi Kebutuhan <span class="required">*</span></label>
                    <textarea id="description" class="form-control"
                        placeholder="Jelaskan kebutuhan Anda secara detail: fitur yang diinginkan, referensi, dll." required></textarea>
                </div>

                <div class="submit-area">
                    <button type="submit" class="btn-primary btn-submit" id="submitBtn">
                        Hubungi via WhatsApp
                    </button>

                    <p class="form-note">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        Data Anda aman dan terenkripsi
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function sendToWhatsApp(e) {
            e.preventDefault(); // Mencegah reload halaman standar form

            const name = document.getElementById('name');
            const company = document.getElementById('company');
            const address = document.getElementById('address');
            const programType = document.getElementById('programType');
            const budget = document.getElementById('budget');
            const description = document.getElementById('description');

            // Reset
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid', 'shake'));

            let hasError = false;
            if (!name.value.trim()) { showError(name, ' Nama wajib diisi'); hasError = true; }
            if (!company.value.trim()) { showError(company, ' Instansi wajib diisi'); hasError = true; }
            if (!address.value.trim()) { showError(address, ' Alamat wajib diisi'); hasError = true; }
            if (!programType.value) { showError(programType, ' Pilih layanan'); hasError = true; }
            if (!budget.value) { showError(budget, ' Pilih budget'); hasError = true; }
            if (!description.value.trim()) { showError(description, ' Deskripsi wajib diisi'); hasError = true; }

            if (hasError) return;

            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = 'Memproses...';

            const msg =
                `Halo Tim Yoanti! 👋\nSaya ingin berkonsultasi mengenai project.\n\n*Nama:* ${name.value}\n*Instansi:* ${company.value}\n*Domisili:* ${address.value}\n*Layanan:* ${programType.value}\n*Budget:* ${budget.value}\n*Deskripsi:* ${description.value}`;

            // Buka WhatsApp di tab/aplikasi lain
            window.open(`https://wa.me/6287883322975?text=${encodeURIComponent(msg)}`, '_blank');

            // Kirim data ke backend di background
            fetch("{{ url('/pesan/store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: name.value,
                    company: company.value,
                    address: address.value,
                    programType: programType.value,
                    budget: budget.value,
                    description: description.value
                })
            }).then(() => {
                window.location.href = "{{ url('/') }}";
            }).catch(err => {
                console.error("Error saat menyimpan ke DB:", err);
                window.location.href = "{{ url('/') }}";
            });
        }

        function showError(input, msg) {
            input.classList.add('is-invalid', 'shake');
            // Check if error message already exists, if not create one
            let errorEl = input.nextElementSibling;
            if (!errorEl || !errorEl.classList.contains('error-message')) {
                errorEl = document.createElement('div');
                errorEl.className = 'error-message';
                input.parentNode.appendChild(errorEl);
            }
            errorEl.innerText = msg;
            errorEl.style.display = 'block';
            setTimeout(() => input.classList.remove('shake'), 400);
        }
    </script>
@endpush
