@extends('layouts.app')
@section('title', 'Admin - Permintaan')

@push('styles')
    <style>
        .admin-page {
            padding: clamp(1.5rem, 4vw, 3rem) clamp(1rem, 5%, 2rem);
            background: var(--bg);
            min-height: calc(100dvh - var(--nav-height));
        }

        .admin-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .admin-page-header h1 {
            font-size: clamp(1.4rem, 3vw, 1.75rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .count-pill {
            background: #ECFDF5;
            color: #059669;
            border: 1px solid #D1FAE5;
            padding: 0.35rem 0.9rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .admin-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        /* Desktop Table */
        .table-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        thead th {
            padding: 0.9rem 1.25rem;
            background: #F8FAFC;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: left;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        tbody td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: top;
            font-size: 0.875rem;
            color: var(--text-main);
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr { transition: background 0.15s; }
        tbody tr:hover { background: #F8FAFC; }

        .client-name { font-weight: 700; font-size: 0.9rem; }
        .client-meta { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.15rem; }

        .service-name { font-weight: 600; }
        .service-budget { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.2rem; }

        .desc-cell {
            max-width: 200px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
            font-size: 0.83rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        .status-badge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .status-pending  { background: #FFFBEB; color: #D97706; border: 1px solid #FEF3C7; }
        .status-pending::before  { background: #F59E0B; }
        .status-proses   { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
        .status-proses::before   { background: #3B82F6; }
        .status-selesai  { background: #ECFDF5; color: #059669; border: 1px solid #D1FAE5; }
        .status-selesai::before  { background: #10B981; }
        .status-gagal, .status-ditolak { background: #FEF2F2; color: #DC2626; border: 1px solid #FEE2E2; }
        .status-gagal::before, .status-ditolak::before { background: #EF4444; }

        .actions-cell { white-space: nowrap; }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.9rem;
            border-radius: 9px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
            margin: 0.15rem;
        }

        .btn-acc     { background: var(--primary); color: #fff; border-color: var(--primary); }
        .btn-acc:hover { background: var(--primary-hover); box-shadow: 0 4px 12px rgba(37,99,235,0.3); }

        .btn-tolak   { background: #fff; color: #DC2626; border-color: #DC2626; }
        .btn-tolak:hover { background: #FEF2F2; }

        .btn-selesai { background: #10B981; color: #fff; border-color: #10B981; }
        .btn-selesai:hover { background: #059669; box-shadow: 0 4px 12px rgba(16,185,129,0.3); }

        .btn-gagal   { background: #fff; color: var(--text-muted); border-color: var(--border); }
        .btn-gagal:hover { background: #F8FAFC; color: var(--text-main); border-color: #94A3B8; }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: clamp(3rem, 8vw, 5rem) 1.5rem;
            color: var(--text-muted);
        }
        .empty-state svg { margin-bottom: 1rem; opacity: 0.4; }
        .empty-state p { font-size: 0.9rem; }

        /* Mobile Cards */
        @media (max-width: 768px) {
            .table-scroll { overflow: visible; }

            table, thead, tbody, tr, th, td { display: block; }

            thead { display: none; }

            table { min-width: unset; }

            tbody tr {
                background: #fff;
                border-radius: 16px;
                margin-bottom: 1rem;
                border: 1px solid var(--border);
                box-shadow: var(--shadow-sm);
                padding: 1.1rem;
                overflow: hidden;
            }

            tbody tr:hover { background: #fff; }

            tbody td {
                padding: 0.55rem 0;
                border-bottom: 1px solid #F1F5F9;
                font-size: 0.875rem;
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 0.5rem;
            }

            tbody td:last-child { border-bottom: none; padding-top: 0.9rem; }

            tbody td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--text-muted);
                font-size: 0.72rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                flex-shrink: 0;
                min-width: 80px;
            }

            .desc-cell { max-width: 160px; }

            .actions-cell {
                display: flex !important;
                flex-direction: row;
                flex-wrap: wrap;
                gap: 0.4rem;
            }

            .actions-cell::before { display: none; }
        }
    </style>
@endpush

@section('content')
    <div class="admin-page">
        <div class="admin-page-header">
            <h1>Manajemen Permintaan</h1>
            @if(count($orders ?? []) > 0)
                <span class="count-pill">{{ count($orders) }} permintaan</span>
            @endif
        </div>

        <div class="admin-card">
            @if(count($orders ?? []) > 0)
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>ID & Tanggal</th>
                                <th>Klien</th>
                                <th>Layanan & Budget</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td data-label="ID">
                                        <div style="font-weight: 700; color: var(--primary); font-size: 0.85rem;">#{{ $order['id'] }}</div>
                                        <div class="client-meta">{{ $order['created_at'] ?? '' }}</div>
                                    </td>
                                    <td data-label="Klien">
                                        <div class="client-name">{{ $order['name'] }}</div>
                                        <div class="client-meta">{{ '@' . $order['user_username'] }}</div>
                                        <div class="client-meta">{{ $order['company'] }}</div>
                                    </td>
                                    <td data-label="Layanan">
                                        <div class="service-name">{{ $order['programType'] }}</div>
                                        <div class="service-budget">{{ $order['budget'] }}</div>
                                    </td>
                                    <td data-label="Detail">
                                        <div class="desc-cell">{{ $order['description'] }}</div>
                                    </td>
                                    <td data-label="Status">
                                        <span class="status-badge status-{{ strtolower($order['status']) }}">
                                            {{ $order['status'] }}
                                        </span>
                                    </td>
                                    <td data-label="Aksi" class="actions-cell">
                                        @php $phone = $userPhones[$order['user_username']] ?? null; @endphp
                                        @if($phone)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phone) }}?text=Halo%20{{ urlencode($order['name']) }},%20saya%20Admin%20Yoanti%20ingin%20mengonfirmasi%20pesanan%20#{{ $order['id'] }}" 
                                               target="_blank" 
                                               class="action-btn" 
                                               style="background: #25D366; color: #fff; border-color: #25D366; text-decoration: none;">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                Hubungi Klien
                                            </a>
                                        @else
                                            <button type="button" class="action-btn" onclick="alert('Maaf, user ini belum mencantumkan nomor WhatsApp di profilnya.')" style="background: #F1F5F9; color: #94A3B8; border-color: #E2E8F0; cursor: not-allowed;">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="opacity: 0.5;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                Hubungi Klien
                                            </button>
                                        @endif

                                        @if($order['status'] === 'pending')
                                            <form action="{{ url('/admin/permintaan/status') }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                                <input type="hidden" name="status" value="proses">
                                                <button type="submit" class="action-btn btn-acc">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    Terima
                                                </button>
                                            </form>
                                            <form action="{{ url('/admin/permintaan/status') }}" method="POST" style="display:inline;" onsubmit="return confirm('Tolak permintaan ini?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                                <input type="hidden" name="status" value="ditolak">
                                                <button type="submit" class="action-btn btn-tolak">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    Tolak
                                                </button>
                                            </form>
                                        @elseif($order['status'] === 'proses')
                                            <form action="{{ url('/admin/permintaan/status') }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit" class="action-btn btn-selesai">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    Selesai
                                                </button>
                                            </form>
                                            <form action="{{ url('/admin/permintaan/status') }}" method="POST" style="display:inline;" onsubmit="return confirm('Tandai sebagai gagal?');">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                                <input type="hidden" name="status" value="gagal">
                                                <button type="submit" class="action-btn btn-gagal">Gagal</button>
                                            </form>
                                        @else
                                            <span style="font-size: 0.8rem; color: #CBD5E1; font-style: italic;">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="3" rx="2"/>
                        <path d="M7 7h10"/><path d="M7 12h10"/><path d="M7 17h10"/>
                    </svg>
                    <p>Belum ada permintaan yang masuk.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
