@extends('layouts.app')
@section('title', 'Super Admin - Komentar')

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
            background: #F5F3FF;
            color: #7C3AED;
            border: 1px solid #EDE9FE;
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
            min-width: 550px;
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

        .reply-row td {
            background: #FAFAFA;
        }

        .reply-row:hover td {
            background: #F5F5F5;
        }

        .reply-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-left: 2px solid #CBD5E1;
            border-bottom: 2px solid #CBD5E1;
            margin-right: 8px;
            border-bottom-left-radius: 6px;
            transform: translateY(-4px);
            flex-shrink: 0;
        }

        .type-badge {
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .type-main {
            background: #E0E7FF;
            color: #4338CA;
        }

        .type-reply {
            background: #F1F5F9;
            color: #475569;
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

        /* Mobile Cards */
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

            .reply-row {
                margin-left: 0.75rem;
                border-left: 3px solid #CBD5E1;
                border-radius: 12px;
            }

            .reply-row td {
                background: #fff !important;
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

            .reply-icon {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="sa-page">
        <div class="sa-page-header">
            <div>
                <h1>Moderasi Komentar</h1>
                <p>Kontrol penuh terhadap testimoni dan diskusi</p>
            </div>
            @php
                $totalCount = 0;
                foreach ($comments ?? [] as $c) {
                    $totalCount++;
                    $totalCount += count($c['replies'] ?? []);
                }
            @endphp
            @if ($totalCount > 0)
                <span class="count-pill">{{ $totalCount }} komentar</span>
            @endif
        </div>

        <div class="sa-card">
            @if (count($comments ?? []) > 0)
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Penulis</th>
                                <th>Isi Komentar</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (array_reverse($comments) as $c)
                                <tr>
                                    <td data-label="Penulis">
                                        <strong>{{ $c['name'] }}</strong>
                                        <small style="color: #64748B; display: block;">{{ '@' . $c['username'] }}</small>
                                        <small style="color: #94A3B8;">{{ $c['created_at'] }}</small>
                                    </td>
                                    <td data-label="Komentar" style="max-width: 280px; line-height: 1.5;">{{ $c['comment'] }}
                                    </td>
                                    <td data-label="Tipe"><span class="type-badge type-main">Utama</span></td>
                                    <td data-label="">
                                        <form action="{{ url('/superadmin/komentar/delete') }}" method="POST"
                                            onsubmit="return confirm('Yakin menghapus komentar ini beserta semua balasannya?');">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $c['id'] }}">
                                            <input type="hidden" name="type" value="main">
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

                                @if (isset($c['replies']) && is_array($c['replies']))
                                    @foreach ($c['replies'] as $reply)
                                        <tr class="reply-row">
                                            <td data-label="Penulis">
                                                <div style="display: flex; align-items: flex-start;">
                                                    <div class="reply-icon"></div>
                                                    <div>
                                                        <strong>{{ $reply['name'] }}</strong>
                                                        <small
                                                            style="color: #64748B; display: block;">{{ '@' . $reply['username'] }}</small>
                                                        <small style="color: #94A3B8;">{{ $reply['created_at'] }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Komentar" style="max-width: 280px; line-height: 1.5;">
                                                {{ $reply['comment'] }}</td>
                                            <td data-label="Tipe"><span class="type-badge type-reply">Balasan</span></td>
                                            <td data-label="">
                                                <form action="{{ url('/superadmin/komentar/delete') }}" method="POST"
                                                    onsubmit="return confirm('Yakin menghapus balasan ini?');">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $reply['id'] }}">
                                                    <input type="hidden" name="type" value="reply">
                                                    <button type="submit" class="btn-delete">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                    <p>Belum ada diskusi atau komentar yang masuk.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
