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
            padding: clamp(6rem, 15vh, 10rem) clamp(1rem, 5%, 2rem) clamp(4rem, 10vh, 7rem);
            background: radial-gradient(circle at 50% 0%, rgba(79, 70, 229, 0.08) 0%, transparent 60%), #FAFAFA;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: linear-gradient(rgba(79, 70, 229, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(79, 70, 229, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
            pointer-events: none;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
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
            font-size: clamp(2.5rem, 7vw, 4.5rem);
            font-weight: 900;
            margin-bottom: 1.5rem;
            color: var(--text-main);
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        .hero h1 span {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.8;
            font-weight: 400;
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
            padding: clamp(5rem, 10vw, 7rem) clamp(1rem, 5%, 2rem);
            background: #FAFAFA;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: clamp(3rem, 6vw, 4.5rem);
        }

        .section-badge {
            display: inline-block;
            background: rgba(79, 70, 229, 0.1);
            color: #4F46E5;
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: clamp(2rem, 5vw, 2.75rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.03em;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--text-muted);
            font-size: clamp(1rem, 2vw, 1.125rem);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-card {
            background: #fff;
            padding: clamp(2rem, 5vw, 3rem);
            border-radius: 24px;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4F46E5, #7C3AED);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.08);
            border-color: rgba(79, 70, 229, 0.1);
        }

        .service-card:hover::before {
            opacity: 1;
        }

        .icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: rgba(79, 70, 229, 0.08);
            color: #4F46E5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            transition: all 0.4s;
        }

        .service-card:hover .icon-wrapper {
            background: #4F46E5;
            color: #fff;
            transform: scale(1.05) rotate(-5deg);
        }

        .service-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .service-card p {
            color: var(--text-muted);
            line-height: 1.7;
            font-size: 0.95rem;
        }

        /* ── STATS BAR ── */
        .stats-bar {
            background: linear-gradient(135deg, #111827, #1F2937);
            padding: clamp(2.5rem, 6vw, 4rem) clamp(1rem, 5%, 2rem);
            border-top: 1px solid rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.05);
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
        <div class="hero-content">
            <h1 class="animate-fade-in-up">Wujudkan <span>Website & Aplikasi Impian</span> Anda</h1>
            <p class="animate-fade-in-up stagger-1">Pengembangan perangkat lunak kelas enterprise dengan desain premium dan performa tanpa kompromi untuk bisnis modern Anda.</p>

            @if (!session()->has('user') || (isset(session('user')['role']) && session('user')['role'] !== 'admin'))
                <div class="hero-cta animate-fade-in-up stagger-2">
                    <a href="{{ url('/pesan') }}" class="btn-primary btn-cta hover-lift">
                        {{ session()->has('user') ? 'Pesan Sekarang' : 'Mulai Transformasi' }}
                    </a>
                    <a href="{{ url('/komentar') }}" class="btn-outline hover-lift">Lihat Portfolio</a>
                </div>
            @endif

            <div class="hero-trust animate-fade-in-up stagger-3">
                <span class="trust-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Harga Transparan
                </span>
                <span class="trust-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10B981"
                        stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Dukungan 24/7
                </span>
                <span class="trust-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10B981"
                        stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Kualitas Premium
                </span>
            </div>
        </div>
    </section>

    <section class="stats-bar">
        <div class="stats-grid animate-fade-in-up">
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
        <div class="section-header animate-fade-in-up">
            <span class="section-badge">Layanan Kami</span>
            <h2 class="section-title">Solusi Digital Lengkap</h2>
            <p class="section-subtitle">Dari ideasi hingga peluncuran, kami hadir untuk setiap tahap perjalanan digital
                Anda.</p>
        </div>

        <div class="services-grid">
            <div class="service-card animate-fade-in-up hover-lift stagger-1">
                <div class="icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
                <h3>Pembuatan Website</h3>
                <p>Dari landing page hingga e-commerce kompleks — desain responsif, cepat, interaktif, dan SEO-ready.</p>
            </div>
            <div class="service-card animate-fade-in-up hover-lift stagger-2">
                <div class="icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                </div>
                <h3>Aplikasi Android</h3>
                <p>Aplikasi mobile native dan cross-platform interaktif untuk memperluas jangkauan bisnis Anda tanpa batas.</p>
            </div>
            <div class="service-card animate-fade-in-up hover-lift stagger-3">
                <div class="icon-wrapper">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
                </div>
                <h3>UI/UX Professional</h3>
                <p>Desain visual yang indah sekaligus intuitif untuk memastikan pengalaman pengguna yang luar biasa.</p>
            </div>
        </div>
    </section>
@endsection
