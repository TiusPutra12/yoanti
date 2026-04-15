@extends('layouts.app')
@section('title', 'Pesanan Saya')

@push('styles')
    <style>
        .pesanan-page {
            padding: clamp(2rem, 6vw, 4rem) clamp(1rem, 5%, 2rem);
            background: #F8FAFC;
            min-height: calc(100dvh - var(--nav-height));
        }

        .page-header {
            max-width: 1000px;
            margin: 0 auto 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-header h1 {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .page-header .total-badge {
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid rgba(37,99,235,0.2);
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .orders-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Desktop table */
        .table-wrapper {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 1rem 1.25rem;
            background: #F8FAFC;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        tbody td {
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid #F1F5F9;
            font-size: 0.9rem;
            color: var(--text-main);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }

        tbody tr { transition: background 0.15s; }
        tbody tr:hover { background: #F8FAFC; }

        .order-id {
            font-weight: 700;
            color: var(--primary);
            font-size: 0.85rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-pending  { background: #FFFBEB; color: #D97706; border: 1px solid #FEF3C7; }
        .status-pending::before  { background: #F59E0B; }

        .status-proses   { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
        .status-proses::before   { background: #3B82F6; }

        .status-selesai  { background: #ECFDF5; color: #059669; border: 1px solid #D1FAE5; }
        .status-selesai::before  { background: #10B981; }

        .status-ditolak, .status-gagal { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .status-ditolak::before, .status-gagal::before { background: #EF4444; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: clamp(3rem, 8vw, 5rem) 1.5rem;
            color: var(--text-muted);
        }

        .empty-state svg { margin-bottom: 1rem; opacity: 0.4; }
        .empty-state h3 { font-size: 1.1rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem; }
        .empty-state p  { font-size: 0.875rem; margin-bottom: 1.5rem; }

        /* Mobile: cards */
        @media (max-width: 640px) {
            .table-wrapper {
                background: transparent;
                border: none;
                box-shadow: none;
            }

            thead { display: none; }

            tbody tr {
                display: block;
                background: #fff;
                border-radius: 16px;
                margin-bottom: 1rem;
                border: 1px solid var(--border);
                box-shadow: var(--shadow-sm);
                overflow: hidden;
            }

            tbody tr:hover { background: #fff; }

            tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid #F1F5F9 !important;
                padding: 0.8rem 1.1rem;
                font-size: 0.875rem;
            }

            tbody td:last-child { border-bottom: none !important; }

            tbody td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--text-muted);
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.03em;
                flex-shrink: 0;
                margin-right: 0.75rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="pesanan-page">
        <div class="page-header">
            <h1>Pesanan Saya</h1>
            @if (count($myOrders ?? []) > 0)
                <span class="total-badge">{{ count($myOrders) }} Pesanan</span>
            @endif
        </div>

        <div class="orders-container">
            <div class="table-wrapper">
                @if (count($myOrders ?? []) > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Layanan</th>
                                <th>Instansi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($myOrders as $order)
                                <tr>
                                    <td data-label="ID" class="order-id">#{{ $order['id'] }}</td>
                                    <td data-label="Layanan"><strong>{{ $order['programType'] }}</strong></td>
                                    <td data-label="Instansi" style="color: var(--text-muted);">{{ $order['company'] ?? '-' }}</td>
                                    <td data-label="Status">
                                        <span class="status-badge status-{{ strtolower($order['status']) }}">
                                            {{ $order['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                            <path d="M3 6h18" />
                            <path d="M16 10a4 4 0 0 1-8 0" />
                        </svg>
                        <h3>Belum ada pesanan</h3>
                        <p>Mulai konsultasi project pertama Anda bersama kami.</p>
                        <a href="{{ url('/pesan') }}" class="btn-primary"
                            style="padding: 0.75rem 1.75rem; border-radius: 12px; font-size: 0.9rem;">
                            Buat Pesanan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
