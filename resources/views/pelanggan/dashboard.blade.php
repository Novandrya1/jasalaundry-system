@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    color: white;
    padding: 2rem 1.5rem;
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
    text-align: center;
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
    border-radius: 12px;
    transition: all 0.3s ease;
    height: 100%;
    background: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.package-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
}

.package-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
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
    font-size: 1rem;
}

@media (max-width: 768px) {
    .hero-section {
        padding: 1rem 1rem;
        text-align: center;
        border-radius: 12px;
        margin-bottom: 1rem;
    }
    
    .hero-section h1, .hero-section h5 {
        font-size: 14px;
        margin-bottom: 0.4rem !important;
        line-height: 1.3;
    }
    
    .hero-section p {
        font-size: 12px;
        margin-bottom: 0.6rem !important;
        line-height: 1.4;
    }
    
    .hero-section .btn {
        font-size: 11px;
        padding: 0.5rem 1rem;
    }
    
    .stats-card {
        margin-bottom: 0.8rem;
        padding: 0.8rem;
    }
    
    .stats-card h3, .stats-card h4 {
        font-size: 1.2rem;
        margin-bottom: 0.25rem;
    }
    
    .stats-card p {
        font-size: 10px;
        margin-bottom: 0;
    }
    
    .stats-icon {
        width: 35px;
        height: 35px;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .quick-action-card {
        padding: 0.6rem 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .quick-action-card h6 {
        font-size: 10px;
        margin-bottom: 0.15rem;
    }
    
    .quick-action-card p {
        font-size: 9px;
        margin-bottom: 0;
    }
    
    .quick-action-card .stats-icon {
        width: 30px;
        height: 30px;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
    }
    
    .section-title {
        font-size: 12px;
        margin-bottom: 0.75rem;
    }
    
    .promo-card {
        padding: 1rem !important;
        min-height: auto;
    }
    
    .promo-card h3 {
        font-size: 11px;
        margin-bottom: 0.5rem;
    }
    
    .promo-card p {
        font-size: 11px;
        margin-bottom: 0.5rem;
    }
    
    .promo-card .btn {
        font-size: 11px;
        padding: 0.4rem 0.8rem;
    }
    
    .promo-card small {
        font-size: 11px;
    }
    
    .promo-card .h4 {
        font-size: 11px;
    }
    
    .promo-card .badge {
        padding: 0.3rem 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .package-card .card-body {
        padding: 0.6rem;
    }
    
    .package-card h6 {
        font-size: 10px;
        margin-bottom: 0.2rem;
        line-height: 1.2;
    }
    
    .package-card .h5 {
        font-size: 11px;
        margin-bottom: 0.1rem;
    }
    
    .package-card .btn {
        font-size: 9px;
        padding: 0.25rem 0.2rem;
    }
    
    .package-card small {
        font-size: 9px;
    }
    
    .package-icon {
        width: 30px;
        height: 30px;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
    }
    
    .info-card .card-body {
        padding: 0.6rem;
    }
    
    .info-card h6 {
        font-size: 11px;
        margin-bottom: 0.3rem;
    }
    
    .info-card small, .info-card p, .info-card li, .info-card span {
        font-size: 10px;
    }
    
    .info-card .btn {
        font-size: 10px;
        padding: 0.3rem 0.6rem;
    }
    
    .info-card .stats-icon {
        width: 30px;
        height: 30px;
        font-size: 0.9rem;
        margin-bottom: 0.3rem;
    }
    
    .badge {
        font-size: 9px;
    }
    
    .card-body h6 {
        font-size: 11px;
        margin-bottom: 0.3rem;
    }
    
    .card-body p, .card-body small, .card-body span {
        font-size: 10px;
        margin-bottom: 0.3rem;
    }
    
    .row.mb-4 {
        margin-bottom: 0.75rem !important;
    }
    
    .row.mb-3 {
        margin-bottom: 0.5rem !important;
    }
}
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <div class="row align-items-center">
            <div class="col-12">
                <h5 class="mb-2 fw-bold">Halo, {{ auth()->user()->name }}! 👋</h5>
                <p class="mb-0 opacity-90">Kelola pesanan laundry Anda dengan mudah</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-3">
    <div class="col-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-receipt"></i>
            </div>
            <h4 class="mb-1">{{ $totalPesanan }}</h4>
            <p class="text-muted mb-0 small">Total Pesanan</p>
        </div>
    </div>
    <div class="col-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="bi bi-clock"></i>
            </div>
            <h4 class="mb-1">{{ $pesananAktif }}</h4>
            <p class="text-muted mb-0 small">Pesanan Aktif</p>
        </div>
    </div>
    <div class="col-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                <i class="bi bi-check-circle"></i>
            </div>
            <h4 class="mb-1">{{ $pesananSelesai }}</h4>
            <p class="text-muted mb-0 small">Pesanan Selesai</p>
        </div>
    </div>
    <div class="col-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333;">
                <i class="bi bi-gift"></i>
            </div>
            <h4 class="mb-1">{{ $promoTersedia }}</h4>
            <p class="text-muted mb-0 small">Promo Tersedia</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<h6 class="section-title">Aksi Cepat</h6>
<div class="row mb-3">
    <div class="col-4">
        <a href="{{ route('pelanggan.order') }}" class="quick-action-card d-block">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-plus-circle"></i>
            </div>
            <h6 class="fw-bold mb-1 small">Pesan Laundry</h6>
            <p class="text-muted mb-0" style="font-size: 9px;">Buat pesanan baru</p>
        </a>
    </div>
    <div class="col-4">
        <a href="{{ route('pelanggan.riwayat', ['tab' => 'pesanan']) }}" class="quick-action-card d-block">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="bi bi-clock-history"></i>
            </div>
            <h6 class="fw-bold mb-1 small">Pesanan Saya</h6>
            <p class="text-muted mb-0" style="font-size: 9px;">Lihat pesanan</p>
        </a>
    </div>
    <div class="col-4">
        <button class="quick-action-card w-100 border-0" onclick="scrollToPromo()">
            <div class="stats-icon mx-auto" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                <i class="bi bi-gift"></i>
            </div>
            <h6 class="fw-bold mb-1 small">Lihat Promo</h6>
            <p class="text-muted mb-0" style="font-size: 9px;">Klaim promo</p>
        </button>
    </div>
</div>

<!-- Pesanan Saya -->
@if($pesananSaya && $pesananSaya->count() > 0)
<h6 class="section-title">Pesanan Saya</h6>
@foreach($pesananSaya->take(2) as $transaksi)
<div class="card border-0 shadow-sm mb-2">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
                <h6 class="fw-bold mb-1 small">{{ $transaksi->kode_invoice }}</h6>
                <small class="text-muted d-block">{{ $transaksi->created_at->format('d M Y, H:i') }}</small>
            </div>
            <div>
                @if($transaksi->status_transaksi === 'request_jemput')
                    <span class="badge bg-warning text-dark" style="font-size: 9px;">Menunggu</span>
                @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                    <span class="badge bg-info" style="font-size: 9px;">Dijemput</span>
                @elseif($transaksi->status_transaksi === 'proses_cuci')
                    <span class="badge bg-primary" style="font-size: 9px;">Dicuci</span>
                @elseif($transaksi->status_transaksi === 'siap_antar')
                    <span class="badge bg-success" style="font-size: 9px;">Siap Antar</span>
                @endif
            </div>
        </div>
        <p class="text-success fw-bold mb-0">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
    </div>
</div>
@endforeach
<div class="text-center mb-3">
    <a href="{{ route('pelanggan.riwayat', ['tab' => 'pesanan']) }}" class="btn btn-outline-primary btn-sm">Lihat Pesanan yang sedang berjalan</a>
</div>
@endif

<!-- Promo Carousel -->
@if($promos && $promos->count() > 0)
<div id="promo-section" class="mb-3">
    <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #764ba2 0%, #667eea 100%); color: white;">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-8">
                    <h6 class="fw-bold mb-2">Lihat Promo</h6>
                    <p class="mb-2 small">Klaim promo menarik</p>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#promoModal">Klaim Sekarang</button>
                </div>
                <div class="col-4 text-end">
                    <i class="bi bi-gift" style="font-size: 4rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Promo Modal -->
<div class="modal fade" id="promoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Promo Tersedia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @foreach($promos as $promo)
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $promo->judul }}</h6>
                        <p class="small mb-2">{{ $promo->deskripsi }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success">{{ $promo->diskon_text }}</span>
                            <button id="btn-klaim-{{ $promo->id }}" class="btn btn-primary btn-sm" onclick="klaimPromo({{ $promo->id }})">
                                <span class="btn-text">Klaim</span>
                                <span class="btn-loading d-none">
                                    <span class="spinner-border spinner-border-sm"></span>
                                </span>
                            </button>
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
<h6 class="section-title">Paket Laundry</h6>
<div class="row mb-3">
    <div class="col-6 mb-3">
        <div class="package-card">
            <div class="card-body text-center p-3">
                <div class="package-icon mx-auto mb-2">
                    <i class="bi bi-fire"></i>
                </div>
                <h6 class="fw-bold mb-2 small">Cuci Kering + Setrika</h6>
                <div class="mb-2">
                    <span class="h5 text-success fw-bold d-block mb-0">Rp 7.000</span>
                    <small class="text-muted">per kg</small>
                </div>
                <a href="{{ route('pelanggan.order', ['paket' => 'cuci-kering-setrika']) }}" class="btn btn-primary btn-sm w-100">Pilih</a>
            </div>
        </div>
    </div>
    <div class="col-6 mb-3">
        <div class="package-card">
            <div class="card-body text-center p-3">
                <div class="package-icon mx-auto mb-2">
                    <i class="bi bi-fire"></i>
                </div>
                <h6 class="fw-bold mb-2 small">Laundry Cepat</h6>
                <div class="mb-2">
                    <span class="h5 text-success fw-bold d-block mb-0">Rp 9.000</span>
                    <small class="text-muted">per kg</small>
                </div>
                <a href="{{ route('pelanggan.order', ['paket' => 'laundry-cepat']) }}" class="btn btn-primary btn-sm w-100">Pilih</a>
            </div>
        </div>
    </div>
    <div class="col-6 mb-3">
        <div class="package-card">
            <div class="card-body text-center p-3">
                <div class="package-icon mx-auto mb-2">
                    <i class="bi bi-fire"></i>
                </div>
                <h6 class="fw-bold mb-2 small">Setrika Wangi + Lipat</h6>
                <div class="mb-2">
                    <span class="h5 text-success fw-bold d-block mb-0">Rp 5.000</span>
                    <small class="text-muted">per kg</small>
                </div>
                <a href="{{ route('pelanggan.order', ['paket' => 'setrika-wangi-lipat']) }}" class="btn btn-primary btn-sm w-100">Pilih</a>
            </div>
        </div>
    </div>
    <div class="col-6 mb-3">
        <div class="package-card">
            <div class="card-body text-center p-3">
                <div class="package-icon mx-auto mb-2">
                    <i class="bi bi-fire"></i>
                </div>
                <h6 class="fw-bold mb-2 small">Cuci Kering</h6>
                <div class="mb-2">
                    <span class="h5 text-success fw-bold d-block mb-0">Rp 6.000</span>
                    <small class="text-muted">per kg</small>
                </div>
                <a href="{{ route('pelanggan.order', ['paket' => 'cuci-kering']) }}" class="btn btn-primary btn-sm w-100">Pilih</a>
            </div>
        </div>
    </div>
</div>

<!-- Paket Jemput & Antar -->
<h6 class="section-title">Paket Jemput & Antar</h6>
<div class="row mb-3">
    <div class="col-6 mb-3">
        <div class="package-card">
            <div class="card-body text-center p-3">
                <div class="package-icon mx-auto mb-2">
                    <i class="bi bi-fire"></i>
                </div>
                <h6 class="fw-bold mb-2 small">Cuci Express</h6>
                <div class="mb-2">
                    <span class="h5 text-success fw-bold d-block mb-0">Rp 13.000</span>
                    <small class="text-muted">per kg</small>
                </div>
                <a href="{{ route('pelanggan.order', ['paket' => 'cuci-express']) }}" class="btn btn-primary btn-sm w-100">Pilih</a>
            </div>
        </div>
    </div>
    <div class="col-6 mb-3">
        <div class="package-card">
            <div class="card-body text-center p-3">
                <div class="package-icon mx-auto mb-2">
                    <i class="bi bi-fire"></i>
                </div>
                <h6 class="fw-bold mb-2 small">Cuci Karpet & Bed Cover</h6>
                <div class="mb-2">
                    <span class="h5 text-success fw-bold d-block mb-0">Rp 20.000</span>
                    <small class="text-muted">per kg</small>
                </div>
                <a href="{{ route('pelanggan.order', ['paket' => 'cuci-karpet-bed-cover']) }}" class="btn btn-primary btn-sm w-100">Pilih</a>
            </div>
        </div>
    </div>
    <div class="col-6 mb-3">
        <div class="package-card">
            <div class="card-body text-center p-3">
                <div class="package-icon mx-auto mb-2">
                    <i class="bi bi-fire"></i>
                </div>
                <h6 class="fw-bold mb-2 small">Setrika Wangi + Lipat</h6>
                <div class="mb-2">
                    <span class="h5 text-success fw-bold d-block mb-0">Rp 7.500</span>
                    <small class="text-muted">per kg</small>
                </div>
                <a href="{{ route('pelanggan.order', ['paket' => 'setrika-wangi-lipat-2']) }}" class="btn btn-primary btn-sm w-100">Pilih</a>
            </div>
        </div>
    </div>
    <div class="col-6 mb-3">
        <div class="package-card">
            <div class="card-body text-center p-3">
                <div class="package-icon mx-auto mb-2">
                    <i class="bi bi-fire"></i>
                </div>
                <h6 class="fw-bold mb-2 small">Cuci Kering</h6>
                <div class="mb-2">
                    <span class="h5 text-success fw-bold d-block mb-0">Rp 6.000</span>
                    <small class="text-muted">per kg</small>
                </div>
                <a href="{{ route('pelanggan.order', ['paket' => 'cuci-kering-2']) }}" class="btn btn-primary btn-sm w-100">Pilih</a>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Layanan -->
<div class="info-card mb-3">
    <div class="card-body p-3">
        <h6 class="fw-bold mb-3">Paket Jemput & Antar</h6>
        <p class="small mb-2"><strong>A. Untuk Layanan Jemput & Antar (Pickup)</strong></p>
        <ol class="small ps-3 mb-3">
            <li class="mb-1">Pilih Paket Jemput & Antar: Pilih layanan yang bersesuaian dengan kebutuhan rumah tangga Anda</li>
            <li class="mb-1">Tentukan Lokasi: Masukkan alamat tempat penjemputan dan pengantaran</li>
            <li class="mb-1">Serahkan ke Kurir: Kurir akan tiba datang untuk menjemput di alamat yang telah ditentukan</li>
            <li class="mb-1">Pembayaran: Cek status pesanan di menu "Pesanan Saya" dan lakukan pembayaran setelah laundry selesai</li>
        </ol>
        
        <p class="small mb-2"><strong>B. Untuk Layanan Antar Sendiri (Self-Drop)</strong></p>
        <ol class="small ps-3">
            <li class="mb-1">Pilih Paket Laundry: Pilih layanan yang sesuai kebutuhan</li>
            <li class="mb-1">Antar ke Outlet: Bawa pakaian ke lokasi kami terdekat</li>
            <li class="mb-1">Proses Selesai: Pakaian akan segera diproses setelah tiba</li>
            <li class="mb-1">Ambil Selesai: Kurir akan menghubungi Anda saat laundry selesai atau Anda bisa ambil sendiri</li>
        </ol>
    </div>
</div>

<!-- Jam Operasional -->
<div class="info-card mb-3">
    <div class="card-body p-3">
        <h6 class="fw-bold mb-3"><i class="bi bi-clock text-success me-2"></i>Jam Operasional</h6>
        <div class="d-flex justify-content-between mb-2">
            <span class="small">Senin - Jumat</span>
            <span class="small text-muted">08:00 - 20:00</span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="small">Sabtu</span>
            <span class="small text-muted">08:00 - 18:00</span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="small">Minggu</span>
            <span class="small text-muted">09:00 - 17:00</span>
        </div>
        <hr class="my-2">
        <small class="text-muted">Penjemputan & Pengantaran sesuai jadwal</small>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <div class="info-card" style="border-left: 4px solid #dc3545;">
            <div class="card-body p-3">
                <h6 class="fw-bold mb-2 text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Barang Tidak Diterima
                </h6>
                <ul class="small ps-3 mb-0">
                    <li>Pakaian dalam</li>
                    <li>Barang kulit/suede</li>
                    <li>Noda cat/oli berat</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Tentang Kami -->
<div class="row">
    <div class="col-12">
        <div class="info-card" style="background: white; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            <div class="card-body p-3">
                <h6 class="fw-bold mb-3">Tentang Kami</h6>
                <div class="row align-items-center mb-3">
                    <div class="col-7">
                        <p class="text-muted mb-0 small" style="line-height: 1.5;">
                            JasaLaundry adalah layanan laundry antar-jemput terpercaya dengan pengalaman 3+ tahun. Kami menggunakan teknologi modern dan deterjen berkualitas untuk hasil terbaik. Mau laundry jadi lebih gampang? Yuk, cobain layanan kami! Kamu bisa pesan lewat aplikasi, terus kami jemput dan antar langsung ke rumahmu. Praktis banget, kan? Mau laundry jadi lebih gampang? Yuk, cobain layanan kami! Kamu bisa pesan lewat aplikasi, terus kami jemput dan antar langsung ke rumahmu. Praktis banget, kan? Jadi, tunggu apa lagi? Yuk, langsung aja cobain dan rasain kemudahan laundry bersama JasaLaundry!
                        </p>
                    </div>
                    <div class="col-5 text-center">
                        <img src="https://via.placeholder.com/150x100/667eea/ffffff?text=Laundry" alt="Laundry" class="img-fluid rounded" style="max-height: 100px;">
                    </div>
                </div>
                
                <h6 class="fw-bold mb-3">Mengapa Memilih Kami?</h6>
                <div class="row text-center mb-3">
                    <div class="col-3">
                        <div class="mb-2">
                            <i class="bi bi-bar-chart text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <small class="d-block fw-semibold">Kualitas Terjamin</small>
                    </div>
                    <div class="col-3">
                        <div class="mb-2">
                            <i class="bi bi-shield-check text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <small class="d-block fw-semibold">Fleksibilitas Layanan</small>
                    </div>
                    <div class="col-3">
                        <div class="mb-2">
                            <i class="bi bi-clock text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <small class="d-block fw-semibold">Kecepatan & Ketepatan</small>
                    </div>
                    <div class="col-3">
                        <div class="mb-2">
                            <i class="bi bi-headset text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <small class="d-block fw-semibold">Transparan Status</small>
                    </div>
                </div>
                
                <div class="text-center">
                    <h6 class="fw-bold mb-2">Lokasi Kami</h6>
                    <p class="text-muted mb-0 small">Cirebon, Jawa Barat, Indonesia<br>Cirebon, Jawa Timur 61213</p>
                </div>
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
                const modal = bootstrap.Modal.getInstance(document.getElementById('promoModal'));
                if (modal) modal.hide();
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
    const promoSection = document.getElementById('promo-section');
    if (promoSection) {
        promoSection.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    } else {
        alert('Belum ada promo tersedia saat ini.');
    }
}
</script>
@endsection