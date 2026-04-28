@extends('layouts.app')
@section('title', 'Pengaturan Akun')

@push('styles')
    <style>
        .settings-container {
            max-width: 600px;
            margin: 3rem auto;
            background: #fff;
            padding: clamp(2rem, 5vw, 3rem);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg), 0 0 0 1px rgba(0, 0, 0, 0.04);
        }

        .settings-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px dashed var(--border);
        }

        .settings-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .settings-desc {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            background: #F8FAFC;
            color: var(--text-main);
            font-size: 0.95rem;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .alert-box {
            padding: 1rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .alert-warning {
            background: #FFFBEB;
            color: #B45309;
            border: 1px solid #FDE68A;
        }

        .alert-success {
            background: #ECFDF5;
            color: #059669;
            border: 1px solid #A7F3D0;
        }

        .alert-danger {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
        }

        .btn-save {
            width: 100%;
            padding: 1rem;
            font-size: 1.05rem;
            font-weight: 700;
            border-radius: var(--radius-sm);
            margin-top: 1.5rem;
            background: var(--primary);
            color: white;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            background: var(--primary-hover);
            box-shadow: 0 12px 32px rgba(37, 99, 235, 0.35);
        }

        .password-section {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px dashed var(--border);
        }
        
        .password-section-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-main);
        }

        @media (max-width: 480px) {
            .settings-container {
                margin: 1.5rem auto;
                padding: 1.5rem;
                border-radius: var(--radius-md);
            }
        }
    </style>
@endpush

@section('content')
    <div class="settings-container">
        <div class="settings-header">
            <h1 class="settings-title">Pengaturan Akun</h1>
            <p class="settings-desc">Kelola profil, informasi identitas, dan keamanan akun Anda.</p>
        </div>

        @if(session('success'))
            <div class="alert-box alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-box alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-box alert-danger">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert-box alert-warning">
            <strong>Perhatian:</strong> Mengubah <em>Username</em> akan secara otomatis memperbarui profil Anda di semua data pesanan, komentar, dan portofolio Anda.
        </div>

        <form action="{{ url('/pengaturan-akun/update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ session('user')['name'] }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ session('user')['username'] }}" required>
            </div>

            @if(!isset(session('user')['role']) || (session('user')['role'] !== 'admin' && session('user')['role'] !== 'superadmin'))
            <div style="border-top: 1px dashed var(--border); margin-top: 2rem; padding-top: 1.5rem;">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-main);">Informasi Tambahan</h3>
                
                <div class="form-group">
                    <label class="form-label" for="profession">Profesi</label>
                    <input type="text" id="profession" name="profession" class="form-control" value="{{ session('user')['profession'] ?? '' }}" placeholder="Contoh: Web Developer, Designer">
                </div>

                <div class="form-group">
                    <label class="form-label" for="skills">Keahlian (Skills)</label>
                    <input type="text" id="skills" name="skills" class="form-control" value="{{ session('user')['skills'] ?? '' }}" placeholder="Contoh: PHP, UI/UX, Copywriting">
                </div>

                <div class="form-group">
                    <label class="form-label" for="workplace">Tempat Kerja / Instansi</label>
                    <input type="text" id="workplace" name="workplace" class="form-control" value="{{ session('user')['workplace'] ?? '' }}" placeholder="Contoh: PT Teknologi Bangsa">
                </div>

                <div class="form-group">
                    <label class="form-label" for="payment_method">Metode Pembayaran Pilihan</label>
                    <input type="text" id="payment_method" name="payment_method" class="form-control" value="{{ session('user')['payment_method'] ?? '' }}" placeholder="Contoh: BCA / GoPay / OVO">
                </div>
            </div>
            @endif

            <div class="password-section">
                <h3 class="password-section-title">Keamanan Akun</h3>
                
                <div class="form-group">
                    <label class="form-label" for="new_password">Password Baru (Opsional)</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                </div>

                <div class="form-group">
                    <label class="form-label" for="current_password">Password Saat Ini (Wajib)</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Masukkan password Anda saat ini untuk verifikasi" required>
                </div>
            </div>

            <button type="submit" class="btn-save">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Simpan Perubahan
            </button>
        </form>
    </div>
@endsection
