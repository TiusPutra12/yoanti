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
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.498 14.382c-.301-.15-1.767-.867-2.04-.966-.273-.101-.473-.15-.673.15-.197.295-.771.964-.944 1.162-.175.195-.349.21-.646.075-.3-.15-1.263-.465-2.403-1.485-.888-.795-1.484-1.77-1.66-2.07-.174-.3-.019-.465.13-.615.136-.135.301-.345.451-.523.146-.181.194-.301.297-.496.1-.21.049-.375-.025-.524-.075-.15-.672-1.62-.922-2.206-.24-.584-.487-.51-.672-.51-.172-.015-.371-.015-.571-.015-.2 0-.523.074-.797.359-.273.3-1.045 1.02-1.045 2.475s1.07 2.865 1.219 3.075c.149.195 2.105 3.195 5.1 4.485.714.3 1.27.48 1.704.629.714.227 1.365.195 1.88.121.574-.091 1.767-.721 2.016-1.426.255-.705.255-1.29.18-1.425-.074-.135-.27-.21-.57-.345z" />
                            <path
                                d="M20.52 3.449C12.831-3.984.106 1.407.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652C8.07 23.418 9.995 23.843 11.93 23.843c9.332 0 17.066-7.65 17.07-17.05.004-4.562-1.77-8.845-4.48-11.344zM11.93 21.95c-1.794 0-3.554-.483-5.09-1.39l-.364-.214-3.77.989 1.008-3.673-.238-.376C1.596 14.917 1.01 13.473 1.01 11.893c.004-8.178 6.65-14.833 14.82-14.833 3.953 0 7.68 1.535 10.47 4.33 2.787 2.795 4.315 6.505 4.313 10.413-.005 8.179-6.652 14.834-14.823 14.834-.003 0 .003 0 0 0l.14.313-3.68.963-.143-.22z"
                                fill-rule="evenodd" />
                        </svg>
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
