@extends('layouts.app')
@section('title', 'Kebijakan Privasi')

@push('styles')
<style>
    .legal-container { max-width: 800px; margin: 4rem auto; padding: 2rem; background: var(--card-bg); border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .legal-container h1 { color: var(--primary); margin-bottom: 2rem; }
    .legal-container h3 { margin-top: 1.5rem; margin-bottom: 1rem; color: var(--text); }
    .legal-container p, .legal-container li { line-height: 1.6; color: var(--text-muted); margin-bottom: 1rem; }
    .legal-container ul { padding-left: 20px; }
</style>
@endpush

@section('content')
<div class="legal-container">
    <h1>Kebijakan Privasi</h1>
    <p>Terakhir diperbarui: {{ date('d F Y') }}</p>

    <h3>1. Pengumpulan Data Informasi</h3>
    <p>Kami mengumpulkan data pribadi yang Anda berikan secara sukarela saat mendaftar, termasuk namun tidak terbatas pada:</p>
    <ul>
        <li>Nama lengkap dan username</li>
        <li>Informasi profesional (pekerjaan, keahlian, tempat kerja)</li>
        <li>Informasi pembayaran (nama bank/e-wallet dan nomor rekening)</li>
    </ul>

    <h3>2. Penggunaan Data</h3>
    <p>Data Anda digunakan untuk memfasilitasi transaksi layanan, melakukan verifikasi pengguna, serta meningkatkan pengalaman pengguna di platform kami. Data pembayaran dikumpulkan semata-mata untuk keperluan pelunasan dan penerimaan dana secara aman.</p>

    <h3>3. Keamanan Data</h3>
    <p>Kami berkomitmen untuk melindungi data pribadi dan finansial Anda. Semua kata sandi (password) dienkripsi dalam sistem kami, dan data sensitif dijaga dengan menggunakan kontrol keamanan yang ketat.</p>

    <h3>4. Berbagi Data</h3>
    <p>Kami tidak akan menjual atau menyewakan informasi pribadi Anda kepada pihak ketiga tanpa persetujuan eksplisit dari Anda, kecuali diwajibkan oleh hukum yang berlaku.</p>

    <h3>5. Hak Pengguna</h3>
    <p>Anda berhak meminta penghapusan akun serta seluruh data yang terkait dengannya sewaktu-waktu.</p>

    <div style="margin-top: 3rem; text-align: center;">
        <a href="{{ url('/register') }}" class="btn-primary">Kembali ke Pendaftaran</a>
    </div>
</div>
@endsection
