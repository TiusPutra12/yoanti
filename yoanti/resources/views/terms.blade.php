@extends('layouts.app')
@section('title', 'Syarat & Ketentuan')

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
    <h1>Syarat dan Ketentuan</h1>
    <p>Terakhir diperbarui: {{ date('d F Y') }}</p>

    <h3>1. Pendahuluan</h3>
    <p>Selamat datang di platform kami. Dengan mengakses dan menggunakan layanan kami, Anda dianggap telah membaca, memahami, dan menyetujui seluruh Syarat dan Ketentuan ini.</p>

    <h3>2. Akun Pengguna</h3>
    <ul>
        <li>Anda bertanggung jawab menjaga kerahasiaan akun dan password Anda.</li>
        <li>Anda harus memberikan informasi yang akurat, lengkap, dan terkini saat pendaftaran.</li>
        <li>Satu individu atau perusahaan hanya diperbolehkan memiliki satu akun aktif kecuali ada izin khusus.</li>
    </ul>

    <h3>3. Peran Pengguna</h3>
    <p>Platform kami memfasilitasi dua peran utama: Pencari Pekerjaan dan Pemberi Pekerjaan. Masing-masing peran memiliki hak akses dan kewajiban sesuai fungsinya dalam platform.</p>

    <h3>4. Transaksi dan Pembayaran</h3>
    <p>Segala proses pembayaran harus dilakukan melalui jalur resmi yang kami sediakan atau sesuai dengan kesepakatan yang terdokumentasi.</p>

    <h3>5. Perubahan Ketentuan</h3>
    <p>Kami berhak untuk memperbarui Syarat dan Ketentuan ini sewaktu-waktu. Perubahan akan diinformasikan melalui platform ini.</p>

    <div style="margin-top: 3rem; text-align: center;">
        <a href="{{ url('/register') }}" class="btn-primary">Kembali ke Pendaftaran</a>
    </div>
</div>
@endsection
