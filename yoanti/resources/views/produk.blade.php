@extends('layouts.app')
@section('title', 'Katalog Produk')

@push('styles')
    <style>
        .page-header {
            text-align: center;
            padding: clamp(3rem, 6vw, 5rem) clamp(1rem, 5%, 2rem);
            background: linear-gradient(160deg, #EFF6FF 0%, #F8FAFC 100%);
            border-bottom: 1px solid var(--border);
        }

        .page-title {
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.75rem;
        }

        .page-desc {
            color: var(--text-muted);
            font-size: clamp(0.95rem, 2vw, 1.1rem);
            max-width: 600px;
            margin: 0 auto;
        }

        .products-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: clamp(2rem, 5vw, 4rem) clamp(1rem, 5%, 2rem);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: #fff;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(37, 99, 235, 0.3);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid var(--border);
            background: #F1F5F9;
        }

        .product-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.25rem;
            line-height: 1.4;
        }

        .product-price {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.75rem;
        }

        .product-desc {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.25rem;
            flex: 1;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px dashed var(--border);
            margin-top: auto;
        }

        .provider-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .provider-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
        }

        .provider-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .product-date {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            background: #fff;
            border-radius: var(--radius-md);
            border: 1px dashed var(--border);
        }

        .empty-state svg {
            color: var(--text-muted);
            opacity: 0.5;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* ── MODAL ── */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            background: #fff;
            width: 90%;
            max-width: 450px;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-lg);
            transform: translateY(20px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .modal-overlay.active .modal-content {
            transform: translateY(0) scale(1);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .modal-header h3 {
            font-size: 1.2rem;
            font-weight: 800;
        }
        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: color 0.2s;
        }
        .close-modal:hover {
            color: var(--error);
        }
        .btn-review-link:hover {
            background: #EFF6FF;
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        /* Modal Ulasan */
        .reviews-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reviews-modal.active {
            display: flex;
            animation: fadeIn 0.3s ease-out;
        }

        .reviews-modal-content {
            background: #fff;
            width: 100%;
            max-width: 600px;
            max-height: 80vh;
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .reviews-modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #F1F5F9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #F8FAFC;
        }

        .reviews-modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .btn-close-modal {
            background: #fff;
            border: 1px solid #E2E8F0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #64748B;
            transition: all 0.2s;
        }

        .btn-close-modal:hover {
            background: #F1F5F9;
            color: var(--primary);
            transform: rotate(90deg);
        }

        .reviews-modal-body {
            padding: 1.5rem 2rem;
            overflow-y: auto;
            flex: 1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1 class="page-title">Katalog Portofolio</h1>
        <p class="page-desc">Jelajahi berbagai karya dan layanan digital terbaik dari penyedia jasa profesional kami.</p>
    </div>

    <div class="products-container">
        @if(count($products) > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <img src="{{ asset($product['image']) }}" alt="{{ $product['title'] }}" class="product-image" loading="lazy" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                        <div class="product-content">
                            <h3 class="product-title">{{ $product['title'] }}</h3>
                            <div class="product-price">{{ $product['price'] ?? 'Harga tidak tersedia' }}</div>
                            <p class="product-desc">{{ Str::limit($product['description'], 100) }}</p>
                            
                            <div class="product-footer">
                                <div class="provider-info">
                                    <div class="provider-avatar">
                                        {{ strtoupper(substr($product['name'], 0, 1)) }}
                                    </div>
                                    <div style="display: flex; flex-direction: column;">
                                        <span class="provider-name">{{ $product['name'] }}</span>
                                        @if(isset($product['average_rating']) && $product['average_rating'] > 0)
                                            <span style="color: #F59E0B; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.15rem;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                                {{ $product['average_rating'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="product-date">{{ explode(',', $product['created_at'])[0] ?? '' }}</span>
                            </div>

                            <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                                <button type="button" onclick="openReviewsModal('{{ $product['id'] }}', '{{ addslashes($product['title']) }}')" class="btn-review-link" style="width: 100%; border: 1px solid var(--primary); background: transparent; color: var(--primary); font-size: 0.85rem; font-weight: 600; padding: 0.6rem; border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                                    Lihat Ulasan
                                </button>
                                
                                @if(session()->has('user') && session('user')['role'] === 'job_seeker')
                                    <button type="button" class="btn-primary" style="width: 100%; border-radius: 8px; padding: 0.6rem;" onclick="openBuyModal('{{ $product['id'] }}', '{{ addslashes($product['title']) }}', '{{ $product['username'] }}', '{{ addslashes($product['price'] ?? '') }}')">
                                        Pesan Layanan Ini
                                    </button>
                                @endif
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
                <p>Saat ini belum ada portofolio produk yang diunggah oleh penyedia jasa.</p>
            </div>
        @endif
    </div>

    <!-- Modal Pesan / Beli -->
    <div id="buyModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Pesan Produk/Layanan</h3>
                <button type="button" class="close-modal" onclick="closeBuyModal()">&times;</button>
            </div>
            <form action="{{ url('/produk/beli') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="modal_product_id">
                <input type="hidden" name="product_title" id="modal_product_title">
                <input type="hidden" name="provider_username" id="modal_provider_username">
                <input type="hidden" name="product_price" id="modal_product_price">
                
                <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">
                    Anda akan memesan <strong id="modal_display_title" style="color: var(--text-main);"></strong> seharga <strong id="modal_display_price" style="color: var(--primary);"></strong>.
                </p>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.5rem;">Catatan Tambahan (Opsional)</label>
                    <textarea name="order_notes" style="width: 100%; min-height: 80px; padding: 0.75rem; border: 1.5px solid var(--border); border-radius: 8px; font-family: 'Inter', sans-serif; resize: vertical;" placeholder="Jelaskan spesifikasi atau kebutuhan khusus Anda..."></textarea>
                </div>
                
                <button type="submit" class="btn-primary" style="width: 100%; border-radius: 8px; padding: 0.75rem; justify-content: center;">Konfirmasi Pesanan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Modal Ulasan Produk -->
    <div id="reviewsModal" class="reviews-modal">
        <div class="reviews-modal-content">
            <div class="reviews-modal-header">
                <div>
                    <h3 id="modalProductTitle">Ulasan Produk</h3>
                    <p style="font-size: 0.8rem; color: #64748B; margin: 0.2rem 0 0 0;">Daftar testimoni untuk layanan ini</p>
                </div>
                <button type="button" class="btn-close-modal" onclick="closeReviewsModal()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="reviews-modal-body" id="modalReviewsBody">
                <!-- Content populated by JS -->
            </div>
        </div>
    </div>

    <script>
        // Data ulasan produk untuk JS
        const productReviews = @json($productReviews);
        const userAvatars = @json($userAvatars);

        function openReviewsModal(productId, productTitle) {
            const modal = document.getElementById('reviewsModal');
            const body = document.getElementById('modalReviewsBody');
            const title = document.getElementById('modalProductTitle');
            
            title.innerText = 'Ulasan: ' + productTitle;
            body.innerHTML = '';

            const filteredReviews = productReviews.filter(r => r.product_id === productId);

            if (filteredReviews.length === 0) {
                body.innerHTML = `<div style="text-align: center; padding: 3rem 1rem; color: #94A3B8;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 1rem; opacity: 0.5;">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.3 8.38 8.38 0 0 1 3.8.9L21 3z"></path>
                    </svg>
                    <p>Belum ada ulasan untuk layanan ini.</p>
                </div>`;
            } else {
                filteredReviews.forEach(review => {
                    const avatarPath = userAvatars[review.user_username] || review.user_avatar;
                    const stars = Array.from({length: 5}, (_, i) => {
                        const fill = (i + 1) <= review.rating ? '#F59E0B' : '#E2E8F0';
                        return `<svg width="14" height="14" viewBox="0 0 24 24" fill="${fill}"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>`;
                    }).join('');

                    body.innerHTML += `
                        <div style="margin-bottom: 1.5rem; border-bottom: 1px solid #F1F5F9; padding-bottom: 1rem; display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="width: 40px; height: 40px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #F1F5F9; color: var(--primary); flex-shrink: 0; border-radius: 50%;">
                                ${avatarPath ? `<img src="/${avatarPath}" style="width: 100%; height: 100%; object-fit: cover;">` : review.user_name.charAt(0).toUpperCase()}
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.2rem;">
                                    <span style="font-weight: 700; color: #1E293B;">${review.user_name}</span>
                                    <span style="font-size: 0.75rem; color: #94A3B8;">${review.created_at}</span>
                                </div>
                                <div style="display: flex; gap: 2px; margin-bottom: 0.5rem;">${stars}</div>
                                <div style="font-size: 0.9rem; color: #475569; line-height: 1.5;">${review.comment}</div>
                            </div>
                        </div>
                    `;
                });
            }

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeReviewsModal() {
            document.getElementById('reviewsModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function openBuyModal(id, title, provider, price) {
            document.getElementById('modal_product_id').value = id;
            document.getElementById('modal_product_title').value = title;
            document.getElementById('modal_provider_username').value = provider;
            document.getElementById('modal_product_price').value = price;
            document.getElementById('modal_display_title').textContent = title;
            document.getElementById('modal_display_price').textContent = price;
            document.getElementById('buyModal').classList.add('active');
        }
        
        function closeBuyModal() {
            document.getElementById('buyModal').classList.remove('active');
        }
        
        // Close modal jika klik di luar box
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('buyModal');
            if (e.target === modal) {
                closeBuyModal();
            }
        });
    </script>
@endpush
