@extends('layouts.app')
@section('title', 'Login')

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
    .alert-success { background: #D1FAE5; color: #065F46; border: 1px solid #34D399; }
</style>
@endpush

@section('content')
<section class="auth-section">
    <div class="auth-container">
        <h2 style="text-align: center; margin-bottom: 2rem;">Masuk ke Akun</h2>
        
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%;">Login</button>
        </form>
        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-muted);">
            Belum punya akun? <a href="{{ url('/register') }}" style="color: var(--primary); font-weight: 600;">Daftar di sini</a>
        </p>
    </div>
</section>
@endsection
