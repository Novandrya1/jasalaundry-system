@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="row">
        <!-- Left Sidebar - Summary -->
        <div class="col-lg-4 col-xl-3 mb-4 order-2 order-lg-1">
            <div class="sticky-top" style="top: 100px;">
                <!-- Header -->
                <div class="text-center mb-3 mb-lg-4">
                    <div class="order-icon mb-2 mb-lg-3">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h3 class="fw-bold mb-1 mb-lg-2 h4 h-lg-3">Riwayat Pesanan</h3>
                    <p class="text-muted small">Semua pesanan laundry Anda</p>
                </div>

                <!-- Quick Stats -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Statistik</h6>
                    </div>
                    <div class="card-body">
                        <div class="summary-item">
                            <span class="text-muted">Total Pesanan:</span>
                            <span class="fw-semibold">{{ $transaksis->total() }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="text-muted">Halaman:</span>
                            <span class="fw-semibold text-primary">{{ $transaksis->currentPage() }} dari {{ $transaksis->lastPage() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="info-card">
                    <div class="info-header">
                        <i class="bi bi-lightning"></i>
                        <span>Aksi Cepat</span>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('pelanggan.order') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-2"></i>Pesan Baru
                        </a>
                        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-house me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content - History List -->
        <div class="col-lg-8 col-xl-9 order-1 order-lg-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 p-md-4 p-lg-5">
                    @forelse($transaksis as $transaksi)
                        @php
                            $statusClass = '';
                            $statusIcon = '';
                            $statusBg = '';
                            
                            switch($transaksi->status_transaksi) {
                                case 'request_jemput':
                                    $statusClass = 'status-request';
                                    $statusIcon = 'bi-clock';
                                    $statusBg = 'bg-warning bg-opacity-10 text-warning';
                                    break;
                                case 'dijemput_kurir':
                                    $statusClass = 'status-dijemput';
                                    $statusIcon = 'bi-truck';
                                    $statusBg = 'bg-info bg-opacity-10 text-info';
                                    break;
                                case 'proses_cuci':
                                    $statusClass = 'status-proses';
                                    $statusIcon = 'bi-arrow-repeat';
                                    $statusBg = 'bg-primary bg-opacity-10 text-primary';
                                    break;
                                case 'siap_antar':
                                    $statusClass = 'status-siap';
                                    $statusIcon = 'bi-box-arrow-up';
                                    $statusBg = 'bg-success bg-opacity-10 text-success';
                                    break;
                                case 'selesai':
                                    $statusClass = 'status-selesai';
                                    $statusIcon = 'bi-check-circle';
                                    $statusBg = 'bg-dark bg-opacity-10 text-dark';
                                    break;
                            }
                        @endphp
                        
                        <div class="history-item mb-4">
                            <div class="d-flex align-items-start">
                                <div class="status-icon {{ $statusBg }} me-3">
                                    <i class="bi {{ $statusIcon }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $transaksi->kode_invoice }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>{{ $transaksi->created_at->format('d F Y, H:i') }}
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2 mt-2 mt-md-0">
                                            @if($transaksi->status_transaksi === 'request_jemput')
                                                <span class="status-badge bg-warning text-dark">⏳ Menunggu Penjemputan</span>
                                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                                <span class="status-badge bg-info text-white">🚛 Dijemput Kurir</span>
                                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                <span class="status-badge bg-primary text-white">🧽 Sedang Dicuci</span>
                                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                                <span class="status-badge bg-success text-white">📦 Siap Diantar</span>
                                            @elseif($transaksi->status_transaksi === 'selesai')
                                                <span class="status-badge bg-dark text-white">✅ Selesai</span>
                                            @endif
                                            
                                            @if($transaksi->status_bayar === 'belum_bayar')
                                                <span class="status-badge bg-danger text-white">💳 Belum Bayar</span>
                                            @else
                                                <span class="status-badge bg-success text-white">💰 Lunas</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-8">
                                            <div class="info-item">
                                                <small class="text-muted d-block">
                                                    <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($transaksi->alamat_jemput, 80) }}
                                                </small>
                                            </div>
                                            
                                            @if($transaksi->catatan)
                                                <div class="info-item">
                                                    <small class="text-muted d-block">
                                                        <i class="bi bi-chat-text me-1"></i><em>{{ $transaksi->catatan }}</em>
                                                    </small>
                                                </div>
                                            @endif
                                            
                                            <div class="d-flex flex-wrap gap-1 mb-2">
                                                @foreach($transaksi->detailTransaksis as $detail)
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="bi bi-box me-1"></i>{{ $detail->paket->nama_paket }}
                                                    </span>
                                                @endforeach
                                            </div>
                                            
                                            @if($transaksi->kurir)
                                                <div class="info-item">
                                                    <small class="text-muted d-block">
                                                        <i class="bi bi-person-circle me-1"></i>Kurir: {{ $transaksi->kurir->name }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="col-md-4 text-md-end">
                                            @if($transaksi->berat_aktual)
                                                <div class="mb-2">
                                                    <span class="badge bg-info text-white">
                                                        <i class="bi bi-weight me-1"></i>{{ $transaksi->berat_aktual }} kg
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            <div class="mb-2">
                                                <h6 class="text-success mb-0">
                                                    Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                                </h6>
                                            </div>
                                            
                                            <a href="{{ route('pelanggan.transaksi.show', $transaksi) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i>Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(!$loop->last)
                            <hr class="my-4">
                        @endif
                    @empty
                        <div class="empty-state text-center py-5">
                            <div class="empty-icon mb-3">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <h5 class="text-muted mb-2">Belum ada riwayat pesanan</h5>
                            <p class="text-muted mb-4">Anda belum pernah melakukan pemesanan laundry</p>
                            <a href="{{ route('pelanggan.order') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Pesan Sekarang
                            </a>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if($transaksis->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $transaksis->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Layout */
.order-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin: 0 auto;
}

/* Summary */
.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #f1f5f9;
}

.summary-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

/* Info Card */
.info-card {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 1px solid #f59e0b;
    border-radius: 12px;
    padding: 1.25rem;
}

.info-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #92400e;
    margin-bottom: 0.75rem;
}

/* History Items */
.history-item {
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 1.5rem;
}

.history-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.status-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 0.75rem;
    white-space: nowrap;
}

.info-item {
    margin-bottom: 0.5rem;
}

/* Empty State */
.empty-state {
    padding: 3rem 2rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 2rem;
    margin: 0 auto;
}

/* Pagination */
.pagination svg,
.pagination .w-5,
.pagination .h-5 {
    width: 10px !important;
    height: 10px !important;
}
.pagination .inline-flex {
    padding: 0.25rem 0.4rem !important;
}
.pagination .px-2 {
    padding-left: 0.25rem !important;
    padding-right: 0.25rem !important;
}
.pagination .py-2 {
    padding-top: 0.25rem !important;
    padding-bottom: 0.25rem !important;
}

/* Responsive */
@media (max-width: 991px) {
    .sticky-top {
        position: static !important;
    }
}

@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .order-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .status-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .status-badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .info-card {
        padding: 1rem;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .status-badge {
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
    }
    
    .info-card {
        padding: 0.75rem;
    }
}
</style>
@endsection