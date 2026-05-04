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

        /* Profile Photo Preview Styles */
        .profile-photo-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .profile-photo-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            overflow: hidden;
        }

        .profile-photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-upload-photo {
            margin-top: 1rem;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            cursor: pointer;
            padding: 0.5rem 1rem;
            border: 1.5px solid var(--primary);
            border-radius: 999px;
            transition: all 0.2s;
            background: transparent;
        }

        .btn-upload-photo:hover {
            background: var(--primary-light);
        }

        #photo_input, #cover_input {
            display: none;
        }

        .cover-photo-wrapper {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: var(--radius-md);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cover-photo-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.8;
        }

        .btn-upload-cover {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-main);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }

        .btn-upload-cover:hover {
            background: #fff;
            transform: translateY(-2px);
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

        <form action="{{ url('/pengaturan-akun/update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="cover-photo-wrapper" id="cover_preview_wrapper">
                @if(isset(session('user')['cover_photo']) && session('user')['cover_photo'])
                    <img src="{{ asset(session('user')['cover_photo']) }}" alt="Cover" class="cover-photo-preview" id="cover_preview_img">
                @endif
                <label for="cover_input" class="btn-upload-cover">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 5px; vertical-align: middle;">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    Ganti Sampul Profil
                </label>
                <input type="file" name="cover_photo" id="cover_input" accept="image/*">
            </div>

            <div class="profile-photo-wrapper">
                <div class="profile-photo-preview" id="photo_preview">
                    @if(isset(session('user')['avatar']) && session('user')['avatar'])
                        <img src="{{ asset(session('user')['avatar']) }}" alt="Avatar">
                    @else
                        {{ strtoupper(substr(session('user')['name'], 0, 1)) }}
                    @endif
                </div>
                <label for="photo_input" class="btn-upload-photo">Ganti Foto Profil</label>
                <input type="file" name="avatar" id="photo_input" accept="image/*">
            </div>

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

                <div class="form-group">
                    <label class="form-label" for="phone_number">Nomor WhatsApp (Contoh: 6281234567890)</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ session('user')['phone_number'] ?? '' }}" placeholder="Gunakan format 62 tanpa + atau 0 di depan">
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

    <script>
        document.getElementById('photo_input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('photo_preview');
                    preview.innerHTML = `<img src="${event.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            }
        });

        if (document.getElementById('cover_input')) {
            document.getElementById('cover_input').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        let img = document.getElementById('cover_preview_img');
                        if (!img) {
                            img = document.createElement('img');
                            img.id = 'cover_preview_img';
                            img.className = 'cover-photo-preview';
                            document.getElementById('cover_preview_wrapper').prepend(img);
                        }
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>
@endsection
