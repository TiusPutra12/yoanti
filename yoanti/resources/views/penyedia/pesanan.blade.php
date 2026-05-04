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

                                @php $phone = $userPhones[$order['user_username']] ?? null; @endphp
                                @if($phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phone) }}?text=Halo%20{{ urlencode($order['name']) }},%20saya%20Penyedia%20Jasa%20di%20Yoanti%20ingin%20mengonfirmasi%20pesanan%20Anda%20#{{ $order['id'] }}" 
                                       target="_blank" 
                                       class="btn-action" 
                                       style="background: #25D366; color: white; text-decoration: none; margin-top: 0.5rem;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                        Hubungi Klien
                                    </a>
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
