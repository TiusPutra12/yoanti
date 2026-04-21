@extends('layouts.app')
@section('title', 'Beranda')

@push('styles')
    <style>
        /* ── HERO ── */
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: clamp(4rem, 12vh, 7rem) clamp(1rem, 5%, 2rem) clamp(3rem, 8vh, 5rem);
            background: linear-gradient(160deg, #EFF6FF 0%, #F8FAFC 50%, #FFFFFF 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: clamp(200px, 40vw, 500px);
            height: clamp(200px, 40vw, 500px);
            background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: clamp(150px, 30vw, 350px);
            height: clamp(150px, 30vw, 350px);
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            border: 1px solid rgba(37, 99, 235, 0.2);
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            margin-bottom: 1.5rem;
            z-index: 1;
        }

        .hero h1 {
            font-size: clamp(2rem, 6vw, 3.5rem);
            font-weight: 900;
            margin-bottom: 1.25rem;
            color: var(--text-main);
            max-width: 820px;
            letter-spacing: -0.03em;
            line-height: 1.1;
            z-index: 1;
        }

        .hero h1 span {
            background: linear-gradient(135deg, #2563EB, #6366F1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: clamp(0.95rem, 2vw, 1.15rem);
            color: var(--text-muted);
            max-width: 560px;
            margin-bottom: 2.25rem;
            line-height: 1.7;
            z-index: 1;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            z-index: 1;
        }

        .btn-cta {
            padding: 0.9rem 2rem;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
        }

        .btn-outline {
            padding: 0.9rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: white;
            color: var(--text-main);
            border: 1.5px solid var(--border);
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        /* Trust indicators */
        .hero-trust {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-top: 2.5rem;
            z-index: 1;
            flex-wrap: wrap;
            justify-content: center;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.825rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .trust-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10B981;
        }

        /* ── SERVICES ── */
        .services {
            padding: clamp(3rem, 8vw, 5rem) clamp(1rem, 5%, 2rem);
            background: #fff;
        }

        .section-header {
            text-align: center;
            margin-bottom: clamp(2rem, 5vw, 3.5rem);
        }

        .section-badge {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.3rem 0.85rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: clamp(1.6rem, 4vw, 2.25rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }

        .section-subtitle {
            color: var(--text-muted);
            font-size: clamp(0.875rem, 2vw, 1rem);
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
            gap: 1.5rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .service-card {
            background: #fff;
            padding: clamp(1.5rem, 4vw, 2.25rem);
            border-radius: 20px;
            border: 1.5px solid var(--border);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), #6366F1);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.1);
            border-color: rgba(37, 99, 235, 0.3);
        }

        .service-card:hover::before {
            opacity: 1;
        }

        .icon-wrapper {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 1.25rem;
        }

        .service-card h3 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-main);
            letter-spacing: -0.01em;
        }

        .service-card p {
            color: var(--text-muted);
            line-height: 1.65;
            font-size: 0.9rem;
        }

        /* ── STATS BAR ── */
        .stats-bar {
            background: linear-gradient(135deg, #1E40AF, #2563EB);
            padding: clamp(1.5rem, 4vw, 2.5rem) clamp(1rem, 5%, 2rem);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .stat-item {
            padding: 0.5rem;
        }

        .stat-number {
            font-size: clamp(1.75rem, 5vw, 2.5rem);
            font-weight: 900;
            color: white;
            letter-spacing: -0.02em;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        @media (max-width: 480px) {
            .hero-trust {
                gap: 1rem;
            }

            .btn-cta,
            .btn-outline {
                width: 100%;
                justify-content: center;
            }

            .hero-cta {
                flex-direction: column;
                align-items: stretch;
                width: 100%;
                max-width: 320px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="hero">
        <h1>Wujudkan <span>Website & Aplikasi Impian</span> Anda</h1>
        <p>Pengembangan perangkat lunak profesional dengan desain modern dan performa tinggi untuk bisnis Anda.</p>

        @if (!session()->has('user') || (isset(session('user')['role']) && session('user')['role'] !== 'admin'))
            <div class="hero-cta">
                <a href="{{ url('/pesan') }}" class="btn-primary btn-cta">
                    {{ session()->has('user') ? 'Pesan Sekarang' : 'Mulai Sekarang' }}
                </a>
                <a href="{{ url('/komentar') }}" class="btn-outline">Lihat Testimoni</a>
            </div>
        @endif

        <div class="hero-trust">
            <span class="trust-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                Harga Transparan
            </span>
            <span class="trust-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                Dukungan 24/7
            </span>
            <span class="trust-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                Pengiriman Tepat Waktu
            </span>
        </div>
    </section>

    <section class="stats-bar">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ isset($completedProjects) ? $completedProjects : '0' }}</div>
                <div class="stat-label">Proyek Selesai</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ isset($totalTestimonials) ? $totalTestimonials : '0' }}</div>
                <div class="stat-label">Testimoni</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">3+</div>
                <div class="stat-label">Tahun Pengalaman</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Support Aktif</div>
            </div>
        </div>
    </section>

    <section class="services">
        <div class="section-header">
            <span class="section-badge">Layanan Kami</span>
            <h2 class="section-title">Solusi Digital Lengkap</h2>
            <p class="section-subtitle">Dari ideasi hingga peluncuran, kami hadir untuk setiap tahap perjalanan digital
                Anda.</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <h3 style="text-align: center">Pembuatan Website</h3>
                <p style="text-align: center">Dari landing page hingga e-commerce kompleks — responsif, cepat, dan
                    SEO-ready.</p>
            </div>
            <div class="service-card">
                <h3 style="text-align: center">Aplikasi Android</h3>
                <p style="text-align: center">Aplikasi mobile interaktif dan user-friendly untuk memperluas jangkauan bisnis
                    Anda.</p>
            </div>
            <div class="service-card">
                <h3 style="text-align: center">UI/UX Professional</h3>
                <p style="text-align: center">Desain visual yang indah sekaligus intuitif untuk pengalaman pengguna yang
                    luar biasa.</p>
            </div>
        </div>
    </section>
@endsection
