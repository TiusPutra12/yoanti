@extends('layouts.app')
@section('title', 'Dashboard Penyedia Jasa')

@push('styles')
    <style>
        .dashboard-page {
            background: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.9)), url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: calc(100dvh - var(--nav-height));
        }

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

        .btn-kebab {
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-main);
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

        .btn-kebab:hover {
            background: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            min-width: 140px;
            z-index: 20;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.75rem 1rem;
            border: none;
            background: none;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
            text-align: left;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
            font-family: inherit;
        }

        .dropdown-item:hover {
            background: #F8FAFC;
            color: var(--primary);
        }

        .dropdown-item.text-danger {
            color: #DC2626;
        }

        .dropdown-item.text-danger:hover {
            background: #FEF2F2;
            color: #B91C1C;
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
    <div class="dashboard-page">
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
                                <div class="dropdown-wrapper" style="position: relative;">
                                    <button class="btn-kebab" onclick="toggleDropdown('dropdown-{{ $p['id'] }}')">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="12" cy="5" r="1"></circle>
                                            <circle cx="12" cy="19" r="1"></circle>
                                        </svg>
                                    </button>
                                    <div id="dropdown-{{ $p['id'] }}" class="dropdown-menu">
                                        <a href="{{ url('/penyedia/produk/edit/' . $p['id']) }}" class="dropdown-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ url('/penyedia/produk/delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" style="margin: 0;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $p['id'] }}">
                                            <button type="submit" class="dropdown-item text-danger">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
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
    </div>
@endsection

@push('scripts')
    <script>
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            const isShowing = el.classList.contains('show');
            
            // Close all dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });

            if (!isShowing) {
                el.classList.add('show');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown-wrapper')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
    </script>
@endpush
