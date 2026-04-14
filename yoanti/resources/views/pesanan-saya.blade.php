@extends('layouts.app')
@section('title', 'Pesanan Saya')

@push('styles')
<style>
    .pesanan-section {
        padding: 4rem 5%;
        background: var(--bg);
        min-height: 80vh;
    }

    .pesanan-card {
        background: #FFFFFF;
        border-radius: 20px;
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.06);
        border: 1px solid rgba(226, 232, 240, 0.6);
        padding: 2.5rem;
        overflow: hidden;
        max-width: 1000px;
        margin: 0 auto;
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
</style>
@endpush

@section('content')
<section class="pesanan-section">
    <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 2.25rem; font-weight: 800; color: var(--text-main); letter-spacing: -0.5px;">Pesanan Saya</h2>
    </div>

    <div class="pesanan-card">
        @if(count($myOrders ?? []) > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Layanan & Budget</th>
                        <th>Detail Kebutuhan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($myOrders as $order)
                    <tr>
                        <td style="font-weight: 600;">{{ $order['id'] }}<br><span style="font-size: 0.8rem; color: #64748B;">{{ $order['created_at'] }}</span></td>
                        <td>
                            <strong>{{ $order['programType'] }}</strong><br>
                            <span style="font-size: 0.9rem; color: #64748B;">{{ $order['budget'] }}</span>
                        </td>
                        <td>
                            <div style="max-height: 80px; overflow-y: auto; font-size: 0.95rem; color: var(--text-main);">
                                {{ $order['description'] }}
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($order['status']) }}">
                                {{ $order['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align: center; padding: 4rem 2rem;">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 7h10"/><path d="M7 12h10"/><path d="M7 17h10"/></svg>
            <h3 style="font-size: 1.25rem; color: var(--text-main); margin-bottom: 0.5rem;">Belum ada pesanan</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Anda belum membuat pesanan apapun.</p>
            <a href="{{ url('/pesan') }}" class="btn-primary" style="font-size: 0.9rem;">Buat Pesanan Sekarang</a>
        </div>
        @endif
    </div>
</section>
@endsection
