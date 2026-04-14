@extends('layouts.app')
@section('title', 'Super Admin - Komentar')

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
    .reply-row { background-color: #F8FAFC; }
    .reply-icon { display: inline-block; width: 16px; height: 16px; border-left: 2px solid #CBD5E1; border-bottom: 2px solid #CBD5E1; margin-right: 8px; margin-bottom: 4px; border-bottom-left-radius: 4px; }
</style>
@endpush

@section('content')
<section class="sa-section">
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 2rem; color: var(--text-main);">Manajemen Komentar</h2>
        <p style="color: var(--text-muted);">Lihat dan hapus komentar (utama maupun balasan).</p>
    </div>

    <div class="sa-card">
        @if(count($comments ?? []) > 0)
        <table>
            <thead>
                <tr>
                    <th>Info Komentar</th>
                    <th>Isi Komentar</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_reverse($comments) as $c)
                <tr>
                    <td>
                        <strong>{{ $c['name'] }}</strong> <small>({{ $c['username'] }})</small><br>
                        <small class="text-muted">{{ $c['created_at'] }}</small>
                    </td>
                    <td>{{ $c['comment'] }}</td>
                    <td><span style="background: #E0E7FF; color: #4338CA; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">Utama</span></td>
                    <td>
                        <form action="{{ url('/superadmin/komentar/delete') }}" method="POST" onsubmit="return confirm('Yakin menghapus komentar ini beserta semua balasannya?');">
                            @csrf
                            <input type="hidden" name="id" value="{{ $c['id'] }}">
                            <input type="hidden" name="type" value="main">
                            <button type="submit" class="btn-delete">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                    @if(isset($c['replies']) && is_array($c['replies']))
                        @foreach($c['replies'] as $reply)
                        <tr class="reply-row">
                            <td style="padding-left: 2rem;">
                                <div class="reply-icon"></div>
                                <strong>{{ $reply['name'] }}</strong> <small>({{ $reply['username'] }})</small><br>
                                <small class="text-muted" style="margin-left: 24px;">{{ $reply['created_at'] }}</small>
                            </td>
                            <td>{{ $reply['comment'] }}</td>
                            <td><span style="background: #F3F4F6; color: #4B5563; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">Balasan</span></td>
                            <td>
                                <form action="{{ url('/superadmin/komentar/delete') }}" method="POST" onsubmit="return confirm('Yakin menghapus balasan ini?');">
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
        @else
        <div style="text-align: center; color: var(--text-muted); padding: 2rem;">Tidak ada data komentar.</div>
        @endif
    </div>
</section>
@endsection
