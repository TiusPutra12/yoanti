@extends('layouts.app')
@section('title', 'Super Admin - Pesanan')

@push('styles')
    <style>
        .sa-page {
            padding: clamp(1.5rem, 4vw, 3rem) clamp(1rem, 5%, 2rem);
            background: var(--bg);
            min-height: calc(100dvh - var(--nav-height));
        }

        .sa-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .sa-page-header h1 {
            font-size: clamp(1.4rem, 3vw, 1.75rem);
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
        }

        .sa-page-header p {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-top: 0.2rem;
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

        .sa-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 520px;
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
        }

        tbody td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #F1F5F9;
            font-size: 0.875rem;
            color: var(--text-main);
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr {
            transition: background 0.15s;
        }

        tbody tr:hover {
            background: #F8FAFC;
        }

        .order-id {
            font-weight: 700;
            color: var(--primary);
            font-size: 0.85rem;
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
        }

        .status-badge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .status-pending {
            background: #FFFBEB;
            color: #D97706;
            border: 1px solid #FEF3C7;
        }

        .status-pending::before {
            background: #F59E0B;
        }

        .status-proses {
            background: #EFF6FF;
            color: #2563EB;
            border: 1px solid #DBEAFE;
        }

        .status-proses::before {
            background: #3B82F6;
        }

        .status-selesai {
            background: #ECFDF5;
            color: #059669;
            border: 1px solid #D1FAE5;
        }

        .status-selesai::before {
            background: #10B981;
        }

        .status-ditolak,
        .status-gagal {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FEE2E2;
        }

        .status-ditolak::before,
        .status-gagal::before {
            background: #EF4444;
        }

        .btn-delete {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: #FEF2F2;
            color: #EF4444;
            border: 1px solid #FECACA;
            padding: 0.4rem 0.85rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.78rem;
            font-weight: 700;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .btn-delete:hover {
            background: #FEE2E2;
            border-color: #EF4444;
            transform: scale(1.03);
        }

        /* Empty */
        .empty-state {
            text-align: center;
            padding: clamp(3rem, 8vw, 5rem) 1.5rem;
            color: var(--text-muted);
        }

        .empty-state svg {
            margin-bottom: 1rem;
            opacity: 0.4;
        }

        .empty-state p {
            font-size: 0.9rem;
        }

        /* Mobile */
        @media (max-width: 640px) {
            .table-scroll {
                overflow: visible;
            }

            table,
            thead,
            tbody,
            tr,
            th,
            td {
                display: block;
            }

            thead {
                display: none;
            }

            table {
                min-width: unset;
            }

            tbody tr {
                background: #fff;
                border-radius: 16px;
                margin-bottom: 1rem;
                border: 1px solid var(--border);
                box-shadow: var(--shadow-sm);
                padding: 1.1rem;
            }

            tbody tr:hover {
                background: #fff;
            }

            tbody td {
                padding: 0.55rem 0;
                border-bottom: 1px solid #F1F5F9;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.875rem;
            }

            tbody td:last-child {
                border-bottom: none;
                padding-top: 0.75rem;
                justify-content: flex-end;
            }

            tbody td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--text-muted);
                font-size: 0.72rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                flex-shrink: 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="sa-page">
        <div class="sa-page-header">
            <div>
                <h1>Manajemen Pesanan</h1>
                <p>Pantau dan hapus riwayat pesanan klien</p>
            </div>
            @if (count($orders ?? []) > 0)
                <span class="count-pill">{{ count($orders) }} pesanan</span>
            @endif
        </div>

        <div class="sa-card">
            @if (count($orders ?? []) > 0)
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>ID & Tanggal</th>
                                <th>Klien</th>
                                <th>Layanan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (array_reverse($orders) as $order)
                                <tr>
                                    <td data-label="Pesanan">
                                        <span class="order-id">#{{ $order['id'] }}</span>
                                        <small
                                            style="color: #94A3B8; display: block;">{{ $order['created_at'] ?? '' }}</small>
                                    </td>
                                    <td data-label="Klien">
                                        <strong>{{ $order['name'] }}</strong>
                                        <small style="color: #64748B; display: block;">{{ '@' . $order['user_username'] }}</small>
                                    </td>
                                    <td data-label="Layanan" style="font-weight: 500;">{{ $order['programType'] }}</td>
                                    <td data-label="Status">
                                        <span class="status-badge status-{{ strtolower($order['status']) }}">
                                            {{ $order['status'] }}
                                        </span>
                                    </td>
                                    <td data-label="">
                                        <form action="{{ url('/superadmin/pesanan/delete') }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pesanan ini secara permanen?');">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $order['id'] }}">
                                            <button type="submit" class="btn-delete">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M3 6h18" />
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
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
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <path d="M7 7h10" />
                        <path d="M7 12h10" />
                        <path d="M7 17h10" />
                    </svg>
                    <p>Belum ada data pesanan di sistem.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
