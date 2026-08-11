@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')

<div class="container-fluid px-2 px-md-4">

    {{-- HEADER --}}
    <div class="page-header mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="header-icon">
                    <i class="bi bi-receipt"></i>
                </span>
                <h2 class="fw-bold mb-0">Detail Transaksi</h2>
            </div>
            <p class="text-muted mb-0">
                Informasi lengkap pesanan dan status laundry
            </p>
        </div>

        <a href="{{ route('pelanggan.riwayat') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>


    <div class="row g-4">

        {{-- ========================= --}}
        {{-- LEFT CONTENT --}}
        {{-- ========================= --}}
        <div class="col-lg-8">

            {{-- INVOICE CARD --}}
            <div class="invoice-card mb-4">

                <div class="invoice-top">
                    <div>
                        <span class="invoice-label">Kode Invoice</span>
                        <h3 class="invoice-number">
                            {{ $transaksi->kode_invoice }}
                        </h3>
                    </div>

                    <div class="text-lg-end mt-3 mt-lg-0">
                        <span class="invoice-label">Tanggal Pesanan</span>
                        <div class="invoice-date">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $transaksi->created_at->format('d M Y') }}
                        </div>
                        <small class="text-muted">
                            {{ $transaksi->created_at->format('H:i') }} WIB
                        </small>
                    </div>
                </div>

                <div class="invoice-divider"></div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <small>Alamat Penjemputan</small>
                                <strong>{{ $transaksi->alamat_jemput }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <small>Kurir</small>
                                <strong>
                                    {{ $transaksi->kurir ? $transaksi->kurir->name : 'Belum ditugaskan' }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div>
                                <small>Metode Pembayaran</small>
                                <strong>
                                    @if($transaksi->metode_bayar === 'tunai')
                                        Tunai (COD)
                                    @elseif($transaksi->metode_bayar === 'qris')
                                        QRIS
                                    @else
                                        Transfer Bank
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </div>

                    @if($transaksi->catatan)
                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-icon">
                                <i class="bi bi-chat-left-text"></i>
                            </div>
                            <div>
                                <small>Catatan</small>
                                <strong>{{ $transaksi->catatan }}</strong>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>


            {{-- DETAIL PAKET --}}
            <div class="modern-card mb-4">

                <div class="card-title-custom">
                    <div class="title-icon blue">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div>
                        <h5>Detail Paket</h5>
                        <p>Rincian layanan laundry</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table modern-table align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Paket</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($transaksi->detailTransaksis as $detail)

                            <tr>

                                <td>
                                    <div class="package-cell">
                                        <div class="package-icon-small">
                                            <i class="bi bi-droplet-fill"></i>
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $detail->paket->nama_paket }}
                                            </strong>

                                            @if($detail->paket->deskripsi)
                                                <small>
                                                    {{ $detail->paket->deskripsi }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    {{ $detail->jumlah }}
                                    {{ $detail->paket->satuan }}
                                </td>

                                <td>
                                    Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                </td>

                                <td class="text-end fw-semibold">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>


                {{-- TOTAL --}}
                <div class="total-section">

                    @if($transaksi->diskon > 0)

                    <div class="total-row">
                        <span>Subtotal</span>
                        <strong>
                            Rp {{ number_format($transaksi->total_harga + $transaksi->diskon, 0, ',', '.') }}
                        </strong>
                    </div>

                    <div class="total-row discount">
                        <span>Diskon</span>
                        <strong>
                            - Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}
                        </strong>
                    </div>

                    @endif

                    <div class="total-row final">
                        <span>Total Pembayaran</span>
                        <strong>
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </strong>
                    </div>

                </div>


                {{-- PROMO --}}
                @if($transaksi->promoClaim)

                <div class="promo-box">
                    <div class="promo-icon">
                        <i class="bi bi-gift-fill"></i>
                    </div>

                    <div>
                        <strong>
                            {{ $transaksi->promoClaim->kode_promo }}
                        </strong>

                        <small>
                            {{ $transaksi->promoClaim->promo->judul }}
                        </small>
                    </div>
                </div>

                @endif

            </div>


            {{-- CATATAN --}}
            @if($transaksi->catatan)

            <div class="modern-card">

                <div class="card-title-custom">
                    <div class="title-icon orange">
                        <i class="bi bi-chat-left-text"></i>
                    </div>

                    <div>
                        <h5>Catatan Pesanan</h5>
                        <p>Catatan dari pelanggan</p>
                    </div>
                </div>

                <div class="note-box">
                    {{ $transaksi->catatan }}
                </div>

            </div>

            @endif

        </div>


        {{-- ========================= --}}
        {{-- RIGHT CONTENT --}}
        {{-- ========================= --}}
        <div class="col-lg-4">

            {{-- STATUS TRACKING --}}
            <div class="modern-card mb-4">

                <div class="card-title-custom">
                    <div class="title-icon yellow">
                        <i class="bi bi-clock-history"></i>
                    </div>

                    <div>
                        <h5>Status Laundry</h5>
                        <p>Perjalanan pesanan Anda</p>
                    </div>
                </div>


                <div class="tracking">

                    {{-- PESANAN --}}
                    <div class="tracking-item completed">

                        <div class="tracking-line"></div>

                        <div class="tracking-marker">
                            <i class="bi bi-check"></i>
                        </div>

                        <div class="tracking-content">
                            <h6>Pesanan Dibuat</h6>

                            <small>
                                {{ $transaksi->created_at->format('d M Y, H:i') }}
                            </small>
                        </div>

                    </div>


                    {{-- DIJEMPUT --}}
                    @php
                        $jemputActive = in_array($transaksi->status_transaksi, [
                            'dijemput_kurir',
                            'proses_cuci',
                            'siap_antar',
                            'selesai'
                        ]);

                        $jemputCompleted = in_array($transaksi->status_transaksi, [
                            'proses_cuci',
                            'siap_antar',
                            'selesai'
                        ]);
                    @endphp

                    <div class="tracking-item {{ $jemputCompleted ? 'completed' : ($jemputActive ? 'active' : '') }}">

                        <div class="tracking-line"></div>

                        <div class="tracking-marker">
                            @if($jemputCompleted)
                                <i class="bi bi-check"></i>
                            @else
                                <i class="bi bi-truck"></i>
                            @endif
                        </div>

                        <div class="tracking-content">
                            <h6>Dijemput Kurir</h6>

                            @if($transaksi->tanggal_jemput)
                                <small>
                                    {{ $transaksi->tanggal_jemput->format('d M Y, H:i') }}
                                </small>
                            @else
                                <span class="waiting">Menunggu penjemputan</span>
                            @endif
                        </div>

                    </div>


                    {{-- PROSES CUCI --}}
                    @php
                        $cuciActive = $transaksi->status_transaksi === 'proses_cuci';

                        $cuciCompleted = in_array($transaksi->status_transaksi, [
                            'siap_antar',
                            'selesai'
                        ]);
                    @endphp

                    <div class="tracking-item {{ $cuciCompleted ? 'completed' : ($cuciActive ? 'active' : '') }}">

                        <div class="tracking-line"></div>

                        <div class="tracking-marker">
                            @if($cuciCompleted)
                                <i class="bi bi-check"></i>
                            @else
                                <i class="bi bi-droplet"></i>
                            @endif
                        </div>

                        <div class="tracking-content">

                            <h6>Proses Cuci</h6>

                            @if($transaksi->tanggal_proses_cuci)

                                <small>
                                    {{ $transaksi->tanggal_proses_cuci->format('d M Y, H:i') }}
                                </small>

                            @else

                                <span class="waiting">
                                    Menunggu proses
                                </span>

                            @endif


                            @if($transaksi->berat_aktual)

                                @php
                                    $paket = $transaksi->detailTransaksis->first()->paket ?? null;
                                    $labelText = $paket && $paket->satuan === 'kg'
                                        ? 'Berat'
                                        : 'Jumlah';
                                @endphp

                                <div class="weight-info">
                                    <i class="bi bi-speedometer2"></i>

                                    {{ $labelText }}:
                                    <strong>
                                        {{ $transaksi->berat_aktual }}
                                        {{ $paket->satuan ?? '' }}
                                    </strong>
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- SIAP ANTAR --}}
                    @php
                        $antarCompleted = $transaksi->status_transaksi === 'selesai';
                        $antarActive = $transaksi->status_transaksi === 'siap_antar';
                    @endphp

                    <div class="tracking-item {{ $antarCompleted ? 'completed' : ($antarActive ? 'active' : '') }}">

                        <div class="tracking-line"></div>

                        <div class="tracking-marker">

                            @if($antarCompleted)
                                <i class="bi bi-check"></i>
                            @else
                                <i class="bi bi-box-seam"></i>
                            @endif

                        </div>

                        <div class="tracking-content">

                            <h6>Siap Diantar</h6>

                            @if($transaksi->tanggal_siap_antar)

                                <small>
                                    {{ $transaksi->tanggal_siap_antar->format('d M Y, H:i') }}
                                </small>

                            @else

                                <span class="waiting">
                                    Menunggu
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- SELESAI --}}
                    <div class="tracking-item {{ $transaksi->status_transaksi === 'selesai' ? 'completed' : '' }}">

                        <div class="tracking-marker">
                            <i class="bi bi-house-check"></i>
                        </div>

                        <div class="tracking-content">

                            <h6>Selesai</h6>

                            @if($transaksi->tanggal_selesai)

                                <small>
                                    {{ $transaksi->tanggal_selesai->format('d M Y, H:i') }}
                                </small>

                            @else

                                <span class="waiting">
                                    Menunggu
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- PEMBAYARAN --}}
            <div class="modern-card payment-card">

                <div class="card-title-custom">

                    <div class="title-icon green">
                        <i class="bi bi-credit-card"></i>
                    </div>

                    <div>
                        <h5>Pembayaran</h5>
                        <p>Status pembayaran transaksi</p>
                    </div>

                </div>


                @if($transaksi->status_bayar === 'belum_bayar')

                    <div class="payment-status unpaid">
                        <div class="status-icon">
                            <i class="bi bi-exclamation-lg"></i>
                        </div>

                        <div>
                            <strong>Belum Dibayar</strong>
                            <small>
                                Silakan lakukan pembayaran
                            </small>
                        </div>
                    </div>


                    @if($transaksi->metode_bayar === 'qris' && $transaksi->payment_url)

                        <div class="payment-info alert alert-info mt-3 mb-0">

                            <small>
                                Link pembayaran QRIS tersedia.
                            </small>

                            <a href="{{ $transaksi->payment_url }}"
                               target="_blank"
                               class="btn btn-success w-100 mt-2">

                                <i class="bi bi-qr-code me-1"></i>
                                Bayar Sekarang

                            </a>

                        </div>

                    @elseif($transaksi->metode_bayar === 'transfer')

                        <div class="transfer-info mt-3">

                            <i class="bi bi-bank"></i>

                            <div>
                                <strong>Transfer Bank</strong>

                                <small>
                                    Silakan transfer ke rekening yang telah diberikan dan kirim bukti transfer kepada admin.
                                </small>
                            </div>

                        </div>

                    @endif


                @else

                    <div class="payment-status paid">

                        <div class="status-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <div>
                            <strong>Pembayaran Lunas</strong>

                            @if($transaksi->paid_at)

                                <small>
                                    {{ $transaksi->paid_at->format('d M Y, H:i') }}
                                </small>

                            @endif

                        </div>

                    </div>

                @endif


                <div class="payment-total">

                    <span>Total Pembayaran</span>

                    <strong>
                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

/* =========================
   GENERAL
========================= */

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #eff6ff;
    color: #2563eb;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}


/* =========================
   INVOICE
========================= */

.invoice-card {
    background: white;
    border-radius: 18px;
    padding: 1.5rem;
    box-shadow: 0 5px 25px rgba(15, 23, 42, 0.07);
}

.invoice-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.invoice-label {
    display: block;
    color: #64748b;
    font-size: 0.78rem;
    margin-bottom: 0.25rem;
}

.invoice-number {
    color: #2563eb;
    font-size: 1.35rem;
    margin: 0;
    font-weight: 700;
}

.invoice-date {
    font-weight: 600;
    color: #334155;
}

.invoice-divider {
    border-top: 1px dashed #e2e8f0;
    margin: 1.5rem 0;
}

.info-box {
    display: flex;
    gap: 0.75rem;
    background: #f8fafc;
    border-radius: 12px;
    padding: 0.9rem;
    height: 100%;
}

.info-icon {
    width: 38px;
    height: 38px;
    min-width: 38px;
    border-radius: 10px;
    background: #dbeafe;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-box small {
    display: block;
    color: #64748b;
    font-size: 0.75rem;
    margin-bottom: 3px;
}

.info-box strong {
    display: block;
    color: #334155;
    font-size: 0.9rem;
    word-break: break-word;
}


/* =========================
   MODERN CARD
========================= */

.modern-card {
    background: white;
    border-radius: 18px;
    padding: 1.5rem;
    box-shadow: 0 5px 25px rgba(15, 23, 42, 0.07);
}

.card-title-custom {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.card-title-custom h5 {
    margin: 0;
    font-weight: 700;
    color: #1e293b;
}

.card-title-custom p {
    margin: 2px 0 0;
    color: #64748b;
    font-size: 0.78rem;
}

.title-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
}

.title-icon.blue {
    background: #eff6ff;
    color: #2563eb;
}

.title-icon.yellow {
    background: #fef3c7;
    color: #d97706;
}

.title-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.title-icon.orange {
    background: #ffedd5;
    color: #ea580c;
}


/* =========================
   TABLE
========================= */

.modern-table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.78rem;
    font-weight: 600;
    border: none;
    padding: 0.8rem;
}

.modern-table tbody td {
    padding: 1rem 0.8rem;
    border-color: #f1f5f9;
}

.package-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.package-icon-small {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #eff6ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
}

.package-cell strong {
    display: block;
    color: #334155;
}

.package-cell small {
    display: block;
    color: #94a3b8;
    font-size: 0.72rem;
}


/* =========================
   TOTAL
========================= */

.total-section {
    border-top: 1px solid #e2e8f0;
    margin-top: 1rem;
    padding-top: 1rem;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    color: #64748b;
}

.total-row.discount {
    color: #dc2626;
}

.total-row.final {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px dashed #cbd5e1;
    color: #1e293b;
    font-size: 1.05rem;
}

.total-row.final strong {
    color: #2563eb;
    font-size: 1.2rem;
}


/* =========================
   PROMO
========================= */

.promo-box {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: #f0fdf4;
    border: 1px dashed #22c55e;
    padding: 0.8rem;
    border-radius: 10px;
    margin-top: 1rem;
}

.promo-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    background: #dcfce7;
    color: #16a34a;
    display: flex;
    align-items: center;
    justify-content: center;
}

.promo-box strong,
.promo-box small {
    display: block;
}

.promo-box strong {
    color: #15803d;
}

.promo-box small {
    color: #64748b;
}


/* =========================
   NOTE
========================= */

.note-box {
    background: #f8fafc;
    border-left: 4px solid #2563eb;
    padding: 1rem;
    border-radius: 8px;
    color: #475569;
}


/* =========================
   TRACKING
========================= */

.tracking {
    position: relative;
    padding-left: 0.25rem;
}

.tracking-item {
    position: relative;
    display: flex;
    gap: 1rem;
    min-height: 85px;
}

.tracking-marker {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    font-size: 0.9rem;
}

.tracking-line {
    position: absolute;
    left: 17px;
    top: 36px;
    bottom: 0;
    width: 2px;
    background: #e2e8f0;
}

.tracking-item:last-child .tracking-line {
    display: none;
}

.tracking-item.completed .tracking-marker {
    background: #22c55e;
    color: white;
}

.tracking-item.completed .tracking-line {
    background: #22c55e;
}

.tracking-item.active .tracking-marker {
    background: #2563eb;
    color: white;
    box-shadow: 0 0 0 5px #dbeafe;
}

.tracking-content {
    padding-top: 0.1rem;
}

.tracking-content h6 {
    margin: 0 0 3px;
    font-weight: 700;
    color: #334155;
}

.tracking-content small {
    color: #64748b;
}

.waiting {
    color: #94a3b8;
    font-size: 0.75rem;
}

.weight-info {
    display: inline-block;
    background: #eff6ff;
    color: #2563eb;
    padding: 0.35rem 0.6rem;
    border-radius: 6px;
    font-size: 0.75rem;
    margin-top: 0.4rem;
}


/* =========================
   PAYMENT
========================= */

.payment-status {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 12px;
}

.payment-status.unpaid {
    background: #fef2f2;
    color: #dc2626;
}

.payment-status.paid {
    background: #f0fdf4;
    color: #16a34a;
}

.status-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.8);
}

.payment-status strong,
.payment-status small {
    display: block;
}

.payment-status small {
    font-size: 0.75rem;
    margin-top: 2px;
    opacity: 0.8;
}

.transfer-info {
    display: flex;
    gap: 0.75rem;
    background: #fffbeb;
    border: 1px solid #fde68a;
    padding: 0.9rem;
    border-radius: 10px;
    color: #92400e;
}

.transfer-info > i {
    font-size: 1.2rem;
}

.transfer-info strong,
.transfer-info small {
    display: block;
}

.transfer-info small {
    font-size: 0.75rem;
    margin-top: 3px;
}

.payment-total {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px dashed #cbd5e1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.payment-total span {
    color: #64748b;
    font-size: 0.85rem;
}

.payment-total strong {
    color: #2563eb;
    font-size: 1.2rem;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 991px) {

    .page-header {
        align-items: flex-start;
    }

    .invoice-top {
        flex-direction: column;
    }

}

@media (max-width: 576px) {

    .page-header {
        flex-direction: column;
    }

    .page-header .btn {
        width: 100%;
    }

    .invoice-card,
    .modern-card {
        padding: 1rem;
        border-radius: 14px;
    }

    .invoice-number {
        font-size: 1.1rem;
    }

    .modern-table {
        min-width: 600px;
    }

    .card-title-custom {
        margin-bottom: 1rem;
    }

    .payment-total strong {
        font-size: 1rem;
    }

}

</style>

@endsection