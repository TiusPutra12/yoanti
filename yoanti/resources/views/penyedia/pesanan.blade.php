@extends('layouts.app')
@section('title', 'Pesanan Masuk')

@push('styles')
    <style>
        .orders-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: clamp(2rem, 5vw, 4rem) clamp(1rem, 5%, 2rem);
        }

        .orders-header {
            margin-bottom: 2.5rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 1.5rem;
        }

        .orders-header h1 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .orders-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .orders-grid {
            display: grid;
            gap: 1.5rem;
        }

        .order-card {
            background: #fff;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            padding: 1.5rem;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1.5rem;
            transition: all 0.2s;
        }

        .order-card:hover {
            box-shadow: var(--shadow-md);
        }

        .order-info h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .order-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .order-meta span {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .order-meta svg {
            color: var(--primary);
        }

        .order-notes {
            background: #F8FAFC;
            padding: 1rem;
            border-radius: var(--radius-sm);
            border: 1px dashed var(--border);
            font-size: 0.9rem;
            color: var(--text-main);
            line-height: 1.5;
        }

        .order-notes strong {
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .order-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            min-width: 140px;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            text-align: center;
        }

        .status-pending {
            background: #FEF3C7;
            color: #D97706;
        }

        .status-diterima {
            background: #D1FAE5;
            color: #059669;
        }

        .status-ditolak {
            background: #FEE2E2;
            color: #DC2626;
        }

        .btn-action {
            width: 100%;
            padding: 0.6rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
        }

        .btn-accept {
            background: #10B981;
            color: white;
        }
        .btn-accept:hover { background: #059669; transform: translateY(-1px); }

        .btn-reject {
            background: #EF4444;
            color: white;
        }
        .btn-reject:hover { background: #DC2626; transform: translateY(-1px); }

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
        }

        @media (max-width: 768px) {
            .order-card {
                grid-template-columns: 1fr;
            }
            .order-actions {
                flex-direction: row;
                border-top: 1px dashed var(--border);
                padding-top: 1rem;
            }
            .status-badge {
                flex: 1;
            }
            .order-actions form {
                flex: 1;
            }
        }
    </style>
@endpush

@section('content')
    <div class="orders-container">
        <div class="orders-header">
            <h1>Pesanan Masuk</h1>
            <p>Kelola pesanan klien yang tertarik dengan produk portofolio Anda.</p>
        </div>

        @if(session('success'))
            <div style="background: #ECFDF5; color: #059669; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; border: 1px solid #A7F3D0;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #FEF2F2; color: #DC2626; padding: 1rem; border-radius: var(--radius-sm); margin-bottom: 1.5rem; border: 1px solid #FECACA;">
                {{ session('error') }}
            </div>
        @endif

        @if(count($myOrders) > 0)
            <div class="orders-grid">
                @foreach($myOrders as $order)
                    <div class="order-card">
                        <div class="order-info">
                            <h3>{{ $order['programType'] }}</h3>
                            
                            <div class="order-meta">
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    {{ $order['name'] }}
                                </span>
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    {{ $order['created_at'] }}
                                </span>
                                <span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    ID: {{ $order['id'] }}
                                </span>
                            </div>

                            <div class="order-notes">
                                <strong>Catatan Klien:</strong>
                                {{ $order['description'] }}
                            </div>
                        </div>

                        <div class="order-actions">
                            @if(strtolower($order['status']) === 'pending')
                                <div class="status-badge status-pending" style="margin-bottom: 0.5rem;">Menunggu Respons</div>
                                
                                <form action="{{ url('/penyedia/pesanan/status') }}" method="POST" onsubmit="return confirm('Anda yakin ingin menerima pesanan ini?');" style="display: block;">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                    <input type="hidden" name="status" value="Diterima">
                                    <button type="submit" class="btn-action btn-accept">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        Terima
                                    </button>
                                </form>

                                <form action="{{ url('/penyedia/pesanan/status') }}" method="POST" onsubmit="return confirm('Anda yakin ingin menolak pesanan ini?');" style="display: block;">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                    <input type="hidden" name="status" value="Ditolak">
                                    <button type="submit" class="btn-action btn-reject">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        Tolak
                                    </button>
                                </form>
                            @else
                                @if(strtolower($order['status']) === 'diterima')
                                    <div class="status-badge status-diterima">Telah Diterima</div>
                                @elseif(strtolower($order['status']) === 'ditolak')
                                    <div class="status-badge status-ditolak">Telah Ditolak</div>
                                @else
                                    <div class="status-badge status-pending">{{ ucfirst($order['status']) }}</div>
                                @endif
                                
                                <p style="font-size: 0.75rem; color: var(--text-muted); text-align: center; margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px dashed var(--border);">
                                    Status Final
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                <h3>Belum Ada Pesanan</h3>
                <p>Belum ada klien yang memesan layanan portofolio Anda.</p>
            </div>
        @endif
    </div>
@endsection
