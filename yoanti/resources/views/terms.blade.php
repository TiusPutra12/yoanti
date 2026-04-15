@extends('layouts.app')
@section('title', 'Syarat & Ketentuan')

@push('styles')
    <style>
        .legal-page {
            padding: clamp(2rem, 5vw, 4rem) clamp(1rem, 5%, 2rem);
            background: #F8FAFC;
            min-height: calc(100dvh - var(--nav-height));
        }

        .legal-container {
            max-width: 760px;
            margin: 0 auto;
            background: #fff;
            padding: clamp(1.5rem, 5vw, 3rem);
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .legal-badge {
            display: inline-block;
            background: #F0FDF4;
            color: #16A34A;
            border: 1px solid #BBF7D0;
            padding: 0.3rem 0.85rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .legal-container h1 {
            font-size: clamp(1.6rem, 4vw, 2.25rem);
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .legal-meta {
            font-size: 0.8rem;
            color: #94A3B8;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .legal-container h2 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 2rem 0 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .legal-container h2::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 1.05em;
            background: #16A34A;
            border-radius: 2px;
        }

        .legal-container p,
        .legal-container li {
            line-height: 1.8;
            color: #475569;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .legal-container ul { padding-left: 1.25rem; }
        .legal-container li { margin-bottom: 0.5rem; }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.5rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            margin-top: 2rem;
            background: var(--bg);
            color: var(--text-main);
            border: 1.5px solid var(--border);
            text-decoration: none;
            transition: var(--transition);
        }

        .back-btn:hover { background: #E2E8F0; border-color: #CBD5E1; }

        @media (max-width: 480px) {
            .legal-container {
                padding: 1.25rem;
                border: none;
                box-shadow: none;
                background: transparent;
            }
        }
    </style>
@endpush

@section('content')
    <div class="legal-page">
        <div class="legal-container">
            <span class="legal-badge">Legal</span>
            <h1>Syarat & Ketentuan</h1>
            <p class="legal-meta">Terakhir diperbarui: {{ date('d F Y') }}</p>

            <p>Dengan menggunakan layanan Yoanti, Anda menyetujui syarat dan ketentuan berikut. Harap baca dengan seksama sebelum menggunakan platform kami.</p>

            <h2>Penggunaan Layanan</h2>
            <p>Layanan Yoanti tersedia untuk pengguna yang telah mendaftar dan menyetujui ketentuan ini. Anda bertanggung jawab atas semua aktivitas yang dilakukan menggunakan akun Anda.</p>

            <h2>Larangan Penggunaan</h2>
            <p>Pengguna dilarang untuk:</p>
            <ul>
                <li>Menggunakan platform untuk tujuan ilegal atau melanggar hak orang lain</li>
                <li>Mengunggah konten yang mengandung SARA, pornografi, atau ujaran kebencian</li>
                <li>Mencoba meretas atau mengganggu keamanan sistem</li>
                <li>Membuat akun palsu atau menyamar sebagai orang lain</li>
            </ul>

            <h2>Pembayaran & Refund</h2>
            <p>Setiap kesepakatan harga dan jadwal pengerjaan ditetapkan secara tertulis sebelum proyek dimulai. Kebijakan refund disesuaikan dengan progres pengerjaan dan kesepakatan awal.</p>

            <h2>Kekayaan Intelektual</h2>
            <p>Seluruh hasil karya yang dibuat oleh Yoanti untuk klien akan menjadi milik klien setelah pelunasan penuh. Yoanti berhak mencantumkan proyek dalam portofolio setelah mendapatkan izin klien.</p>

            <h2>Perubahan Ketentuan</h2>
            <p>Yoanti berhak mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan diinformasikan melalui platform dan berlaku sejak tanggal pembaruan.</p>

            <a href="javascript:history.back()" class="back-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                Kembali
            </a>
        </div>
    </div>
@endsection
