@extends('layouts.app')
@section('title', 'Katalog Produk')

@push('styles')
    <style>
        /* Fallback Variables */
        :root {
            --primary: #2563EB;
            --primary-light: #EFF6FF;
            --primary-hover: #1D4ED8;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --bg-body: #F8FAFC;
            --surface: #FFFFFF;
            --radius-md: 8px;
            --radius-lg: 12px;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --transition: all 0.25s ease;
        }

        body {
            background-color: var(--bg-body);
        }

        .page-header {
            text-align: center;
            padding: 2.5rem 1rem;
            background: linear-gradient(135deg, #EEF2FF 0%, #F8FAFC 100%);
            border-bottom: 1px solid var(--border);
        }

        .page-title {
            font-size: clamp(1.5rem, 4vw, 2.25rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .page-desc {
            color: var(--text-muted);
            font-size: 0.9rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.5;
        }

        .products-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        /* ── PRODUCT CARD ── */
        .product-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-sm);
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: #BFDBFE;
        }

        .product-image-wrapper {
            position: relative;
            width: 100%;
            padding-top: 55%;
            /* Ratio lebih pipih */
            background: #F1F5F9;
            overflow: hidden;
            border-bottom: 1px solid var(--border);
        }

        .product-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-content {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.35rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 1rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.75rem;
            display: inline-block;
            padding: 0.15rem 0.5rem;
            background: var(--primary-light);
            border-radius: 6px;
            width: fit-content;
        }

        .product-desc {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex: 1;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.75rem;
            border-top: 1px solid var(--border);
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
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .provider-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .product-date {
            font-size: 0.7rem;
            color: #94A3B8;
        }

        /* ── BUTTONS ── */
        .btn-action-group {
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn-review-link {
            width: 100%;
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--border);
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.5rem;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-review-link:hover {
            background: var(--bg-body);
            border-color: #CBD5E1;
            color: var(--primary);
        }

        .btn-primary-action {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.5rem;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-primary-action:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px dashed var(--border);
            max-width: 500px;
            margin: 0 auto;
        }

        .empty-state svg {
            color: #CBD5E1;
            margin-bottom: 1rem;
            width: 48px;
            height: 48px;
        }

        .empty-state h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* ── MODALS ── */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: var(--surface);
            width: 90%;
            max-width: 400px;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-lg);
            transform: translateY(20px) scale(0.98);
            transition: var(--transition);
        }

        .modal-overlay.active .modal-content {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .modal-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .close-modal,
        .btn-close-modal {
            background: var(--bg-body);
            border: 1px solid var(--border);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .close-modal:hover,
        .btn-close-modal:hover {
            background: #FEE2E2;
            color: #EF4444;
            border-color: #FECACA;
        }

        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.8rem;
            color: var(--text-main);
            margin-bottom: 0.4rem;
        }

        .form-textarea {
            width: 100%;
            min-height: 80px;
            padding: 0.75rem;
            font-size: 0.85rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            font-family: inherit;
            resize: vertical;
            transition: var(--transition);
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        /* ── REVIEWS MODAL SPECIFIC ── */
        .reviews-modal-content {
            padding: 0;
            max-width: 500px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .reviews-modal-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reviews-modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            flex: 1;
            background: var(--bg-body);
        }

        .review-item {
            background: var(--surface);
            padding: 1rem;
            border-radius: var(--radius-md);
            margin-bottom: 0.75rem;
            border: 1px solid var(--border);
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1 class="page-title">Katalog Produk</h1>
        <p class="page-desc">Jelajahi karya dan layanan digital dari penyedia jasa profesional kami.</p>
    </div>

    <div class="products-container">
        @if (count($products) > 0)
            <div class="products-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <img src="{{ asset($product['image']) }}" alt="{{ $product['title'] }}" class="product-image"
                                loading="lazy" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                        </div>
                        <div class="product-content">
                            <h3 class="product-title">{{ $product['title'] }}</h3>
                            <div class="product-price">{{ $product['price'] ?? 'Harga tidak tersedia' }}</div>
                            <p class="product-desc">{{ Str::limit($product['description'], 90) }}</p>

                            <div class="product-footer">
                                <div class="provider-info">
                                    <div class="provider-avatar">
                                        @if (isset($userAvatars[$product['username']]) && $userAvatars[$product['username']])
                                            <img src="{{ asset($userAvatars[$product['username']]) }}"
                                                alt="{{ $product['name'] }}"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            {{ strtoupper(substr($product['name'], 0, 1)) }}
                                        @endif
                                    </div>
                                    <div style="display: flex; flex-direction: column;">
                                        <span class="provider-name">{{ $product['name'] }}</span>
                                        @if (isset($product['average_rating']) && $product['average_rating'] > 0)
                                            <span
                                                style="color: #F59E0B; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.2rem;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                                    <path
                                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                                                    </path>
                                                </svg>
                                                {{ $product['average_rating'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="product-date">{{ explode(',', $product['created_at'])[0] ?? '' }}</span>
                            </div>

                            <div class="btn-action-group">
                                <button type="button"
                                    onclick="openReviewsModal('{{ $product['id'] }}', '{{ addslashes($product['title']) }}')"
                                    class="btn-review-link">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.3 8.38 8.38 0 0 1 3.8.9L21 3z">
                                        </path>
                                    </svg>
                                    Lihat Ulasan
                                </button>

                                @if (session()->has('user') && session('user')['role'] === 'job_seeker')
                                    <button type="button" class="btn-primary-action"
                                        onclick="openBuyModal('{{ $product['id'] }}', '{{ addslashes($product['title']) }}', '{{ $product['username'] }}', '{{ addslashes($product['price'] ?? '') }}')">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                            </path>
                                        </svg>
                                        Pesan
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
                <h3>Belum Ada Portofolio</h3>
                <p>Belum ada produk yang diunggah.</p>
            </div>
        @endif
    </div>

    <!-- Modal Pesan / Beli -->
    <div id="buyModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Pesan Layanan</h3>
                <button type="button" class="close-modal" onclick="closeBuyModal()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form action="{{ url('/produk/beli') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="modal_product_id">
                <input type="hidden" name="product_title" id="modal_product_title">
                <input type="hidden" name="provider_username" id="modal_provider_username">
                <input type="hidden" name="product_price" id="modal_product_price">

                <div
                    style="background: var(--primary-light); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.25rem; border: 1px solid #BFDBFE;">
                    <p style="font-size: 0.85rem; color: var(--text-main); margin: 0; line-height: 1.4;">
                        Memesan <strong id="modal_display_title"></strong><br>
                        Estimasi harga: <strong id="modal_display_price"
                            style="color: var(--primary); font-size: 1rem;"></strong>
                    </p>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                    <textarea name="order_notes" class="form-textarea" placeholder="Detail pesanan Anda..."></textarea>
                </div>

                <button type="submit" class="btn-primary-action" style="padding: 0.75rem;">Konfirmasi</button>
            </form>
        </div>
    </div>

    <!-- Modal Ulasan Produk -->
    <div id="reviewsModal" class="modal-overlay">
        <div class="modal-content reviews-modal-content">
            <div class="reviews-modal-header">
                <div>
                    <h3 id="modalProductTitle"
                        style="margin: 0; font-size: 1.1rem; font-weight: 700; color: var(--text-main);">Ulasan</h3>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0.2rem 0 0 0;">Testimoni klien</p>
                </div>
                <button type="button" class="btn-close-modal" onclick="closeReviewsModal()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
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
@endsection

@push('scripts')
    <script>
        const productReviews = @json($productReviews);
        const userAvatars = @json($userAvatars);

        function openReviewsModal(productId, productTitle) {
            const modal = document.getElementById('reviewsModal');
            const body = document.getElementById('modalReviewsBody');
            const title = document.getElementById('modalProductTitle');

            title.innerText = productTitle;
            body.innerHTML = '';

            const filteredReviews = productReviews.filter(r => r.product_id === productId);

            if (filteredReviews.length === 0) {
                body.innerHTML = `
                    <div class="empty-state" style="padding: 2rem 1rem; border: none; background: transparent;">
                        <p style="font-size: 0.9rem;">Belum ada ulasan untuk layanan ini.</p>
                    </div>`;
            } else {
                filteredReviews.forEach(review => {
                    const avatarPath = userAvatars[review.user_username] || review.user_avatar;
                    const stars = Array.from({
                        length: 5
                    }, (_, i) => {
                        const fill = (i + 1) <= review.rating ? '#F59E0B' : '#E2E8F0';
                        return `<svg width="14" height="14" viewBox="0 0 24 24" fill="${fill}"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>`;
                    }).join('');

                    body.innerHTML += `
                        <div class="review-item">
                            <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                                <div style="width: 32px; height: 32px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: var(--primary-light); color: var(--primary); flex-shrink: 0; border-radius: 50%; font-weight: bold; font-size: 0.8rem;">
                                    ${avatarPath ? `<img src="/${avatarPath}" style="width: 100%; height: 100%; object-fit: cover;">` : review.user_name.charAt(0).toUpperCase()}
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.2rem;">
                                        <span style="font-weight: 600; color: var(--text-main); font-size: 0.85rem;">${review.user_name}</span>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">${review.created_at}</span>
                                    </div>
                                    <div style="display: flex; gap: 2px; margin-bottom: 0.5rem;">${stars}</div>
                                    <div style="font-size: 0.85rem; color: var(--text-main); line-height: 1.5;">${review.comment}</div>
                                </div>
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
            document.body.style.overflow = 'hidden';
        }

        function closeBuyModal() {
            document.getElementById('buyModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        window.addEventListener('click', function(e) {
            const buyModal = document.getElementById('buyModal');
            const reviewsModal = document.getElementById('reviewsModal');

            if (e.target === buyModal) {
                closeBuyModal();
            } else if (e.target === reviewsModal) {
                closeReviewsModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeBuyModal();
                closeReviewsModal();
            }
        });
    </script>
@endpush
