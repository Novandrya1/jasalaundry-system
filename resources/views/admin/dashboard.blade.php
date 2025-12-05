@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row fade-in-up">
    <div class="col-12 mb-4">
        <h1 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</h1>
        <p class="welcome-text fs-5">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong> 👋</p>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row mb-5">
    <div class="col-6 col-lg-3 mb-4">
        <div class="card stats-card text-white fade-in-up stagger-1" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-icon mb-3">
                            <i class="bi bi-calendar-day fs-4"></i>
                        </div>
                        <h2 class="fw-bold mb-1">{{ $totalPesananHariIni }}</h2>
                        <p class="mb-0 opacity-90">Pesanan Hari Ini</p>
                    </div>
                    <div class="text-end opacity-75">
                        <i class="bi bi-trending-up fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-6 col-lg-3 mb-4">
        <div class="card stats-card text-white fade-in-up stagger-2" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-icon mb-3">
                            <i class="bi bi-exclamation-circle fs-4"></i>
                        </div>
                        <h2 class="fw-bold mb-1">{{ $pesananBaru }}</h2>
                        <p class="mb-0 opacity-90">Pesanan Baru</p>
                    </div>
                    <div class="text-end opacity-75">
                        <i class="bi bi-bell fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-6 col-lg-3 mb-4">
        <div class="card stats-card text-white fade-in-up stagger-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-icon mb-3">
                            <i class="bi bi-currency-dollar fs-4"></i>
                        </div>
                        <h3 class="fw-bold mb-1 fs-5">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h3>
                        <p class="mb-0 opacity-90">Pendapatan Bulan Ini</p>
                    </div>
                    <div class="text-end opacity-75">
                        <i class="bi bi-graph-up fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-6 col-lg-3 mb-4">
        <div class="card stats-card text-white fade-in-up stagger-4" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stats-icon mb-3">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <h2 class="fw-bold mb-1">{{ $totalPelanggan }}</h2>
                        <p class="mb-0 opacity-90">Total Pelanggan</p>
                    </div>
                    <div class="text-end opacity-75">
                        <i class="bi bi-person-check fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Menu Cepat -->
<div class="row mb-5">
    <div class="col-12 mb-4">
        <h2 class="section-title"><i class="bi bi-lightning-charge me-2"></i>Menu Cepat</h2>
    </div>
    
    <div class="col-6 col-lg-4 mb-4">
        <div class="card menu-card h-100 fade-in-up stagger-1">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px;">
                        <i class="bi bi-box fs-1 text-white"></i>
                    </div>
                </div>
                <h5 class="fw-semibold mb-2">Kelola Paket</h5>
                <p class="text-muted small mb-3">Tambah, edit, atau hapus paket laundry</p>
                <a href="{{ route('admin.paket.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right me-1"></i>Kelola Paket
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-6 col-lg-4 mb-4">
        <div class="card menu-card h-100 fade-in-up stagger-2">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 20px;">
                        <i class="bi bi-receipt fs-1 text-white"></i>
                    </div>
                </div>
                <h5 class="fw-semibold mb-2">Kelola Transaksi</h5>
                <p class="text-muted small mb-3">Proses pesanan dan update status</p>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right me-1"></i>Kelola Transaksi
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-6 col-lg-4 mb-4">
        <div class="card menu-card h-100 fade-in-up stagger-3">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 20px;">
                        <i class="bi bi-people fs-1 text-white"></i>
                    </div>
                </div>
                <h5 class="fw-semibold mb-2">Kelola Kurir</h5>
                <p class="text-muted small mb-3">Tambah dan kelola data kurir</p>
                <a href="{{ route('admin.kurir.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right me-1"></i>Kelola Kurir
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-6 col-lg-4 mb-4">
        <div class="card menu-card h-100 fade-in-up stagger-4">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 20px;">
                        <i class="bi bi-clock-history fs-1 text-white"></i>
                    </div>
                </div>
                <h5 class="fw-semibold mb-2">Riwayat & Laporan</h5>
                <p class="text-muted small mb-3">Lihat riwayat dan cetak laporan</p>
                <a href="{{ route('admin.riwayat.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right me-1"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-6 col-lg-4 mb-4">
        <div class="card menu-card h-100 fade-in-up stagger-1">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 20px;">
                        <i class="bi bi-gift fs-1 text-white"></i>
                    </div>
                </div>
                <h5 class="fw-semibold mb-2">Kelola Promo</h5>
                <p class="text-muted small mb-3">Buat dan kelola promo diskon</p>
                <a href="{{ route('admin.promo.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right me-1"></i>Kelola Promo
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-6 col-lg-4 mb-4">
        <div class="card menu-card h-100 fade-in-up stagger-2">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center position-relative" 
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px;">
                        <i class="bi bi-check-circle fs-1 text-white"></i>
                        @php
                            $pendingClaims = \App\Models\PromoClaim::where('status', 'pending')->count();
                        @endphp
                        @if($pendingClaims > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $pendingClaims }}
                            </span>
                        @endif
                    </div>
                </div>
                <h5 class="fw-semibold mb-2">Validasi Promo</h5>
                <p class="text-muted small mb-3">Setujui atau tolak klaim promo</p>
                <a href="{{ route('admin.promo-claim.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right me-1"></i>Validasi Promo
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card fade-in-up">
            <div class="card-header border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="section-title mb-0"><i class="bi bi-clock-history me-2"></i>Transaksi Terbaru</h3>
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye me-1"></i>Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body pt-3">
                @if($transaksiTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="fw-semibold">Kode Invoice</th>
                                    <th class="fw-semibold">Pelanggan</th>
                                    <th class="fw-semibold">Paket</th>
                                    <th class="fw-semibold">Status</th>
                                    <th class="fw-semibold">Total</th>
                                    <th class="fw-semibold">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiTerbaru as $transaksi)
                                    <tr>
                                        <td>
                                            <span class="fw-semibold text-primary">{{ $transaksi->kode_invoice }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 10px;">
                                                        <i class="bi bi-person text-white"></i>
                                                    </div>
                                                </div>
                                                <span class="fw-medium">{{ $transaksi->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @foreach($transaksi->detailTransaksis as $detail)
                                                <span class="badge bg-light text-dark me-1">{{ $detail->paket->nama_paket }}</span>
                                                @if(!$loop->last)<br>@endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($transaksi->status_transaksi === 'request_jemput')
                                                <span class="badge" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">Menunggu Penjemputan</span>
                                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                                <span class="badge" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">Dijemput Kurir</span>
                                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">Sedang Dicuci</span>
                                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                                <span class="badge" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">Siap Diantar</span>
                                            @elseif($transaksi->status_transaksi === 'selesai')
                                                <span class="badge bg-dark">Selesai</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $transaksi->created_at->format('d/m/Y') }}</span><br>
                                            <small class="text-muted">{{ $transaksi->created_at->format('H:i') }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-inbox" style="font-size: 4rem; color: #e2e8f0;"></i>
                        </div>
                        <h5 class="text-muted">Belum ada transaksi</h5>
                        <p class="text-muted">Transaksi akan muncul di sini setelah pelanggan melakukan pemesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection