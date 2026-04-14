@extends('layouts.app')
@section('title', 'Pesan Sekarang')

@push('styles')
<style>
    .order-section {
        padding: 5rem 5%;
        background: var(--bg);
        min-height: 80vh;
    }

    .section-title {
        text-align: center;
        font-size: 2.25rem;
        font-weight: 700;
        margin-bottom: 3rem;
        color: var(--text-main);
    }

    .form-container {
        max-width: 700px;
        margin: 0 auto;
        background: var(--card-bg);
        padding: 3rem;
        border-radius: 24px;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border);
    }

    .form-group { margin-bottom: 1.75rem; }
    .row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    
    .form-group label {
        display: block; margin-bottom: 0.6rem; font-weight: 600;
        color: var(--text-main); font-size: 0.9rem;
    }
    
    .form-control {
        width: 100%; padding: 0.875rem 1.25rem; border: 1.5px solid var(--border);
        border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;
        background: var(--bg); color: var(--text-main);
    }
    
    .form-control:focus {
        outline: none; border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); background: #FFFFFF;
    }
    
    .form-control::placeholder { color: #94A3B8; }
    textarea.form-control { resize: vertical; min-height: 140px; }

    @media (max-width: 768px) {
        .row { grid-template-columns: 1fr; gap: 0; }
        .form-container { padding: 2rem; }
    }
</style>
@endpush

@section('content')
    <section class="order-section">
        <h2 class="section-title">Mulai Pemesanan</h2>
        <div class="form-container">
            <form id="orderForm" onsubmit="sendToWhatsApp(event)">
                <div class="row">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="company">Nama Instansi / Perusahaan</label>
                        <input type="text" id="company" class="form-control" placeholder="PT Kreatif Tech" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Alamat Domisili / Perusahaan</label>
                    <input type="text" id="address" class="form-control" placeholder="Jl. Sudirman, Jakarta Selatan" required>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="programType">Jenis Layanan</label>
                        <select id="programType" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Layanan --</option>
                            <option value="Pembuatan Website">Pembuatan Website</option>
                            <option value="Aplikasi Android">Aplikasi Android</option>
                            <option value="Website & Android">Website & Aplikasi Android</option>
                            <option value="Sistem Informasi">Sistem Informasi (ERP/CRM)</option>
                            <option value="Lainnya">Lainnya (Custom Request)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="budget">Estimasi Budget</label>
                        <select id="budget" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Budget --</option>
                            <option value="< Rp 5 Juta">< Rp 5 Juta</option>
                            <option value="Rp 5 Juta - Rp 15 Juta">Rp 5 Juta - Rp 15 Juta</option>
                            <option value="Rp 15 Juta - Rp 30 Juta">Rp 15 Juta - Rp 30 Juta</option>
                            <option value="> Rp 30 Juta">> Rp 30 Juta</option>
                            <option value="Belum Tahu / Nego">Belum Tahu / Nego</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi Singkat Kebutuhan Project</label>
                    <textarea id="description" class="form-control" placeholder="Ceritakan fitur apa saja yang Anda inginkan..." required></textarea>
                </div>

                <button type="submit" class="btn-primary"
                    style="width: 100%; font-size: 1.1rem; padding: 1.1rem; border-radius: 12px; margin-top: 1rem;">
                    Kirim Pesan via WhatsApp
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 8px;">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function sendToWhatsApp(event) {
        event.preventDefault();

        const phoneNumber = "6287883322975";

        const name = document.getElementById('name').value;
        const company = document.getElementById('company').value;
        const address = document.getElementById('address').value;
        const programType = document.getElementById('programType').value;
        const budget = document.getElementById('budget').value;
        const description = document.getElementById('description').value;

        const message = `Halo Tim Yoanti! 👋\nSaya tertarik untuk membuat project dan ingin berkonsultasi lebih lanjut.\n\nBerikut rincian data saya:\n\n*Nama Lengkap:* ${name}\n*Instansi/Perusahaan:* ${company}\n*Alamat:* ${address}\n\n*Detail Project:*\n*Jenis Layanan:* ${programType}\n*Estimasi Budget:* ${budget}\n\n*Deskripsi Kebutuhan:*\n${description}\n\nMohon informasi selanjutnya. Terima kasih!`;

        const encodedMessage = encodeURIComponent(message);
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Memproses...';

        fetch("{{ url('/pesan/store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                _token: '{{ csrf_token() }}',
                name: name,
                company: company,
                address: address,
                programType: programType,
                budget: budget,
                description: description
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                window.open(whatsappUrl, '_blank');
                window.location.href = "{{ url('/') }}";
            } else {
                alert('Gagal menyimpan pesanan.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan koneksi.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    }
</script>
@endpush
