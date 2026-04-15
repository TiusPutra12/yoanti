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
                                        <div class="client-meta">@{{ $order['user_username'] }}</div>
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
