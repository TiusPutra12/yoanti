@extends('layouts.app')
@section('title', 'Dashboard Penyedia Jasa')

@push('styles')
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: clamp(2rem, 5vw, 4rem) clamp(1rem, 5%, 2rem);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .dashboard-title-area h1 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .dashboard-title-area p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .btn-add {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.25rem;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            border: none;
            font-size: 0.95rem;
        }

        .btn-add:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background: #fff;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.2s;
        }

        .product-card:hover {
            box-shadow: var(--shadow-md);
        }

        .product-img-wrapper {
            position: relative;
            width: 100%;
            height: 180px;
            background: #F1F5F9;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-actions {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            display: flex;
            gap: 0.5rem;
        }

        .btn-delete {
            background: rgba(255, 255, 255, 0.9);
            color: #DC2626;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-delete:hover {
            background: #FEE2E2;
            transform: scale(1.05);
        }

        .product-info {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.25rem;
        }

        .product-price {
            font-size: 1rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .product-desc {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.5;
            flex: 1;
            margin-bottom: 1rem;
        }

        .product-meta {
            font-size: 0.75rem;
            color: #94A3B8;
            border-top: 1px dashed var(--border);
            padding-top: 0.75rem;
            display: flex;
            justify-content: space-between;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            background: #F8FAFC;
            border-radius: var(--radius-md);
            border: 1.5px dashed var(--border);
        }

        .empty-state svg {
            color: #CBD5E1;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="dashboard-title-area">
                <h1>Dashboard Portofolio</h1>
                <p>Kelola portofolio layanan dan produk yang Anda tawarkan.</p>
            </div>
            <a href="{{ url('/penyedia/produk/create') }}" class="btn-add">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Portofolio
            </a>
        </div>

        @if(count($myProducts) > 0)
            <div class="products-grid">
                @foreach($myProducts as $p)
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <img src="{{ asset($p['image']) }}" alt="{{ $p['title'] }}" class="product-img" loading="lazy" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                            
                            <div class="product-actions">
                                <form action="{{ url('/penyedia/produk/delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $p['id'] }}">
                                    <button type="submit" class="btn-delete" title="Hapus Portofolio">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-title">{{ $p['title'] }}</h3>
                            <div class="product-price">{{ $p['price'] ?? 'Harga tidak tersedia' }}</div>
                            <p class="product-desc">{{ Str::limit($p['description'], 120) }}</p>
                            <div class="product-meta">
                                <span>Diunggah pada</span>
                                <span>{{ explode(',', $p['created_at'])[0] ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
                <h3>Belum Ada Portofolio</h3>
                <p>Mulai tunjukkan karya terbaik Anda kepada klien potensial.</p>
                <a href="{{ url('/penyedia/produk/create') }}" class="btn-add" style="box-shadow: none;">Tambah Portofolio Pertama</a>
            </div>
        @endif
    </div>
@endsection
