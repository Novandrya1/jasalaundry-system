@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="row">
        <!-- Left Sidebar - Transaction Summary -->
        <div class="col-lg-4 col-xl-3 mb-4 order-2 order-lg-1">
            <div class="sticky-top" style="top: 100px;">
                <!-- Header -->
                <div class="text-center mb-3">
                    <div class="transaction-icon mb-3">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Detail Transaksi</h4>
                    <p class="text-muted small">{{ $transaksi->kode_invoice }}</p>
                </div>

                <!-- Status Cards -->
                <div class="status-summary mb-3">
                    <div class="status-card">
                        <div class="status-header">Status Transaksi</div>
                        <div class="status-badge">
                            @if($transaksi->status_transaksi === 'request_jemput')
                                <span class="badge-warning"><i class="bi bi-clock"></i> Menunggu Penjemputan</span>
                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                <span class="badge-info"><i class="bi bi-truck"></i> Dijemput Kurir</span>
                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                <span class="badge-primary"><i class="bi bi-droplet"></i> Sedang Dicuci</span>
                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                <span class="badge-success"><i class="bi bi-check-circle"></i> Siap Diantar</span>
                            @elseif($transaksi->status_transaksi === 'selesai')
                                <span class="badge-dark"><i class="bi bi-check-all"></i> Selesai</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="status-card">
                        <div class="status-header">Status Pembayaran</div>
                        <div class="status-badge">
                            @if($transaksi->status_bayar === 'belum_bayar')
                                <span class="badge-danger"><i class="bi bi-clock"></i> Belum Bayar</span>
                            @else
                                <span class="badge-success"><i class="bi bi-check-circle"></i> Lunas</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="price-summary">
                    <div class="price-header">
                        <i class="bi bi-calculator"></i>
                        <span>Ringkasan Harga</span>
                    </div>
                    <div class="price-content">
                        <div class="price-item">
                            <span class="price-label">Subtotal:</span>
                            <span class="price-value">Rp {{ number_format($transaksi->detailTransaksis->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        @if($transaksi->diskon > 0)
                        <div class="price-item discount">
                            <span class="price-label">Diskon:</span>
                            <span class="price-value">-Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="price-total">
                            <span class="price-label">Total:</span>
                            <span class="price-value">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="timeline-card">
                    <div class="timeline-header">
                        <i class="bi bi-clock-history"></i>
                        <span>Timeline</span>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-item active">
                            <div class="timeline-dot"></div>
                            <div class="timeline-info">
                                <div class="timeline-title">Pesanan Dibuat</div>
                                <div class="timeline-date">{{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        
                        @if($transaksi->tanggal_jemput)
                        <div class="timeline-item active">
                            <div class="timeline-dot"></div>
                            <div class="timeline-info">
                                <div class="timeline-title">Dijemput Kurir</div>
                                <div class="timeline-date">{{ $transaksi->tanggal_jemput->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($transaksi->tanggal_proses_cuci)
                        <div class="timeline-item active">
                            <div class="timeline-dot"></div>
                            <div class="timeline-info">
                                <div class="timeline-title">Proses Cuci</div>
                                <div class="timeline-date">{{ $transaksi->tanggal_proses_cuci->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($transaksi->tanggal_siap_antar)
                        <div class="timeline-item active">
                            <div class="timeline-dot"></div>
                            <div class="timeline-info">
                                <div class="timeline-title">Siap Antar</div>
                                <div class="timeline-date">{{ $transaksi->tanggal_siap_antar->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($transaksi->tanggal_selesai)
                        <div class="timeline-item active">
                            <div class="timeline-dot"></div>
                            <div class="timeline-info">
                                <div class="timeline-title">Selesai</div>
                                <div class="timeline-date">{{ $transaksi->tanggal_selesai->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content - Details -->
        <div class="col-lg-8 col-xl-9 order-1 order-lg-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 p-md-4">
                    
                    <!-- Customer & Courier Info -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="info-section">
                                <div class="info-header">
                                    <i class="bi bi-person-circle"></i>
                                    <span>Informasi Pelanggan</span>
                                </div>
                                <div class="info-content">
                                    <div class="info-row">
                                        <span class="info-label">Nama:</span>
                                        <span class="info-value">{{ $transaksi->user->name }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Email:</span>
                                        <span class="info-value">{{ $transaksi->user->email }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Telepon:</span>
                                        <span class="info-value">{{ $transaksi->user->phone }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Alamat:</span>
                                        <span class="info-value">{{ $transaksi->user->address }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="info-section">
                                <div class="info-header">
                                    <i class="bi bi-truck"></i>
                                    <span>Informasi Kurir</span>
                                </div>
                                <div class="info-content">
                                    @if($transaksi->kurir)
                                        <div class="info-row">
                                            <span class="info-label">Nama:</span>
                                            <span class="info-value">{{ $transaksi->kurir->name }}</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Telepon:</span>
                                            <span class="info-value">{{ $transaksi->kurir->phone }}</span>
                                        </div>
                                    @else
                                        <div class="no-data">
                                            <i class="bi bi-exclamation-circle"></i>
                                            <span>Belum ada kurir yang ditugaskan</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address & Notes -->
                    <div class="address-section mb-4">
                        <div class="section-header">
                            <i class="bi bi-geo-alt"></i>
                            <span>Alamat & Catatan</span>
                        </div>
                        <div class="section-content">
                            <div class="address-item">
                                <div class="address-label">Alamat Penjemputan:</div>
                                <div class="address-value">{{ $transaksi->alamat_jemput }}</div>
                            </div>
                            
                            @if($transaksi->catatan)
                            <div class="notes-item">
                                <div class="notes-label">Catatan Khusus:</div>
                                <div class="notes-value">{{ $transaksi->catatan }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Package Details -->
                    <div class="package-section mb-4">
                        <div class="section-header">
                            <i class="bi bi-box"></i>
                            <span>Detail Paket & Harga</span>
                        </div>
                        <div class="section-content">
                            <div class="table-responsive">
                                <table class="table table-modern">
                                    <thead>
                                        <tr>
                                            <th>Paket</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transaksi->detailTransaksis as $detail)
                                        <tr>
                                            <td>
                                                <div class="package-info">
                                                    <div class="package-name">{{ $detail->paket->nama_paket }}</div>
                                                    @if($detail->paket->deskripsi)
                                                    <div class="package-desc">{{ $detail->paket->deskripsi }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="price-text">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                                                <span class="unit-text">/{{ $detail->paket->satuan }}</span>
                                            </td>
                                            <td>
                                                <span class="quantity-text">{{ $detail->jumlah }} {{ $detail->paket->satuan }}</span>
                                            </td>
                                            <td>
                                                <span class="subtotal-text">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Weight Info -->
                    @if($transaksi->berat_aktual)
                    <div class="weight-section mb-4">
                        <div class="section-header">
                            <i class="bi bi-scales"></i>
                            <span>Informasi Penimbangan</span>
                        </div>
                        <div class="section-content">
                            <div class="weight-info">
                                <div class="weight-item">
                                    <span class="weight-label">Berat Aktual:</span>
                                    <span class="weight-value">{{ $transaksi->berat_aktual }} kg</span>
                                </div>
                                <div class="weight-item">
                                    <span class="weight-label">Harga per kg:</span>
                                    <span class="weight-value">Rp {{ number_format($transaksi->detailTransaksis->first()->harga_satuan, 0, ',', '.') }}</span>
                                </div>
                                <div class="weight-calculation">
                                    {{ $transaksi->berat_aktual }} kg × Rp {{ number_format($transaksi->detailTransaksis->first()->harga_satuan, 0, ',', '.') }} = Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-flex flex-column flex-md-row gap-2 gap-md-3">
                        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary flex-fill order-3 order-md-1">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        @if($transaksi->status_transaksi !== 'selesai')
                        <a href="{{ route('admin.transaksi.edit', $transaksi) }}" class="btn btn-warning flex-fill order-2">
                            <i class="bi bi-pencil me-2"></i>Proses Transaksi
                        </a>
                        @endif
                        <button class="btn btn-success flex-fill order-1 order-md-3" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i>Cetak Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- =========================
     STRUK INVOICE - KHUSUS CETAK
========================= --}}
<div id="receipt-print" class="receipt-print">
    <div class="receipt-header">
        <div class="receipt-store">LAUNDRY</div>
        <div class="receipt-title">STRUK PEMBAYARAN</div>
        <div class="receipt-address">Terima kasih telah menggunakan layanan kami</div>
    </div>

    <div class="receipt-divider"></div>

    <div class="receipt-meta">
        <div class="receipt-row">
            <span>No. Invoice</span>
            <strong>{{ $transaksi->kode_invoice }}</strong>
        </div>
        <div class="receipt-row">
            <span>Tanggal</span>
            <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="receipt-row">
            <span>Pelanggan</span>
            <span>{{ $transaksi->user->name }}</span>
        </div>
        @if($transaksi->user->phone)
        <div class="receipt-row">
            <span>Telepon</span>
            <span>{{ $transaksi->user->phone }}</span>
        </div>
        @endif
    </div>

    <div class="receipt-divider"></div>

    <table class="receipt-items">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksis as $detail)
            <tr>
                <td class="item-name">
                    <span>{{ $detail->paket->nama_paket }}</span>
                    <small>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}/{{ $detail->paket->satuan }}</small>
                </td>
                <td class="item-qty">{{ $detail->jumlah }} {{ $detail->paket->satuan }}</td>
                <td class="item-total">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($transaksi->berat_aktual)
    <div class="receipt-extra">
        <span>Berat</span>
        <strong>{{ $transaksi->berat_aktual }} kg</strong>
    </div>
    @endif

    <div class="receipt-divider"></div>

    <div class="receipt-summary">
        <div class="receipt-row">
            <span>Subtotal</span>
            <span>Rp {{ number_format($transaksi->detailTransaksis->sum('subtotal'), 0, ',', '.') }}</span>
        </div>

        @if($transaksi->diskon > 0)
        <div class="receipt-row">
            <span>Diskon</span>
            <span>-Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="receipt-row receipt-grand-total">
            <strong>TOTAL</strong>
            <strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
        </div>
    </div>

    <div class="receipt-divider"></div>

    <div class="receipt-payment">
        <span>Status Pembayaran</span>
        <strong>
            {{ $transaksi->status_bayar === 'belum_bayar' ? 'BELUM BAYAR' : 'LUNAS' }}
        </strong>
    </div>

    @if($transaksi->catatan)
    <div class="receipt-note">
        <strong>Catatan:</strong>
        <span>{{ $transaksi->catatan }}</span>
    </div>
    @endif

    <div class="receipt-footer">
        <strong>TERIMA KASIH</strong>
        <span>Simpan struk ini sebagai bukti transaksi.</span>
    </div>
</div>

<style>
/* Transaction Icon */
.transaction-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin: 0 auto;
}

/* Status Summary */
.status-summary {
    display: grid;
    gap: 0.75rem;
}

.status-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
}

.status-header {
    font-size: 0.85rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.status-badge span {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.9rem;
}

.badge-warning { background: #fef3c7; color: #92400e; }
.badge-info { background: #dbeafe; color: #1e40af; }
.badge-primary { background: #e0e7ff; color: #3730a3; }
.badge-success { background: #d1fae5; color: #065f46; }
.badge-danger { background: #fee2e2; color: #991b1b; }
.badge-dark { background: #f3f4f6; color: #374151; }

/* Price Summary */
.price-summary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-radius: 12px;
    color: white;
    overflow: hidden;
    margin-bottom: 1rem;
}

.price-header {
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    background: rgba(255, 255, 255, 0.1);
}

.price-content {
    padding: 1rem;
}

.price-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.price-item.discount .price-value {
    color: #fca5a5;
}

.price-total {
    display: flex;
    justify-content: space-between;
    padding-top: 0.75rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
    font-size: 1.1rem;
}

/* Timeline */
.timeline-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
}

.timeline-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.timeline-content {
    padding: 1rem;
}

.timeline-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 1rem;
    position: relative;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 8px;
    top: 24px;
    width: 2px;
    height: calc(100% + 0.5rem);
    background: #e5e7eb;
}

.timeline-item.active::after {
    background: #3b82f6;
}

.timeline-dot {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #e5e7eb;
    flex-shrink: 0;
    margin-top: 2px;
}

.timeline-item.active .timeline-dot {
    background: #3b82f6;
}

.timeline-title {
    font-weight: 500;
    color: #111827;
    margin-bottom: 0.25rem;
}

.timeline-date {
    color: #6b7280;
    font-size: 0.85rem;
}

/* Info Sections */
.info-section {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    height: 100%;
}

.info-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.info-content {
    padding: 1rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #f3f4f6;
}

.info-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.info-label {
    color: #6b7280;
    font-size: 0.9rem;
}

.info-value {
    font-weight: 500;
    color: #111827;
    text-align: right;
}

.no-data {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-style: italic;
}

/* Section Headers */
.section-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
    margin: -1rem -1rem 1rem -1rem;
}

.section-content {
    /* No additional styling needed */
}

/* Address Section */
.address-section, .package-section, .weight-section {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
}

.address-item, .notes-item {
    margin-bottom: 1rem;
}

.address-item:last-child, .notes-item:last-child {
    margin-bottom: 0;
}

.address-label, .notes-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.address-value, .notes-value {
    color: #6b7280;
    line-height: 1.5;
}

/* Table Modern */
.table-modern {
    margin: 0;
}

.table-modern thead th {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border: none;
    padding: 1rem;
    font-weight: 600;
}

.table-modern tbody td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.package-name {
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.25rem;
}

.package-desc {
    color: #6b7280;
    font-size: 0.85rem;
}

.price-text {
    font-weight: 600;
    color: #2563eb;
}

.unit-text {
    color: #6b7280;
    font-size: 0.9rem;
}

.quantity-text {
    font-weight: 500;
    color: #111827;
}

.subtotal-text {
    font-weight: 600;
    color: #059669;
}

/* Weight Section */
.weight-info {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border: 1px solid #0ea5e9;
    border-radius: 8px;
    padding: 1rem;
}

.weight-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.weight-label {
    color: #0c4a6e;
    font-weight: 500;
}

.weight-value {
    color: #0c4a6e;
    font-weight: 600;
}

.weight-calculation {
    margin-top: 0.75rem;
    padding-top: 0.75rem;
    border-top: 1px solid #0ea5e9;
    font-weight: 600;
    color: #0c4a6e;
    text-align: center;
}

/* Responsive */
@media (max-width: 991px) {
    .sticky-top {
        position: static !important;
    }
}

@media (max-width: 768px) {
    .transaction-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .info-row {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .info-value {
        text-align: left;
    }
    
    .price-item, .weight-item {
        flex-direction: column;
        gap: 0.25rem;
    }
}

/* =========================================
   PRINT RECEIPT - THERMAL 80MM
========================================= */

.receipt-print {
    display: none;
}

@media print {
    @page {
        size: 80mm auto;
        margin: 0;
    }

    html,
    body {
        width: 80mm !important;
        min-width: 80mm !important;
        max-width: 80mm !important;
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
    }

    /*
     * Sembunyikan halaman aplikasi saat print.
     * Receipt dibuat visible kembali di bawah.
     */
    body * {
        visibility: hidden !important;
    }

    .receipt-print,
    .receipt-print * {
        visibility: visible !important;
    }

    .receipt-print {
        display: block !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 72mm !important;
        min-width: 72mm !important;
        max-width: 72mm !important;
        margin: 0 !important;
        padding: 4mm 3mm 5mm !important;
        box-sizing: border-box !important;
        background: #fff !important;
        color: #000 !important;
        font-family: Arial, Helvetica, sans-serif !important;
        font-size: 9px !important;
        line-height: 1.3 !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    .receipt-header {
        text-align: center;
        margin-bottom: 5px;
    }

    .receipt-store {
        font-size: 18px !important;
        line-height: 1.1 !important;
        font-weight: 800 !important;
        letter-spacing: 1px !important;
        margin-bottom: 2px !important;
    }

    .receipt-title {
        font-size: 10px !important;
        font-weight: 700 !important;
        margin-bottom: 2px !important;
    }

    .receipt-address {
        font-size: 8px !important;
    }

    .receipt-divider {
        width: 100% !important;
        border-top: 1px dashed #000 !important;
        margin: 6px 0 !important;
        height: 0 !important;
    }

    .receipt-meta {
        width: 100% !important;
    }

    .receipt-row {
        display: flex !important;
        justify-content: space-between !important;
        align-items: flex-start !important;
        gap: 5px !important;
        width: 100% !important;
        margin: 2px 0 !important;
    }

    .receipt-row > :first-child {
        flex: 0 0 auto !important;
    }

    .receipt-row > :last-child {
        text-align: right !important;
        max-width: 60% !important;
        overflow-wrap: anywhere !important;
    }

    .receipt-items {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: fixed !important;
        margin: 0 !important;
    }

    .receipt-items th {
        font-size: 8px !important;
        font-weight: 700 !important;
        padding: 2px 0 4px !important;
        border-bottom: 1px solid #000 !important;
    }

    .receipt-items th:nth-child(1) {
        width: 42% !important;
        text-align: left !important;
    }

    .receipt-items th:nth-child(2) {
        width: 23% !important;
        text-align: center !important;
    }

    .receipt-items th:nth-child(3) {
        width: 35% !important;
        text-align: right !important;
    }

    .receipt-items td {
        font-size: 8.5px !important;
        padding: 4px 0 !important;
        vertical-align: top !important;
        border: 0 !important;
    }

    .receipt-items td:nth-child(2) {
        text-align: center !important;
    }

    .receipt-items td:nth-child(3) {
        text-align: right !important;
    }

    .item-name > span {
        display: block !important;
        font-weight: 700 !important;
        overflow-wrap: anywhere !important;
    }

    .item-name > small {
        display: block !important;
        font-size: 7.5px !important;
        margin-top: 1px !important;
    }

    .item-qty {
        overflow-wrap: anywhere !important;
    }

    .item-total {
        white-space: nowrap !important;
        font-weight: 600 !important;
    }

    .receipt-extra {
        display: flex !important;
        justify-content: space-between !important;
        margin-top: 2px !important;
        font-size: 8.5px !important;
    }

    .receipt-summary {
        width: 100% !important;
    }

    .receipt-summary .receipt-row {
        font-size: 9px !important;
        margin: 3px 0 !important;
    }

    .receipt-grand-total {
        margin-top: 6px !important;
        padding-top: 5px !important;
        border-top: 1px solid #000 !important;
        font-size: 12px !important;
        font-weight: 800 !important;
    }

    .receipt-payment {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        font-size: 9px !important;
        margin: 5px 0 !important;
    }

    .receipt-payment strong {
        border: 1px solid #000 !important;
        padding: 2px 5px !important;
        font-size: 8px !important;
    }

    .receipt-note {
        display: block !important;
        font-size: 8px !important;
        margin-top: 5px !important;
        overflow-wrap: anywhere !important;
    }

    .receipt-note strong {
        display: inline !important;
    }

    .receipt-footer {
        text-align: center !important;
        margin-top: 10px !important;
        padding-top: 6px !important;
        border-top: 1px dashed #000 !important;
    }

    .receipt-footer strong {
        display: block !important;
        font-size: 10px !important;
        letter-spacing: 0.5px !important;
    }

    .receipt-footer span {
        display: block !important;
        font-size: 7.5px !important;
        margin-top: 2px !important;
    }

    .receipt-print,
    .receipt-print table,
    .receipt-print tbody,
    .receipt-print tr {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }
}
</style>
@endsection
