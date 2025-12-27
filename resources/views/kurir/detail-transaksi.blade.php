@extends('layouts.app')

@section('title', 'Detail Tugas')

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
    
    .detail-card {
        border: none;
        border-radius: 16px;
        background: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
    }
    
    .info-item {
        padding: 1rem;
        border-radius: 12px;
        background: #f8fafc;
        margin-bottom: 1rem;
        border-left: 4px solid #3b82f6;
    }
    
    .timeline {
        position: relative;
        padding-left: 40px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #e2e8f0, #cbd5e1);
        border-radius: 2px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #e2e8f0;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }
    
    .timeline-item.active .timeline-marker {
        background: linear-gradient(135deg, #f59e0b, #f97316);
        animation: pulse 2s infinite;
    }
    
    .timeline-item.completed .timeline-marker {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .timeline-content {
        background: white;
        padding: 1.25rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-left: 3px solid #e2e8f0;
    }
    
    .timeline-item.active .timeline-content {
        border-left-color: #f59e0b;
        background: #fffbeb;
    }
    
    .timeline-item.completed .timeline-content {
        border-left-color: #10b981;
        background: #f0fdf4;
    }
    
    .action-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
    }
    
    .status-badge-large {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
        100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }
    
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }
        .timeline {
            padding-left: 30px;
        }
        .timeline-marker {
            left: -25px;
            width: 16px;
            height: 16px;
        }
    }
</style>

<!-- Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2 fw-bold"><i class="bi bi-clipboard-check"></i> Detail Tugas</h1>
            <p class="mb-0 opacity-90">{{ $transaksi->kode_invoice }} - {{ $transaksi->user->name }}</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('kurir.tugas') }}" class="btn btn-light">
                <i class="bi bi-arrow-left"></i> Kembali ke Tugas
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-8">
        <!-- Informasi Pelanggan -->
        <div class="detail-card">
            <div class="card-header-custom">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-circle text-primary"></i> Informasi Pelanggan</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <strong class="text-primary">Kode Invoice</strong><br>
                            <span class="h6 text-dark">{{ $transaksi->kode_invoice }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <strong class="text-primary">Tanggal Pesanan</strong><br>
                            <span class="text-dark">{{ $transaksi->created_at->format('d F Y, H:i') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <strong class="text-primary">Nama Pelanggan</strong><br>
                            <span class="text-dark">{{ $transaksi->user->name }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <strong class="text-primary">Telepon</strong><br>
                            <a href="tel:{{ $transaksi->user->phone }}" class="text-success text-decoration-none fw-medium">
                                <i class="bi bi-telephone"></i> {{ $transaksi->user->phone }}
                            </a>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="info-item">
                            <strong class="text-primary">Alamat Penjemputan/Pengantaran</strong><br>
                            <span class="text-dark">{{ $transaksi->alamat_jemput }}</span><br>
                            <a href="https://maps.google.com/?q={{ urlencode($transaksi->alamat_jemput) }}" 
                               target="_blank" class="btn btn-outline-info btn-sm mt-2">
                                <i class="bi bi-geo-alt"></i> Buka di Google Maps
                            </a>
                        </div>
                    </div>
                    @if($transaksi->catatan)
                        <div class="col-12">
                            <div class="alert alert-warning border-0" style="border-radius: 12px;">
                                <h6 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Catatan Khusus</h6>
                                <p class="mb-0">{{ $transaksi->catatan }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Paket -->
        <div class="detail-card">
            <div class="card-header-custom">
                <h5 class="mb-0 fw-bold"><i class="bi bi-box text-success"></i> Detail Paket Laundry</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold">Paket</th>
                                <th class="fw-bold">Jumlah</th>
                                <th class="fw-bold">Harga Satuan</th>
                                <th class="fw-bold text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->detailTransaksis as $detail)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $detail->paket->nama_paket }}</span>
                                    </td>
                                    <td>{{ $detail->jumlah }} {{ $detail->paket->satuan }}</td>
                                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end fw-medium">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            @if($transaksi->diskon > 0)
                                <tr>
                                    <td colspan="3" class="fw-bold">Subtotal:</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($transaksi->total_harga + $transaksi->diskon, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="text-danger">
                                    <td colspan="3" class="fw-bold">Diskon:</td>
                                    <td class="text-end fw-bold">-Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                            <tr class="table-success">
                                <td colspan="3" class="fw-bold fs-5">Total Pembayaran:</td>
                                <td class="text-end fw-bold fs-5">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 mt-3 mt-lg-0">
        <!-- Status Timeline -->
        <div class="detail-card">
            <div class="card-header-custom">
                <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history text-warning"></i> Timeline Status</h5>
            </div>
            <div class="card-body p-4">
                <div class="timeline">
                    <div class="timeline-item completed">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6 class="fw-bold mb-1">📝 Pesanan Dibuat</h6>
                            <small class="text-muted">{{ $transaksi->created_at->format('d F Y, H:i') }}</small>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $transaksi->status_transaksi === 'dijemput_kurir' ? 'active' : (in_array($transaksi->status_transaksi, ['proses_cuci', 'siap_antar', 'selesai']) ? 'completed' : '') }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6 class="fw-bold mb-1">🚚 Dijemput Kurir</h6>
                            @if($transaksi->tanggal_jemput)
                                <small class="text-muted">{{ $transaksi->tanggal_jemput->format('d F Y, H:i') }}</small>
                            @else
                                <small class="text-muted">Menunggu penjemputan</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $transaksi->status_transaksi === 'proses_cuci' ? 'active' : (in_array($transaksi->status_transaksi, ['siap_antar', 'selesai']) ? 'completed' : '') }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6 class="fw-bold mb-1">🧽 Proses Cuci</h6>
                            @if($transaksi->tanggal_proses_cuci)
                                <small class="text-muted d-block">{{ $transaksi->tanggal_proses_cuci->format('d F Y, H:i') }}</small>
                            @endif
                            @if($transaksi->berat_aktual)
                                @php
                                    $paket = $transaksi->detailTransaksis->first()->paket;
                                    $labelText = $paket->satuan === 'kg' ? 'Berat' : 'Jumlah';
                                @endphp
                                <span class="badge bg-info text-white mt-1">
                                    {{ $labelText }}: {{ $transaksi->berat_aktual }} {{ $paket->satuan }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $transaksi->status_transaksi === 'siap_antar' ? 'active' : ($transaksi->status_transaksi === 'selesai' ? 'completed' : '') }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6 class="fw-bold mb-1">📦 Siap Diantar</h6>
                            @if($transaksi->tanggal_siap_antar)
                                <small class="text-muted">{{ $transaksi->tanggal_siap_antar->format('d F Y, H:i') }}</small>
                            @else
                                <small class="text-muted">Menunggu siap antar</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $transaksi->status_transaksi === 'selesai' ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6 class="fw-bold mb-1">✅ Selesai</h6>
                            @if($transaksi->tanggal_selesai)
                                <small class="text-muted">{{ $transaksi->tanggal_selesai->format('d F Y, H:i') }}</small>
                            @else
                                <small class="text-muted">Belum selesai</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Kurir -->
        <div class="detail-card">
            <div class="card-header-custom">
                <h5 class="mb-0 fw-bold"><i class="bi bi-tools text-info"></i> Aksi Kurir</h5>
            </div>
            <div class="card-body p-4">
                <div class="action-card">
                    @if($transaksi->status_transaksi === 'siap_antar')
                        <div class="mb-3">
                            <span class="status-badge-large bg-success text-white">
                                <i class="bi bi-box-arrow-up"></i> Siap untuk Diantar
                            </span>
                        </div>
                        <form method="POST" action="{{ route('kurir.transaksi.status', $transaksi) }}" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status_transaksi" value="selesai">
                            <button type="submit" class="btn btn-success btn-lg w-100" 
                                    onclick="return confirm('Konfirmasi pengantaran selesai?')">
                                <i class="bi bi-check-circle"></i> Selesai Antar
                            </button>
                        </form>
                    @elseif($transaksi->status_transaksi === 'selesai')
                        <div class="mb-3">
                            <span class="status-badge-large bg-dark text-white">
                                <i class="bi bi-check-circle"></i> Pengantaran Selesai
                            </span>
                        </div>
                    @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                        <div class="mb-3">
                            <span class="status-badge-large bg-warning text-dark">
                                <i class="bi bi-clock"></i> Menunggu Proses Cuci
                            </span>
                        </div>
                    @else
                        <div class="mb-3">
                            <span class="status-badge-large bg-primary text-white">
                                <i class="bi bi-info-circle"></i> Dalam Proses
                            </span>
                        </div>
                    @endif
                    
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
                    
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($message) }}" 
                       target="_blank" class="btn btn-success btn-lg w-100">
                        <i class="bi bi-whatsapp"></i> WhatsApp Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection