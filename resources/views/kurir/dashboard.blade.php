@extends('layouts.app')

@section('title', 'Dashboard Kurir')

@section('content')
<link href="{{ asset('css/kurir-dashboard.css') }}" rel="stylesheet">
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .stat-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        background: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--card-color);
    }
    
    .stat-card.warning::before { background: linear-gradient(90deg, #f59e0b, #f97316); }
    .stat-card.primary::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .stat-card.success::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stat-card.info::before { background: linear-gradient(90deg, #06b6d4, #0891b2); }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .quick-action-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
        background: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .quick-action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        color: inherit;
        text-decoration: none;
    }
    
    .task-item {
        border: none;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .task-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .section-card {
        border: none;
        border-radius: 20px;
        background: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .section-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 1.5rem;
    }
    
    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
    
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .stat-number {
            font-size: 2rem;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
    }
</style>

<!-- Header Dashboard -->
<div class="dashboard-header dashboard-animation">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2 fw-bold">Dashboard Kurir</h1>
            <p class="mb-0 opacity-90">Selamat datang, {{ auth()->user()->name }}! Kelola tugas pengantaran Anda dengan efisien.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="d-flex align-items-center justify-content-md-end">
                <i class="bi bi-calendar-day me-2"></i>
                <span>{{ now()->format('d F Y') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4 dashboard-animation delay-1">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card warning">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-number text-warning">{{ $tugasBaru }}</div>
                        <p class="mb-0 text-muted fw-medium">Tugas Baru Hari Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card primary">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-number text-primary">{{ $tugasProses }}</div>
                        <p class="mb-0 text-muted fw-medium">Dalam Proses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card success">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-number text-success">{{ $tugasSelesai }}</div>
                        <p class="mb-0 text-muted fw-medium">Selesai Hari Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card info">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                        <i class="bi bi-list-task"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-number text-info">{{ $totalTugas }}</div>
                        <p class="mb-0 text-muted fw-medium">Total Tugas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4 dashboard-animation delay-2">
    <div class="col-12">
        <div class="section-card">
            <div class="section-header">
                <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-charge text-primary"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('kurir.tugas') }}" class="quick-action-card">
                            <div class="card-body text-center p-4">
                                <div class="stat-icon bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                                    <i class="bi bi-list-task"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Semua Tugas</h6>
                                <small class="text-muted">Lihat semua tugas</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('kurir.tugas', ['status' => 'dijemput_kurir']) }}" class="quick-action-card">
                            <div class="card-body text-center p-4">
                                <div class="stat-icon bg-warning bg-opacity-10 text-warning mx-auto mb-3">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Tugas Baru</h6>
                                <small class="text-muted">Penjemputan baru</small>
                                @if($tugasBaru > 0)
                                    <span class="badge bg-warning ms-2">{{ $tugasBaru }}</span>
                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('kurir.tugas', ['status' => 'siap_antar']) }}" class="quick-action-card">
                            <div class="card-body text-center p-4">
                                <div class="stat-icon bg-success bg-opacity-10 text-success mx-auto mb-3">
                                    <i class="bi bi-box-arrow-up"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Siap Antar</h6>
                                <small class="text-muted">Pengantaran</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('kurir.tugas', ['status' => 'selesai']) }}" class="quick-action-card">
                            <div class="card-body text-center p-4">
                                <div class="stat-icon bg-dark bg-opacity-10 text-dark mx-auto mb-3">
                                    <i class="bi bi-check-all"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Selesai</h6>
                                <small class="text-muted">Tugas selesai</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tugas Hari Ini -->
<div class="row dashboard-animation delay-3">
    <div class="col-12">
        <div class="section-card">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-day text-primary"></i> Tugas Hari Ini</h5>
                <div>
                    <a href="{{ route('kurir.tugas') }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="bi bi-clock-history"></i> Riwayat
                    </a>
                    <a href="{{ route('kurir.tugas') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-list-ul"></i> Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($transaksiTerbaru->count() > 0)
                    @foreach($transaksiTerbaru as $transaksi)
                        <div class="task-item">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-start">
                                            <div class="me-3">
                                                @if($transaksi->status_transaksi === 'dijemput_kurir')
                                                    <div class="stat-icon bg-warning bg-opacity-10 text-warning" style="width: 50px; height: 50px;">
                                                        <i class="bi bi-truck"></i>
                                                    </div>
                                                @elseif($transaksi->status_transaksi === 'siap_antar')
                                                    <div class="stat-icon bg-success bg-opacity-10 text-success" style="width: 50px; height: 50px;">
                                                        <i class="bi bi-box-arrow-up"></i>
                                                    </div>
                                                @elseif($transaksi->status_transaksi === 'selesai')
                                                    <div class="stat-icon bg-dark bg-opacity-10 text-dark" style="width: 50px; height: 50px;">
                                                        <i class="bi bi-check-circle"></i>
                                                    </div>
                                                @else
                                                    <div class="stat-icon bg-primary bg-opacity-10 text-primary" style="width: 50px; height: 50px;">
                                                        <i class="bi bi-clock"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">{{ $transaksi->kode_invoice }}</h6>
                                                <p class="mb-1 fw-medium">{{ $transaksi->user->name }}</p>
                                                <p class="mb-2 text-muted small">
                                                    <i class="bi bi-geo-alt"></i> {{ Str::limit($transaksi->alamat_jemput, 60) }}
                                                </p>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($transaksi->detailTransaksis as $detail)
                                                        <span class="badge bg-light text-dark border">{{ $detail->paket->nama_paket }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                        <div class="mb-2">
                                            @if($transaksi->status_transaksi === 'dijemput_kurir')
                                                <span class="status-badge bg-warning text-dark">Tugas Baru</span>
                                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                                <span class="status-badge bg-success text-white">Siap Antar</span>
                                            @elseif($transaksi->status_transaksi === 'selesai')
                                                <span class="status-badge bg-dark text-white">Selesai</span>
                                            @else
                                                <span class="status-badge bg-primary text-white">Dalam Proses</span>
                                            @endif
                                        </div>
                                        <small class="text-muted d-block mb-2">
                                            <i class="bi bi-clock"></i> {{ $transaksi->created_at->format('d/m/Y H:i') }}
                                        </small>
                                        <div class="d-flex gap-1 justify-content-md-end">
                                            <a href="{{ route('kurir.transaksi.show', $transaksi) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @php
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $transaksi->user->phone);
                                                if (substr($cleanPhone, 0, 1) === '0') {
                                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                                }
                                                $message = "Halo {$transaksi->user->name}, saya kurir dari JasaLaundry untuk pesanan {$transaksi->kode_invoice}.";
                                            @endphp
                                            <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($message) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                            <a href="https://maps.google.com/?q={{ urlencode($transaksi->alamat_jemput) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-geo-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="bi bi-calendar-x"></i>
                        <h5 class="text-muted mb-2">Belum ada tugas untuk hari ini</h5>
                        <p class="text-muted mb-3">Tugas akan muncul di sini setelah admin menugaskan Anda</p>
                        <a href="{{ route('kurir.tugas') }}" class="btn btn-outline-primary">
                            <i class="bi bi-clock-history"></i> Lihat Riwayat Tugas
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection