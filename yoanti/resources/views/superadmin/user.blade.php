@extends('layouts.app')
@section('title', 'Super Admin - Pengguna')

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

        .sa-page-header p { color: var(--text-muted); font-size: 0.875rem; margin-top: 0.2rem; }

        .count-pill {
            background: #EFF6FF;
            color: #2563EB;
            border: 1px solid #DBEAFE;
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

        .table-scroll { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 400px;
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

        tbody tr:last-child td { border-bottom: none; }
        tbody tr { transition: background 0.15s; }
        tbody tr:hover { background: #F8FAFC; }

        /* User Avatar Cell */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .user-info .username  { font-weight: 700; font-size: 0.9rem; }
        .user-info .name      { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.1rem; }

        /* Role Badge */
        .badge-role {
            padding: 0.3rem 0.7rem;
            border-radius: 7px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .badge-user       { background: #E0E7FF; color: #4338CA; }
        .badge-admin      { background: #D1FAE5; color: #059669; }
        .badge-superadmin { background: #FCE7F3; color: #BE185D; }

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

        .btn-delete:hover { background: #FEE2E2; border-color: #EF4444; transform: scale(1.03); }

        /* Protected badge */
        .protected-badge {
            font-size: 0.75rem;
            color: #94A3B8;
            font-style: italic;
        }

        /* Empty */
        .empty-state {
            text-align: center;
            padding: clamp(3rem, 8vw, 5rem) 1.5rem;
            color: var(--text-muted);
        }
        .empty-state svg { margin-bottom: 1rem; opacity: 0.4; }

        /* Mobile */
        @media (max-width: 640px) {
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
            }

            tbody tr:hover { background: #fff; }

            tbody td {
                padding: 0.55rem 0;
                border-bottom: 1px solid #F1F5F9;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.875rem;
            }

            tbody td:last-child { border-bottom: none; padding-top: 0.75rem; justify-content: flex-end; }

            tbody td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--text-muted);
                font-size: 0.72rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                flex-shrink: 0;
            }

            .user-cell { flex-direction: row; }
        }
    </style>
@endpush

@section('content')
    <div class="sa-page">
        <div class="sa-page-header">
            <div>
                <h1>Manajemen Pengguna</h1>
                <p>Kelola data akun yang terdaftar di platform</p>
            </div>
            @if(count($users ?? []) > 0)
                <span class="count-pill">{{ count($users) }} pengguna</span>
            @endif
        </div>

        <div class="sa-card">
            @if (count($users ?? []) > 0)
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Otoritas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $u)
                                <tr>
                                    <td data-label="Pengguna">
                                        <div class="user-cell">
                                            <div class="user-avatar">{{ strtoupper(substr($u['name'] ?? $u['username'], 0, 1)) }}</div>
                                            <div class="user-info">
                                                <div class="username">{{ $u['username'] }}</div>
                                                <div class="name">{{ $u['name'] ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Role">
                                        <span class="badge-role badge-{{ $u['role'] ?? 'user' }}">
                                            {{ $u['role'] ?? 'user' }}
                                        </span>
                                    </td>
                                    <td data-label="">
                                        @if ($u['username'] !== 'superadmin')
                                            <form action="{{ url('/superadmin/user/delete') }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus user ini secara permanen?');">
                                                @csrf
                                                <input type="hidden" name="username" value="{{ $u['username'] }}">
                                                <button type="submit" class="btn-delete">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="protected-badge">Terproteksi</span>
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
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    </svg>
                    <p>Tidak ada data pengguna.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
