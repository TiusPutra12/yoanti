@extends('layouts.app')
@section('title', 'Admin Dashboard - Permintaan')

@push('styles')
<style>
    .admin-section {
        padding: 4rem 5%;
        background: var(--bg);
        min-height: 80vh;
    }

    .admin-card {
        background: #FFFFFF;
        border-radius: 20px;
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.06);
        border: 1px solid rgba(226, 232, 240, 0.6);
        padding: 2.5rem;
        overflow: hidden;
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 1rem;
        text-align: left;
    }

    th {
        padding: 1rem 1.5rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--border);
    }

    td {
        padding: 1.25rem 1.5rem;
        background: #FFFFFF;
        vertical-align: top;
        border-top: 1px solid #F1F5F9;
        border-bottom: 1px solid #F1F5F9;
    }
    
    tr td:first-child {
        border-left: 1px solid #F1F5F9;
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
    }

    tr td:last-child {
        border-right: 1px solid #F1F5F9;
        border-top-right-radius: 16px;
        border-bottom-right-radius: 16px;
    }

    tbody tr {
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px -5px rgba(0,0,0,0.08);
    }
    
    .status-badge {
        padding: 0.4rem 1rem; 
        border-radius: 999px; 
        font-size: 0.8rem; 
        font-weight: 700; 
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-pending { background: #FFFBEB; color: #D97706; border: 1px solid #FEF3C7; }
    .status-pending::before { background: #F59E0B; }
    
    .status-proses { background: #EFF6FF; color: #2563EB; border: 1px solid #DBEAFE; }
    .status-proses::before { background: #3B82F6; }
    
    .status-selesai { background: #ECFDF5; color: #059669; border: 1px solid #D1FAE5; }
    .status-selesai::before { background: #10B981; }
    
    .status-gagal, .status-ditolak { background: #FEF2F2; color: #DC2626; border: 1px solid #FEE2E2; }
    .status-gagal::before, .status-ditolak::before { background: #EF4444; }

    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        margin-right: 0.25rem;
        margin-bottom: 0.25rem;
        color: white;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-acc { background: #2563EB; }
    .btn-acc:hover { background: #1D4ED8; box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
    
    .btn-tolak { background: #FFFFFF; color: #DC2626; border: 1px solid #DC2626; }
    .btn-tolak:hover { background: #FEF2F2; }

    .btn-selesai { background: #10B981; }
    .btn-selesai:hover { background: #059669; box-shadow: 0 4px 12px rgba(16,185,129,0.3); }

    .btn-gagal { background: #FFFFFF; color: #64748B; border: 1px solid #94A3B8; }
    .btn-gagal:hover { background: #F8FAFC; color: #0F172A; border-color: #0F172A; }

    .action-form { display: inline-block; }
</style>
@endpush

@section('content')
<section class="admin-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 2rem; color: var(--text-main);">Manajemen Permintaan</h2>
    </div>

    <div class="admin-card">
        @if(count($orders ?? []) > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Permintaan</th>
                        <th>Klien</th>
                        <th>Layanan & Budget</th>
                        <th>Detail Kebutuhan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td style="font-weight: 600;">{{ $order['id'] }}<br><span style="font-size: 0.8rem; color: #64748B;">{{ $order['created_at'] }}</span></td>
                        <td>
                            <strong>{{ $order['name'] }}</strong><br>
                            <span style="font-size: 0.9rem; color: #64748B;">User: {{ $order['user_username'] }}</span><br>
                            <span style="font-size: 0.9rem;">{{ $order['company'] }}</span>
                        </td>
                        <td>
                            <strong>{{ $order['programType'] }}</strong><br>
                            <span style="font-size: 0.9rem; color: #64748B;">{{ $order['budget'] }}</span>
                        </td>
                        <td>
                            <div style="max-height: 80px; overflow-y: auto; font-size: 0.9rem;">
                                {{ $order['description'] }}
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($order['status']) }}">
                                {{ $order['status'] }}
                            </span>
                        </td>
                        <td>
                            @if($order['status'] === 'pending')
                                <form action="{{ url('/admin/permintaan/status') }}" method="POST" class="action-form">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                    <input type="hidden" name="status" value="proses">
                                    <button type="submit" class="action-btn btn-acc">Terima</button>
                                </form>
                                <form action="{{ url('/admin/permintaan/status') }}" method="POST" class="action-form" onsubmit="return confirm('Tolak permintaan ini?');">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="action-btn btn-tolak">Tolak</button>
                                </form>
                            @elseif($order['status'] === 'proses')
                                <form action="{{ url('/admin/permintaan/status') }}" method="POST" class="action-form">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" class="action-btn btn-selesai">Selesai</button>
                                </form>
                                <form action="{{ url('/admin/permintaan/status') }}" method="POST" class="action-form" onsubmit="return confirm('Tandai sebagai gagal?');">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                    <input type="hidden" name="status" value="gagal">
                                    <button type="submit" class="action-btn btn-gagal">Gagal</button>
                                </form>
                            @else
                                <span style="font-size: 0.85rem; color: #94A3B8;">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
            Belum ada permintaan yang masuk.
        </div>
        @endif
    </div>
</section>
@endsection
