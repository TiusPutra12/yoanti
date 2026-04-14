@extends('layouts.app')
@section('title', 'Super Admin - User')

@push('styles')
<style>
    .sa-section { padding: 4rem 5%; background: var(--bg); min-height: 80vh; }
    .sa-card {
        background: #fff; border-radius: 16px; padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid var(--border);
        overflow-x: auto;
    }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { padding: 1rem; color: var(--text-muted); border-bottom: 2px solid var(--border); font-size: 0.9rem; text-transform: uppercase; }
    td { padding: 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .btn-delete { background: #FEF2F2; color: #DC2626; border: 1px solid #FEE2E2; padding: 0.4rem 0.8rem; border-radius: 6px; cursor: pointer; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.3rem; }
    .btn-delete:hover { background: #FEE2E2; border-color: #DC2626; }
    .badge-role { padding: 0.2rem 0.6rem; border-radius: 5px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; }
    .badge-user { background: #E0E7FF; color: #4338CA; }
    .badge-admin { background: #D1FAE5; color: #065F46; }
    .badge-superadmin { background: #FCE7F3; color: #BE185D; }
</style>
@endpush

@section('content')
<section class="sa-section">
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 2rem; color: var(--text-main);">Manajemen User</h2>
        <p style="color: var(--text-muted);">Lihat dan hapus akun pengguna.</p>
    </div>

    <div class="sa-card">
        @if(count($users ?? []) > 0)
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td><strong>{{ $u['username'] }}</strong></td>
                    <td>{{ $u['name'] }}</td>
                    <td>
                        <span class="badge-role badge-{{ $u['role'] ?? 'user' }}">
                            {{ $u['role'] ?? 'user' }}
                        </span>
                    </td>
                    <td>
                        @if($u['username'] !== 'superadmin')
                        <form action="{{ url('/superadmin/user/delete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini secara permanen?');">
                            @csrf
                            <input type="hidden" name="username" value="{{ $u['username'] }}">
                            <button type="submit" class="btn-delete">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                Hapus
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="text-align: center; color: var(--text-muted); padding: 2rem;">Tidak ada data user.</div>
        @endif
    </div>
</section>
@endsection
