@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    color: white;
    padding: 3rem 2rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.stats-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: none;
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.quick-action-card {
    background: white;
    border-radius: 16px;
    padding: 2rem 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    height: 100%;
    text-decoration: none;
    color: inherit;
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border-color: #667eea;
    color: inherit;
    text-decoration: none;
}

.promo-card {
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    min-height: 200px;
}

.promo-bg-pattern {
    position: absolute;
    top: -20px;
    right: -20px;
    font-size: 8rem;
    opacity: 0.1;
    z-index: 1;
}

.package-card {
    border: none;
    border-radius: 16px;
    transition: all 0.3s ease;
    height: 100%;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.package-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.info-card {
    border: none;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.info-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
}

.section-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .hero-section {
        padding: 2rem 1.5rem;
        text-align: center;
    }
    
    .stats-card {
        margin-bottom: 1rem;
    }
    
    .quick-action-card {
        padding: 1.5rem 1rem;
        margin-bottom: 1rem;
    }
}
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-3 fw-bold">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="mb-4 opacity-90 fs-5">Kelola pesanan laundry Anda dengan mudah dan nikmati layanan terbaik dari JasaLaundry</p>
                <a href="{{ route('pelanggan.order') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>
                    Pesan Laundry Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-6">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-receipt"></i>
            </div>
            <h3 class="mb-1">{{ $totalPesanan }}</h3>
            <p class="text-muted mb-0">Total Pesanan</p>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="bi bi-clock"></i>
            </div>
            <h3 class="mb-1">{{ $pesananAktif }}</h3>
            <p class="text-muted mb-0">Pesanan Aktif</p>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                <i class="bi bi-check-circle"></i>
            </div>
            <h3 class="mb-1">{{ $pesananSelesai }}</h3>
            <p class="text-muted mb-0">Pesanan Selesai</p>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stats-card">
            <div class="stats-icon" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333;">
                <i class="bi bi-gift"></i>
            </div>
            <h3 class="mb-1">{{ $promoTersedia }}</h3>
            <p class="text-muted mb-0">Promo Tersedia</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <h5 class="section-title">
            <i class="bi bi-lightning-charge me-2"></i>
            Aksi Cepat
        </h5>
    </div>
    <div class="col-md-4">
        <a href="{{ route('pelanggan.order') }}" class="quick-action-card d-block">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-plus-circle"></i>
            </div>
            <h6 class="fw-bold mb-2">Pesan Laundry</h6>
            <p class="text-muted small mb-0">Buat pesanan baru dengan mudah</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('pelanggan.riwayat') }}" class="quick-action-card d-block">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="bi bi-clock-history"></i>
            </div>
            <h6 class="fw-bold mb-2">Riwayat Pesanan</h6>
            <p class="text-muted small mb-0">Lihat semua pesanan Anda</p>
        </a>
    </div>
    <div class="col-md-4">
        <button class="quick-action-card w-100 border-0" onclick="scrollToPromo()">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                <i class="bi bi-gift"></i>
            </div>
            <h6 class="fw-bold mb-2">Lihat Promo</h6>
            <p class="text-muted small mb-0">Klaim promo menarik</p>
        </button>
    </div>
</div>

<!-- Promo Carousel -->
@if($promos && $promos->count() > 0)
<div class="row mb-4" id="promo-section">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="section-title mb-0">
                <i class="bi bi-fire text-danger me-2"></i>
                Promo Spesial
            </h5>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary rounded-circle" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary rounded-circle" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($promos as $index => $promo)
                    <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @foreach($promos as $index => $promo)
                    @php
                        $gradients = [
                            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                            'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)',
                            'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)'
                        ];
                        $gradient = $gradients[$index % count($gradients)];
                    @endphp
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="promo-card" style="background: {{ $gradient }}; padding: 2rem; position: relative;">
                            <div class="promo-bg-pattern">
                                <i class="bi bi-gift"></i>
                            </div>
                            
                            <div class="row align-items-center" style="position: relative; z-index: 2;">
                                <div class="col-md-8">
                                    <span class="badge bg-white text-dark mb-3 px-3 py-2">
                                        <i class="bi bi-star-fill text-warning me-1"></i>
                                        PROMO TERBATAS
                                    </span>
                                    <h3 class="text-white fw-bold mb-2">{{ $promo->judul }}</h3>
                                    <p class="text-white opacity-75 mb-3">{{ Str::limit($promo->deskripsi, 100) }}</p>
                                    
                                    <div class="d-flex align-items-center gap-4">
                                        <div>
                                            <small class="text-white opacity-75 d-block">Diskon</small>
                                            <span class="h4 text-white fw-bold mb-0">{{ $promo->diskon_text }}</span>
                                        </div>
                                        <div class="vr bg-white opacity-25" style="height: 40px;"></div>
                                        <div>
                                            <small class="text-white opacity-75 d-block">Berlaku hingga</small>
                                            <span class="text-white fw-medium">{{ $promo->tanggal_selesai->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 text-center mt-3 mt-md-0">
                                    <button id="btn-klaim-{{ $promo->id }}" class="btn btn-light btn-lg px-4" onclick="klaimPromo({{ $promo->id }})">
                                        <span class="btn-text">
                                            <i class="bi bi-gift me-2"></i>
                                            Klaim Sekarang
                                        </span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2"></span>
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
<div class="row mb-4">
    <div class="col-12">
        <h5 class="section-title">
            <i class="bi bi-box-seam me-2"></i>
            Paket Laundry Tersedia
        </h5>
    </div>
    @forelse($pakets as $paket)
        <div class="col-md-4 col-sm-6">
            <div class="package-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stats-icon me-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; width: 50px; height: 50px; font-size: 1.2rem;">
                            <i class="bi bi-box"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ $paket->nama_paket }}</h6>
                            <small class="text-muted">{{ $paket->satuan == 'kg' ? 'Per Kilogram' : 'Per Pieces' }}</small>
                        </div>
                    </div>
                    
                    <p class="text-muted small mb-3">{{ Str::limit($paket->deskripsi, 80) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="h5 text-success fw-bold mb-0">Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}</span>
                            <small class="text-muted d-block">per {{ $paket->satuan }}</small>
                        </div>
                    </div>
                    
                    <a href="{{ route('pelanggan.order') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-cart-plus me-2"></i>
                        Pilih Paket
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="info-card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-box text-muted" style="font-size: 3rem;"></i>
                    <h6 class="text-muted mt-3">Belum Ada Paket Tersedia</h6>
                    <p class="text-muted mb-0">Paket laundry akan segera tersedia</p>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Informasi Layanan -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="info-card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-list-ol text-primary me-2"></i>
                    Cara Pemesanan
                </h6>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary rounded-circle me-3" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">1</span>
                        <small>Klik "Pesan Laundry Sekarang"</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary rounded-circle me-3" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">2</span>
                        <small>Pilih paket dan metode pembayaran</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary rounded-circle me-3" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">3</span>
                        <small>Isi alamat penjemputan</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary rounded-circle me-3" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">4</span>
                        <small>Konfirmasi pesanan</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary rounded-circle me-3" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">5</span>
                        <small>Tunggu kurir menjemput</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="info-card">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-clock text-success me-2"></i>
                    Jam Operasional
                </h6>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between">
                        <span class="fw-medium">Senin - Jumat</span>
                        <span class="text-muted">08:00 - 20:00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-medium">Sabtu</span>
                        <span class="text-muted">08:00 - 18:00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-medium">Minggu</span>
                        <span class="text-muted">09:00 - 17:00</span>
                    </div>
                    <hr class="my-2">
                    <small class="text-muted">Penjemputan & pengantaran sesuai jadwal</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="info-card" style="border-left: 4px solid #dc3545;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3 text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Barang yang Tidak Diterima
                </h6>
                <div class="d-flex flex-column gap-1">
                    <small><i class="bi bi-x-circle text-danger me-2"></i>Pakaian dalam (celana dalam, bra)</small>
                    <small><i class="bi bi-x-circle text-danger me-2"></i>Barang kulit dan suede</small>
                    <small><i class="bi bi-x-circle text-danger me-2"></i>Pakaian dengan noda cat/oli berat</small>
                    <small><i class="bi bi-x-circle text-danger me-2"></i>Barang berharga (perhiasan, uang)</small>
                    <small><i class="bi bi-x-circle text-danger me-2"></i>Pakaian rusak/sobek parah</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="info-card" style="border-left: 4px solid #28a745;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3 text-success">
                    <i class="bi bi-shield-check me-2"></i>
                    Jaminan Layanan
                </h6>
                <div class="d-flex flex-column gap-1">
                    <small><i class="bi bi-check-circle text-success me-2"></i>Garansi hilang/rusak 100%</small>
                    <small><i class="bi bi-check-circle text-success me-2"></i>Deterjen berkualitas premium</small>
                    <small><i class="bi bi-check-circle text-success me-2"></i>Proses cuci higienis & aman</small>
                    <small><i class="bi bi-check-circle text-success me-2"></i>Packing rapi & wangi</small>
                    <small><i class="bi bi-check-circle text-success me-2"></i>Layanan pelanggan 24/7</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tentang JasaLaundry -->
<div class="row">
    <div class="col-12">
        <div class="info-card" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border: 2px solid #667eea;">
            <div class="card-body text-center p-4">
                <div class="stats-icon mx-auto mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="bi bi-droplet-half"></i>
                </div>
                <h5 class="fw-bold mb-3">Tentang JasaLaundry</h5>
                <p class="text-muted mb-0" style="line-height: 1.6;">
                    JasaLaundry adalah layanan laundry antar-jemput terpercaya dengan pengalaman lebih dari 3 tahun. 
                    Kami menggunakan teknologi modern dan deterjen berkualitas untuk memberikan hasil terbaik. 
                    Dengan tim kurir profesional, kepuasan pelanggan adalah prioritas utama kami.
                </p>
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
        
        fetch('/pelanggan/promo/klaim', {
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