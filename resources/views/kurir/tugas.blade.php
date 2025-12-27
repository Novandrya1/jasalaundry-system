@extends('layouts.app')

@section('title', 'Tugas Kurir')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .filter-card {
        border: none;
        border-radius: 16px;
        background: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }
    
    .task-card {
        border: none;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        position: relative;
    }
    
    .task-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--status-color);
    }
    
    .task-card.status-dijemput::before { background: linear-gradient(90deg, #f59e0b, #f97316); }
    .task-card.status-proses::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .task-card.status-siap::before { background: linear-gradient(90deg, #10b981, #059669); }
    .task-card.status-selesai::before { background: linear-gradient(90deg, #6b7280, #374151); }
    
    .task-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }
    
    .status-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .action-btn {
        border-radius: 10px;
        padding: 0.5rem;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .empty-state i {
        font-size: 5rem;
        color: #cbd5e1;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }
        .status-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
        .action-btn {
            width: 35px;
            height: 35px;
        }
    }
</style>

<!-- Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2 fw-bold"><i class="bi bi-list-task"></i> Tugas Saya</h1>
            <p class="mb-0 opacity-90">Kelola semua tugas pengiriman Anda dengan efisien</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="d-flex align-items-center justify-content-md-end">
                <i class="bi bi-calendar-day me-2"></i>
                <span>{{ now()->format('d F Y') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="filter-card">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('kurir.tugas') }}">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-7 mb-3 mb-md-0">
                    <label for="status" class="form-label fw-medium">Filter Status Tugas</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="dijemput_kurir" {{ request('status') == 'dijemput_kurir' ? 'selected' : '' }}>
                            🚛 Tugas Baru (Dijemput Kurir)
                        </option>
                        <option value="proses_cuci" {{ request('status') == 'proses_cuci' ? 'selected' : '' }}>
                            🧽 Sedang Dicuci
                        </option>
                        <option value="siap_antar" {{ request('status') == 'siap_antar' ? 'selected' : '' }}>
                            📦 Siap Diantar
                        </option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                            ✅ Selesai
                        </option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('kurir.tugas') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Daftar Tugas -->
<div class="row">
    <div class="col-12">
        @if($transaksis->count() > 0)
            @foreach($transaksis as $transaksi)
                @php
                    $statusClass = '';
                    $statusIcon = '';
                    $statusBg = '';
                    $statusText = '';
                    
                    switch($transaksi->status_transaksi) {
                        case 'dijemput_kurir':
                            $statusClass = 'status-dijemput';
                            $statusIcon = 'bi-truck';
                            $statusBg = 'bg-warning bg-opacity-10 text-warning';
                            $statusText = 'bg-warning text-dark';
                            break;
                        case 'proses_cuci':
                            $statusClass = 'status-proses';
                            $statusIcon = 'bi-clock';
                            $statusBg = 'bg-primary bg-opacity-10 text-primary';
                            $statusText = 'bg-primary text-white';
                            break;
                        case 'siap_antar':
                            $statusClass = 'status-siap';
                            $statusIcon = 'bi-box-arrow-up';
                            $statusBg = 'bg-success bg-opacity-10 text-success';
                            $statusText = 'bg-success text-white';
                            break;
                        case 'selesai':
                            $statusClass = 'status-selesai';
                            $statusIcon = 'bi-check-circle';
                            $statusBg = 'bg-dark bg-opacity-10 text-dark';
                            $statusText = 'bg-dark text-white';
                            break;
                    }
                @endphp
                
                <div class="task-card {{ $statusClass }}">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-lg-8 col-md-7">
                                <div class="d-flex align-items-start">
                                    <div class="status-icon {{ $statusBg }} me-3">
                                        <i class="bi {{ $statusIcon }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <h5 class="mb-0 fw-bold me-3">{{ $transaksi->kode_invoice }}</h5>
                                            @if($transaksi->status_transaksi === 'dijemput_kurir')
                                                <span class="status-badge {{ $statusText }}">🚛 Tugas Baru</span>
                                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                <span class="status-badge {{ $statusText }}">🧽 Sedang Dicuci</span>
                                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                                <span class="status-badge {{ $statusText }}">📦 Siap Diantar</span>
                                            @elseif($transaksi->status_transaksi === 'selesai')
                                                <span class="status-badge {{ $statusText }}">✅ Selesai</span>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-2">
                                            <h6 class="mb-1 fw-medium">
                                                <i class="bi bi-person-circle text-primary"></i> {{ $transaksi->user->name }}
                                            </h6>
                                            <small class="text-muted">
                                                <i class="bi bi-telephone"></i> {{ $transaksi->user->phone }}
                                            </small>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <p class="mb-1 text-muted small">
                                                <i class="bi bi-geo-alt text-danger"></i> {{ $transaksi->alamat_jemput }}
                                            </p>
                                        </div>
                                        
                                        @if($transaksi->catatan)
                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="bi bi-chat-text"></i> <em>{{ $transaksi->catatan }}</em>
                                                </small>
                                            </div>
                                        @endif
                                        
                                        <div class="d-flex flex-wrap gap-1 mb-2">
                                            @foreach($transaksi->detailTransaksis as $detail)
                                                <span class="badge bg-light text-dark border">
                                                    <i class="bi bi-box"></i> {{ $detail->paket->nama_paket }}
                                                </span>
                                            @endforeach
                                        </div>
                                        
                                        @if($transaksi->berat_aktual)
                                            <div class="mt-2">
                                                <span class="badge bg-info text-white me-2">
                                                    <i class="bi bi-weight"></i> {{ $transaksi->berat_aktual }} kg
                                                </span>
                                                <span class="badge bg-success text-white">
                                                    <i class="bi bi-currency-dollar"></i> Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-5 mt-3 mt-md-0">
                                <div class="text-md-end">
                                    <small class="text-muted d-block mb-3">
                                        <i class="bi bi-clock"></i> {{ $transaksi->created_at->format('d/m/Y H:i') }}
                                    </small>
                                    
                                    <!-- Status Action -->
                                    @if($transaksi->status_transaksi === 'siap_antar')
                                        <form method="POST" action="{{ route('kurir.transaksi.status', $transaksi) }}" class="mb-3">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_transaksi" value="selesai">
                                            <button type="submit" class="btn btn-success w-100" 
                                                    onclick="return confirm('Konfirmasi pengantaran selesai?')">
                                                <i class="bi bi-check-circle"></i> Selesai Antar
                                            </button>
                                        </form>
                                    @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                        <div class="alert alert-warning py-2 mb-3">
                                            <small><i class="bi bi-info-circle"></i> Menunggu proses cuci</small>
                                        </div>
                                    @elseif($transaksi->status_transaksi === 'proses_cuci')
                                        <div class="alert alert-info py-2 mb-3">
                                            <small><i class="bi bi-clock"></i> Sedang dicuci</small>
                                        </div>
                                    @elseif($transaksi->status_transaksi === 'selesai')
                                        <div class="alert alert-success py-2 mb-3">
                                            <small><i class="bi bi-check-circle"></i> Pengantaran selesai</small>
                                        </div>
                                    @endif
                                    
                                    <!-- Action Buttons -->
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $transaksi->user->phone);
                                        if (substr($cleanPhone, 0, 1) === '0') {
                                            $cleanPhone = '62' . substr($cleanPhone, 1);
                                        }
                                        $message = "Halo {$transaksi->user->name}, saya kurir dari JasaLaundry untuk pesanan {$transaksi->kode_invoice}. ";
                                        if($transaksi->status_transaksi === 'dijemput_kurir') {
                                            $message .= "Saya akan datang untuk menjemput laundry Anda di {$transaksi->alamat_jemput}";
                                        } elseif($transaksi->status_transaksi === 'siap_antar') {
                                            $message .= "Laundry Anda sudah selesai, saya akan datang untuk mengantarkan ke {$transaksi->alamat_jemput}";
                                        } else {
                                            $message .= "Untuk update pesanan laundry Anda";
                                        }
                                    @endphp
                                    
                                    <div class="d-flex gap-2 justify-content-md-end">
                                        <a href="{{ route('kurir.transaksi.show', $transaksi) }}" 
                                           class="action-btn btn btn-outline-primary" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($message) }}" 
                                           target="_blank" class="action-btn btn btn-outline-success" title="WhatsApp">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                        <a href="https://maps.google.com/?q={{ urlencode($transaksi->alamat_jemput) }}" 
                                           target="_blank" class="action-btn btn btn-outline-info" title="Google Maps">
                                            <i class="bi bi-geo-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Pagination -->
            @if($transaksis->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $transaksis->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h4 class="text-muted mb-2">Belum ada tugas</h4>
                <p class="text-muted mb-4">Tugas akan muncul di sini setelah admin menugaskan Anda</p>
                <a href="{{ route('kurir.dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        @endif
    </div>
</div>
@endsection