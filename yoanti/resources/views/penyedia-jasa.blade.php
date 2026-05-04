@extends('layouts.app')
@section('title', 'Direktori Penyedia Jasa')

@push('styles')
    <style>
        /* Modern Variables Fallback */
        :root {
            --primary-fallback: #2563eb;
            --primary-hover: #1d4ed8;
            --wa-color: #25D366;
            --wa-hover: #1EBE5D;
            --surface-color: #ffffff;
            --bg-color: #F8FAFC;
        }

        .provider-page {
            padding: clamp(2rem, 6vw, 4rem) clamp(1rem, 5%, 2rem);
            background: var(--bg-color);
            min-height: calc(100dvh - var(--nav-height, 60px));
            font-family: 'Inter', system-ui, sans-serif;
        }

        .page-header {
            max-width: 800px;
            margin: 0 auto 3rem;
            text-align: center;
        }

        .page-header h1 {
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 800;
            color: var(--text-main, #0f172a);
            letter-spacing: -0.025em;
            margin-bottom: 0.75rem;
        }

        .page-header p {
            color: var(--text-muted, #64748b);
            font-size: clamp(1rem, 2vw, 1.15rem);
            line-height: 1.6;
        }

        .provider-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.75rem;
        }

        /* Card Styling */
        .provider-card {
            background: var(--surface-color);
            border-radius: var(--radius-lg, 16px);
            border: 1px solid var(--border, #e2e8f0);
            padding: 1.75rem 1.5rem 1.5rem;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.025);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Subtle top accent border */
        .provider-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary, var(--primary-fallback));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .provider-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .provider-card:hover::before {
            opacity: 1;
        }

        /* Avatar */
        .provider-avatar {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: var(--primary-light, #eff6ff);
            color: var(--primary, var(--primary-fallback));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 1.25rem;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 4px solid #fff;
            outline: 2px solid var(--primary-light, #eff6ff);
        }

        .provider-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-main, #1e293b);
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }

        .provider-profession {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--primary, var(--primary-fallback));
            margin-bottom: 1rem;
        }

        .provider-skills {
            font-size: 0.8rem;
            color: var(--text-muted, #475569);
            background: #F1F5F9;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            margin-bottom: 1.25rem;
            display: inline-block;
            word-break: break-word;
            border: 1px solid #e2e8f0;
        }

        /* Rating */
        .provider-rating {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            margin-bottom: 1.5rem;
            background: #fffbeb;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            color: #d97706;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .provider-rating svg {
            width: 18px;
            height: 18px;
            fill: #f59e0b;
        }

        .provider-rating span {
            color: var(--text-muted, #64748b);
            font-weight: 500;
            font-size: 0.85rem;
        }

        /* Buttons Action Group */
        .action-group {
            display: flex;
            gap: 0.75rem;
            width: 100%;
            margin-top: auto;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border, #f1f5f9);
        }

        .btn-primary,
        .btn-whatsapp {
            border-radius: var(--radius-sm, 8px);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-primary {
            flex: 1;
            padding: 0.75rem 1rem;
            background: var(--primary, var(--primary-fallback));
            color: white;
            font-size: 0.95rem;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .btn-whatsapp {
            flex: 0 0 auto;
            width: 44px;
            height: 44px;
            background: var(--wa-color);
            color: white;
        }

        .btn-whatsapp:hover {
            background: var(--wa-hover);
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
            transform: scale(1.05);
        }

        .btn-whatsapp svg {
            width: 20px;
            height: 20px;
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
            background: var(--surface-color);
            border-radius: var(--radius-lg, 16px);
            border: 2px dashed var(--border, #e2e8f0);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .empty-state svg {
            width: 64px;
            height: 64px;
            color: #cbd5e1;
        }

        .empty-state h3 {
            color: var(--text-main, #334155);
            font-size: 1.25rem;
            margin: 0;
        }

        .empty-state p {
            color: var(--text-muted, #64748b);
            margin: 0;
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .provider-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .provider-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem;
            }

            .provider-card {
                padding: 1.25rem 1rem 1rem;
            }

            .provider-avatar {
                width: 72px;
                height: 72px;
                font-size: 1.75rem;
            }

            .provider-name {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            .provider-grid {
                grid-template-columns: 1fr;
                max-width: 380px;
                /* Prevents cards from becoming too wide on mobile */
            }
        }
    </style>
@endpush

@section('content')
    <div class="provider-page">
        <div class="page-header">
            <h1>Direktori Penyedia Jasa</h1>
            <p>Temukan profesional terbaik yang siap membantu mewujudkan kebutuhan project digital Anda.</p>
        </div>

        <div class="provider-grid">
            @forelse($providers as $provider)
                <div class="provider-card">
                    <div class="provider-avatar" style="overflow: hidden; display: flex; align-items: center; justify-content: center;">
                        @if(isset($provider['avatar']) && $provider['avatar'])
                            <img src="{{ asset($provider['avatar']) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ strtoupper(substr($provider['name'], 0, 1)) }}
                        @endif
                    </div>

                    <h3 class="provider-name">{{ $provider['name'] }}</h3>
                    <div class="provider-profession">{{ $provider['profession'] ?? 'Penyedia Jasa' }}</div>

                    @if (!empty($provider['skills']) && $provider['skills'] !== '-')
                        <div class="provider-skills">{{ Str::limit($provider['skills'], 30) }}</div>
                    @endif

                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                        <div class="provider-rating">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                                </path>
                            </svg>
                            {{ $provider['average_rating'] > 0 ? $provider['average_rating'] : 'Baru' }}
                            @if ($provider['average_rating'] > 0)
                                <span>({{ $provider['review_count'] }})</span>
                            @endif
                        </div>
                        <div class="provider-sales" style="font-size: 0.8rem; font-weight: 700; color: #059669; background: #ECFDF5; padding: 0.25rem 0.6rem; border-radius: 6px; border: 1px solid #A7F3D0; display: flex; align-items: center; gap: 3px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                <path d="M3 6h18"></path>
                            </svg>
                            {{ $provider['sales_count'] ?? 0 }} Terjual
                        </div>
                    </div>

                    @php
                        $phone = $provider['phone_number'] ?? '';
                        $phone = preg_replace('/[^0-9]/', '', $phone);
                        $waLink = $phone
                            ? 'https://wa.me/' .
                                $phone .
                                '?text=' .
                                urlencode('Halo ' . $provider['name'] . ', saya melihat profil Anda di Yoanti.')
                            : '#';
                    @endphp

                    <div class="action-group">
                        <a href="{{ url('/penyedia-jasa/' . $provider['username']) }}" class="btn-primary">
                            Lihat Profil
                        </a>

                        <a href="{{ $waLink }}" class="btn-whatsapp" title="Hubungi via WhatsApp"
                            @if (!$phone) onclick="alert('Penyedia jasa belum mencantumkan nomor WhatsApp.'); return false;" @else target="_blank" @endif>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <h3>Belum ada penyedia jasa</h3>
                    <p>Coba kembali lagi nanti, para profesional sedang bersiap untuk bergabung!</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
