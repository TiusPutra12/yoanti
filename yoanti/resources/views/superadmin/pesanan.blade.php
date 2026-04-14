@extends('layouts.app')
@section('title', 'Super Admin - Pesanan')

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
</style>
@endpush

@section('content')
<section class="sa-section">
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 2rem; color: var(--text-main);">Manajemen Pesanan</h2>
        <p style="color: var(--text-muted);">Lihat dan hapus riwayat pesanan.</p>
    </div>

    <div class="sa-card">
        @if(count($orders ?? []) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>User</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_reverse($orders) as $order)
                <tr>
                    <td><strong>{{ $order['id'] }}</strong><br><small>{{ $order['created_at'] ?? '' }}</small></td>
                    <td>{{ $order['name'] }} <br><small class="text-muted">{{ $order['user_username'] }}</small></td>
                    <td>{{ $order['programType'] }}</td>
                    <td>{{ $order['status'] }}</td>
                    <td>
                        <form action="{{ url('/superadmin/pesanan/delete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini secara permanen?');">
                            @csrf
                            <input type="hidden" name="id" value="{{ $order['id'] }}">
                            <button type="submit" class="btn-delete">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="text-align: center; color: var(--text-muted); padding: 2rem;">Tidak ada data pesanan.</div>
        @endif
    </div>
</section>
@endsection
