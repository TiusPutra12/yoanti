@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
    <style>
        /* Hero Section */
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 8rem 5% 6rem;
            background: linear-gradient(135deg, #F0F5FF 0%, #FFFFFF 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: var(--primary);
            filter: blur(150px);
            opacity: 0.1;
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.25rem;
            color: var(--text-main);
            max-width: 900px;
            letter-spacing: -1px;
            line-height: 1.2;
            z-index: 1;
        }

        .hero h1 span {
            color: var(--primary);
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 650px;
            margin-bottom: 2.5rem;
            z-index: 1;
        }

        /* Services */
        .services {
            padding: 6rem 5%;
            background: var(--card-bg);
        }

        .section-title {
            text-align: center;
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 4rem;
            color: var(--text-main);
        }

        .components-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .card {
            background: #FFFFFF;
            padding: 2.5rem;
            border-radius: 20px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card h3 {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-main);
        }

        .card p {
            color: var(--text-muted);
            line-height: 1.7;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.25rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero {
                padding: 6rem 5% 4rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="hero">
        <h1>Wujudkan <span>Website & Aplikasi Impian</span> Anda Bersama Kami</h1>
        <p>Jasa pembuatan project IT profesional dengan desain modern, performa tinggi, dan solusi handal untuk
            menskalakan bisnis Anda.</p>
        @if(!session()->has('user') || (isset(session('user')['role']) && session('user')['role'] !== 'admin'))
        <a href="{{ url('/pesan') }}" class="btn-primary" style="padding: 1rem 2rem; font-size: 1.1rem;">
            Mulai Pemesanan
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </a>
        @endif
    </section>

    <section class="services">
        <h2 class="section-title">Layanan Unggulan Kami</h2>
        <div class="components-grid">
            <div class="card">
                <div class="icon-wrapper">💻</div>
                <h3>Pembuatan Website</h3>
                <p>Website company profile, e-commerce, sistem informasi, hingga landing page dinamis dengan desain
                    responsif dan SEO friendly.</p>
            </div>
            <div class="card">
                <div class="icon-wrapper">📱</div>
                <h3>Aplikasi Android</h3>
                <p>Pengembangan aplikasi mobile native atau cross-platform yang user-friendly, interaktif, dan siap
                    dipublish ke Play Store.</p>
            </div>
            <div class="card">
                <div class="icon-wrapper">✨</div>
                <h3>UI/UX Professional</h3>
                <p>Desain antarmuka kelas dunia yang berfokus pada keindahan estetika dan kenyamanan pengalaman pengguna
                    (User Experience).</p>
            </div>
        </div>
    </section>
@endsection
