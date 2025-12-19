@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="row fade-in-up">
    <div class="col-12">
        <h1 class="page-title">Dashboard Pelanggan</h1>
        <p class="welcome-text">Selamat datang, {{ auth()->user()->name }}! Kelola pesanan laundry Anda dengan mudah.</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4 fade-in-up stagger-1">
    <div class="col-md-3 mb-3">
        <div class="card border-primary" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-primary fw-bold mb-1">{{ $totalPesanan }}</h4>
                    <p class="mb-0 text-muted">Total Pesanan</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-receipt fs-1 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-warning" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-warning fw-bold mb-1">{{ $pesananAktif }}</h4>
                    <p class="mb-0 text-muted">Pesanan Aktif</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-clock fs-1 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-success" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-success fw-bold mb-1">{{ $pesananSelesai }}</h4>
                    <p class="mb-0 text-muted">Pesanan Selesai</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-info" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-info fw-bold mb-1">{{ $promoTersedia }}</h4>
                    <p class="mb-0 text-muted">Promo Tersedia</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-gift fs-1 text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4 fade-in-up stagger-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 section-title"><i class="bi bi-lightning"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('pelanggan.order') }}" class="btn btn-primary w-100 menu-card">
                            <i class="bi bi-plus-circle fs-4 d-block mb-2"></i>
                            <strong>Pesan Laundry</strong>
                            <small class="d-block text-white-50">Buat pesanan baru</small>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('pelanggan.riwayat') }}" class="btn btn-outline-primary w-100 menu-card">
                            <i class="bi bi-clock-history fs-4 d-block mb-2"></i>
                            <strong>Riwayat Pesanan</strong>
                            <small class="d-block text-muted">Lihat pesanan Anda</small>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <button class="btn btn-outline-success w-100 menu-card" onclick="scrollToPromo()">
                            <i class="bi bi-gift fs-4 d-block mb-2"></i>
                            <strong>Lihat Promo</strong>
                            <small class="d-block text-muted">Klaim promo menarik</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Promo Carousel -->
@if($promos && $promos->count() > 0)
<div class="row mb-4 fade-in-up" id="promo-section">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="section-title mb-0"><i class="bi bi-fire text-danger"></i> Promo Spesial</h5>
            <div class="carousel-nav-buttons">
                <button class="btn btn-sm btn-outline-secondary rounded-circle" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary rounded-circle" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="promoCarousel" class="carousel slide shadow-sm" data-bs-ride="carousel" style="border-radius: 20px; overflow: hidden;">
            <div class="carousel-indicators" style="bottom: 0;">
                @foreach($promos as $index => $promo)
                    <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="true"></button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @foreach($promos as $index => $promo)
                    @php
                        $gradients = [
                            'linear-gradient(135deg, #FF6B6B 0%, #ED0E11 100%)', // Red
                            'linear-gradient(135deg, #4158D0 0%, #C850C0 100%)', // Purple/Blue
                            'linear-gradient(135deg, #0093E9 0%, #80D0C7 100%)', // Teal
                            'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)'  // Green
                        ];
                        $gradient = $gradients[$index % count($gradients)];
                    @endphp
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-bs-interval="5000">
                        <div class="promo-card position-relative" style="background: {{ $gradient }}; min-height: 160px; border: none; padding: 25px;">
                            <div class="promo-bg-icon">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>

                            <div class="row align-items-center position-relative" style="z-index: 2;">
                                <div class="col-8 col-md-9">
                                    <span class="badge bg-white text-dark mb-2 px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.7rem; font-weight: 700;">
                                        <i class="bi bi-stars text-warning"></i> LIMITED OFFER
                                    </span>
                                    <h3 class="text-white fw-bold mb-1" style="font-size: 1.25rem;">{{ $promo->judul }}</h3>
                                    <p class="text-white text-opacity-75 mb-3 d-none d-md-block" style="font-size: 0.9rem; max-width: 80%;">
                                        {{ Str::limit($promo->deskripsi, 80) }}
                                    </p>
                                    
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="promo-discount-tag">
                                            <span class="small opacity-75 d-block text-white" style="font-size: 0.7rem;">Diskon</span>
                                            <span class="fw-bold text-white" style="font-size: 1.1rem;">{{ $promo->diskon_text }}</span>
                                        </div>
                                        <div class="vr bg-white opacity-25" style="height: 30px;"></div>
                                        <div class="promo-expiry">
                                            <span class="small opacity-75 d-block text-white" style="font-size: 0.7rem;">Hingga</span>
                                            <span class="fw-bold text-white" style="font-size: 0.9rem;">{{ $promo->tanggal_selesai->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-4 col-md-3 text-end">
                                    <button id="btn-klaim-{{ $promo->id }}" class="btn btn-light btn-claim-modern" onclick="klaimPromo({{ $promo->id }})">
                                        <span class="btn-text">Klaim <i class="bi bi-arrow-right-short"></i></span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                            Loading...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- Paket Laundry -->
<div class="row mb-4 fade-in-up stagger-4">
    <div class="col-12">
        <h5 class="section-title"><i class="bi bi-box"></i> Paket Laundry Tersedia</h5>
    </div>
</div>

<div class="row">
    @forelse($pakets as $paket)
        <div class="col-6 col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm mobile-card">
                <div class="card-body">
                    <h5 class="card-title text-primary h6 h-md-5">
                        <i class="bi bi-box"></i> {{ $paket->nama_paket }}
                    </h5>
                    <p class="card-text small d-none d-md-block">{{ $paket->deskripsi }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h6 h-md-5 text-success mb-0">
                            Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}
                        </span>
                        <small class="text-muted">per {{ $paket->satuan }}</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('pelanggan.order') }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-cart-plus"></i> <span class="d-none d-sm-inline">Pilih Paket</span><span class="d-sm-none">Pilih</span>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Belum ada paket laundry tersedia.
            </div>
        </div>
    @endforelse
</div>

<!-- Informasi Layanan -->
<div class="row mt-5">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="text-primary"><i class="bi bi-info-circle"></i> Cara Pemesanan</h5>
                <ol class="mb-0">
                    <li>Klik "Pesan Laundry Sekarang"</li>
                    <li>Pilih paket dan metode pembayaran</li>
                    <li>Isi alamat penjemputan</li>
                    <li>Konfirmasi pesanan</li>
                    <li>Tunggu kurir menjemput</li>
                </ol>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="text-success"><i class="bi bi-clock"></i> Jam Operasional</h5>
                <ul class="list-unstyled mb-0">
                    <li><strong>Senin - Jumat:</strong> 08:00 - 20:00</li>
                    <li><strong>Sabtu:</strong> 08:00 - 18:00</li>
                    <li><strong>Minggu:</strong> 09:00 - 17:00</li>
                    <li class="mt-2"><small class="text-muted">Penjemputan & pengantaran sesuai jadwal</small></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-warning">
            <div class="card-body">
                <h5 class="text-warning"><i class="bi bi-exclamation-triangle"></i> Barang yang Tidak Diterima</h5>
                <ul class="mb-0">
                    <li>Pakaian dalam (celana dalam, bra)</li>
                    <li>Barang kulit dan suede</li>
                    <li>Pakaian dengan noda cat/oli berat</li>
                    <li>Barang berharga (perhiasan, uang)</li>
                    <li>Pakaian rusak/sobek parah</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card border-info">
            <div class="card-body">
                <h5 class="text-info"><i class="bi bi-shield-check"></i> Jaminan Layanan</h5>
                <ul class="mb-0">
                    <li>Garansi hilang/rusak 100%</li>
                    <li>Deterjen berkualitas premium</li>
                    <li>Proses cuci higienis & aman</li>
                    <li>Packing rapi & wangi</li>
                    <li>Layanan pelanggan 24/7</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Tentang JasaLaundry -->
<div class="row fade-in-up stagger-4">
    <div class="col-12">
        <div class="card border-primary" style="border-width: 2px !important; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <div class="card-body text-center">
                <h4 class="text-primary mb-3"><i class="bi bi-droplet-half"></i> Tentang JasaLaundry</h4>
                <p class="mb-0 text-dark" style="line-height: 1.6;">JasaLaundry adalah layanan laundry antar-jemput terpercaya dengan pengalaman lebih dari 3 tahun. Kami menggunakan teknologi modern dan deterjen berkualitas untuk memberikan hasil terbaik. Dengan tim kurir profesional, kepuasan pelanggan adalah prioritas utama kami.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function klaimPromo(promoId) {
    if (confirm('Yakin ingin mengklaim promo ini? Anda akan mendapat kode promo setelah disetujui admin.')) {
        const btn = document.getElementById(`btn-klaim-${promoId}`);
        const btnText = btn.querySelector('.btn-text');
        const btnLoading = btn.querySelector('.btn-loading');
        
        // Show loading state
        btn.disabled = true;
        btnText.classList.add('d-none');
        btnLoading.classList.remove('d-none');
        
        fetch('/klaim-promo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ promo_id: promoId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Promo berhasil diklaim! Admin akan memvalidasi dan mengirim kode promo via WhatsApp.');
                location.reload();
            } else {
                alert(data.message || 'Gagal mengklaim promo.');
                // Reset button state
                btn.disabled = false;
                btnText.classList.remove('d-none');
                btnLoading.classList.add('d-none');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan. Silakan coba lagi.');
            // Reset button state
            btn.disabled = false;
            btnText.classList.remove('d-none');
            btnLoading.classList.add('d-none');
        });
    }
}

function scrollToPromo() {
    document.getElementById('promo-section').scrollIntoView({ 
        behavior: 'smooth' 
    });
}
</script>
@endsection