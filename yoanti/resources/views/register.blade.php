@extends('layouts.app')
@section('title', 'Register')

@push('styles')
<style>
    .auth-section { padding: 4rem 5%; min-height: 80vh; display: flex; align-items: center; justify-content: center; }
    .auth-container { background: var(--card-bg); padding: 3rem; border-radius: 24px; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05); border: 1px solid var(--border); width: 100%; max-width: 450px; }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.9rem; }
    .form-control { width: 100%; padding: 0.8rem 1.2rem; border: 1.5px solid var(--border); border-radius: 10px; font-size: 1rem; }
    .form-control:focus { outline: none; border-color: var(--primary); }
    .alert { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; }
    .alert-error { background: #FEE2E2; color: #991B1B; border: 1px solid #F87171; }
</style>
@endpush

@section('content')
<section class="auth-section">
    <div class="auth-container">
        <h2 style="text-align: center; margin-bottom: 2rem;">Daftar Akun Baru</h2>
        
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <form action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Buat username unik" required minlength="3">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 4 karakter" required minlength="4">
            </div>
            <button type="submit" class="btn-primary" style="width: 100%;">Daftar Sekarang</button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-muted);">
            Sudah punya akun? <a href="{{ url('/login') }}" style="color: var(--primary); font-weight: 600;">Login di sini</a>
        </p>
    </div>
</section>
@endsection
