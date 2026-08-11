@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container-fluid px-2 px-md-4 py-2">
    <div class="row g-4">

        {{-- ================= SIDEBAR ================= --}}
        <div class="col-lg-4 col-xl-3 order-2 order-lg-1">
            <div class="sticky-top sidebar-sticky">

                {{-- Header --}}
                <div class="page-intro text-center mb-4">
                    <div class="page-icon">
                        @if($tab === 'riwayat')
                            <i class="bi bi-check2-circle"></i>
                        @else
                            <i class="bi bi-box-seam"></i>
                        @endif
                    </div>

                    <h3 class="fw-bold mt-3 mb-1">
                        @if($tab === 'riwayat')
                            Riwayat Selesai
                        @else
                            Pesanan Saya
                        @endif
                    </h3>

                    <p class="text-muted small mb-0">
                        @if($tab === 'riwayat')
                            Semua transaksi laundry yang telah selesai
                        @else
                            Pantau pesanan laundry kamu
                        @endif
                    </p>
                </div>

                {{-- Statistik --}}
                <div class="side-card mb-3">
                    <div class="side-card-header">
                        <div class="header-icon">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Statistik Pesanan</h6>
                            <small>Ringkasan transaksi</small>
                        </div>
                    </div>

                    <div class="side-card-body">
                        <div class="stat-row">
                            <div>
                                <span class="stat-label">
                                    Total {{ $tab === 'riwayat' ? 'Riwayat' : 'Pesanan' }}
                                </span>
                            </div>

                            <span class="stat-value">
                                {{ $showAll && method_exists($transaksis, 'total') ? $transaksis->total() : $transaksis->count() }}
                            </span>
                        </div>

                        @if($showAll && method_exists($transaksis, 'currentPage'))
                            <div class="stat-row">
                                <span class="stat-label">Halaman</span>
                                <span class="stat-value text-primary">
                                    {{ $transaksis->currentPage() }}
                                    <small class="text-muted">
                                        / {{ $transaksis->lastPage() }}
                                    </small>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Action --}}
                <div class="quick-card">
                    <div class="quick-card-header">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span>Aksi Cepat</span>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('pelanggan.order') }}"
                           class="btn btn-primary quick-btn">
                            <i class="bi bi-plus-circle me-2"></i>
                            Pesan Laundry
                        </a>

                        <a href="{{ route('pelanggan.dashboard') }}"
                           class="btn btn-outline-secondary quick-btn">
                            <i class="bi bi-house me-2"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>

            </div>
        </div>


        {{-- ================= CONTENT ================= --}}
        <div class="col-lg-8 col-xl-9 order-1 order-lg-2">

            {{-- Header Content --}}
            <div class="content-heading mb-3">
                <div>
                    <h4 class="fw-bold mb-1">
                        @if($tab === 'riwayat')
                            Riwayat Pesanan
                        @else
                            Pesanan Aktif
                        @endif
                    </h4>

                    <p class="text-muted mb-0 small">
                        @if($tab === 'riwayat')
                            Lihat seluruh transaksi laundry yang telah selesai.
                        @else
                            Pantau status pesanan laundry kamu secara berkala.
                        @endif
                    </p>
                </div>
            </div>


            {{-- Info jika hanya 5 --}}
            @if(!$showAll)
                <div class="showing-card mb-4">
                    <div class="showing-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div class="flex-grow-1">
                        <strong>
                            Menampilkan 5 {{ $tab === 'riwayat' ? 'riwayat' : 'pesanan' }} terbaru
                        </strong>
                        <small class="d-block text-muted">
                            Lihat semua transaksi untuk melihat riwayat lengkap.
                        </small>
                    </div>

                    <a href="{{ route('pelanggan.riwayat', ['tab' => $tab, 'all' => 1]) }}"
                       class="btn btn-primary btn-sm">
                        <i class="bi bi-list-ul me-1"></i>
                        Lihat Semua
                    </a>
                </div>
            @endif


            {{-- History Card --}}
            <div class="history-card">

                <div class="history-card-header">
                    <div>
                        <h5 class="mb-1 fw-bold">
                            <i class="bi bi-receipt-cutoff text-primary me-2"></i>
                            Daftar Transaksi
                        </h5>

                        <small class="text-muted">
                            Detail pesanan laundry kamu
                        </small>
                    </div>

                    <span class="transaction-count">
                        {{ $showAll && method_exists($transaksis, 'total') ? $transaksis->total() : $transaksis->count() }}
                        transaksi
                    </span>
                </div>


                <div class="history-card-body">

                    @forelse($transaksis as $transaksi)

                        @php
                            $statusClass = '';
                            $statusIcon = '';
                            $statusText = '';
                            $statusColor = '';

                            switch($transaksi->status_transaksi) {
                                case 'request_jemput':
                                    $statusClass = 'status-warning';
                                    $statusIcon = 'bi-clock-history';
                                    $statusText = 'Menunggu Penjemputan';
                                    $statusColor = 'warning';
                                    break;

                                case 'dijemput_kurir':
                                    $statusClass = 'status-info';
                                    $statusIcon = 'bi-truck';
                                    $statusText = 'Dijemput Kurir';
                                    $statusColor = 'info';
                                    break;

                                case 'proses_cuci':
                                    $statusClass = 'status-primary';
                                    $statusIcon = 'bi-arrow-repeat';
                                    $statusText = 'Sedang Dicuci';
                                    $statusColor = 'primary';
                                    break;

                                case 'siap_antar':
                                    $statusClass = 'status-success';
                                    $statusIcon = 'bi-box-seam';
                                    $statusText = 'Siap Diantar';
                                    $statusColor = 'success';
                                    break;

                                case 'selesai':
                                    $statusClass = 'status-dark';
                                    $statusIcon = 'bi-check-circle-fill';
                                    $statusText = 'Selesai';
                                    $statusColor = 'dark';
                                    break;
                            }
                        @endphp


                        {{-- TRANSACTION ITEM --}}
                        <div class="transaction-item">

                            {{-- Top --}}
                            <div class="transaction-top">

                                <div class="invoice-wrapper">
                                    <div class="transaction-icon {{ $statusClass }}">
                                        <i class="bi {{ $statusIcon }}"></i>
                                    </div>

                                    <div>
                                        <div class="invoice-label">
                                            KODE INVOICE
                                        </div>

                                        <h6 class="invoice-number mb-1">
                                            {{ $transaksi->kode_invoice }}
                                        </h6>

                                        <small class="transaction-date">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $transaksi->created_at->format('d F Y, H:i') }}
                                        </small>
                                    </div>
                                </div>


                                {{-- Status --}}
                                <div class="status-wrapper">

                                    <span class="status-pill {{ $statusClass }}">
                                        <i class="bi {{ $statusIcon }}"></i>
                                        {{ $statusText }}
                                    </span>

                                    @if($transaksi->status_bayar === 'belum_bayar')
                                        <span class="payment-pill payment-unpaid">
                                            <i class="bi bi-credit-card"></i>
                                            Belum Bayar
                                        </span>
                                    @else
                                        <span class="payment-pill payment-paid">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Lunas
                                        </span>
                                    @endif

                                </div>

                            </div>


                            {{-- Divider --}}
                            <div class="transaction-divider"></div>


                            {{-- Body --}}
                            <div class="transaction-body">

                                {{-- Detail --}}
                                <div class="transaction-details">

                                    {{-- Address --}}
                                    <div class="detail-row">
                                        <div class="detail-icon">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </div>

                                        <div>
                                            <small class="detail-label">
                                                Alamat Penjemputan
                                            </small>

                                            <div class="detail-value">
                                                {{ Str::limit($transaksi->alamat_jemput, 100) }}
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Package --}}
                                    <div class="detail-row">
                                        <div class="detail-icon">
                                            <i class="bi bi-box-seam-fill"></i>
                                        </div>

                                        <div>
                                            <small class="detail-label">
                                                Paket Laundry
                                            </small>

                                            <div class="package-list">
                                                @foreach($transaksi->detailTransaksis as $detail)
                                                    <span class="package-tag">
                                                        {{ $detail->paket->nama_paket }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Kurir --}}
                                    @if($transaksi->kurir)
                                        <div class="detail-row">
                                            <div class="detail-icon">
                                                <i class="bi bi-person-fill"></i>
                                            </div>

                                            <div>
                                                <small class="detail-label">
                                                    Kurir
                                                </small>

                                                <div class="detail-value">
                                                    {{ $transaksi->kurir->name }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    {{-- Catatan --}}
                                    @if($transaksi->catatan)
                                        <div class="detail-row">
                                            <div class="detail-icon">
                                                <i class="bi bi-chat-left-text-fill"></i>
                                            </div>

                                            <div>
                                                <small class="detail-label">
                                                    Catatan
                                                </small>

                                                <div class="detail-value text-muted">
                                                    "{{ $transaksi->catatan }}"
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>


                                {{-- Price --}}
                                <div class="transaction-price">

                                    @if($transaksi->berat_aktual)
                                        <div class="weight-box">
                                            <i class="bi bi-speedometer2"></i>

                                            <div>
                                                <small>Berat Aktual</small>
                                                <strong>
                                                    {{ $transaksi->berat_aktual }} kg
                                                </strong>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="price-label">
                                        Total Pembayaran
                                    </div>

                                    <div class="price-value">
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                    </div>

                                    <a href="{{ route('pelanggan.transaksi.show', $transaksi) }}"
                                       class="btn btn-primary detail-btn">
                                        <i class="bi bi-eye me-2"></i>
                                        Lihat Detail
                                    </a>

                                </div>

                            </div>

                        </div>


                        @if(!$loop->last)
                            <div class="transaction-space"></div>
                        @endif

                    @empty

                        {{-- Empty State --}}
                        <div class="empty-state">

                            <div class="empty-icon">
                                <i class="bi bi-inbox"></i>
                            </div>

                            @if($tab === 'riwayat')

                                <h5 class="fw-bold text-dark mb-2">
                                    Belum Ada Riwayat
                                </h5>

                                <p class="text-muted mb-4">
                                    Transaksi laundry yang sudah selesai akan muncul di sini.
                                </p>

                            @else

                                <h5 class="fw-bold text-dark mb-2">
                                    Belum Ada Pesanan Aktif
                                </h5>

                                <p class="text-muted mb-4">
                                    Kamu belum memiliki pesanan laundry yang sedang berjalan.
                                </p>

                            @endif

                            <a href="{{ route('pelanggan.order') }}"
                               class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>
                                Pesan Laundry Sekarang
                            </a>

                        </div>

                    @endforelse


                    {{-- Pagination --}}
                    @if($showAll && method_exists($transaksis, 'hasPages') && $transaksis->hasPages())

                        <div class="pagination-wrapper">
                            {{ $transaksis->appends(['tab' => $tab, 'all' => 1])->links() }}
                        </div>

                    @endif

                </div>
            </div>

        </div>

    </div>
</div>


<style>

/* =========================================================
   GENERAL
========================================================= */

.sidebar-sticky {
    top: 90px;
}

.page-intro {
    padding: 0.5rem 0;
}

.page-icon {
    width: 72px;
    height: 72px;
    margin: auto;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 22px;

    background: linear-gradient(
        135deg,
        #3b82f6,
        #2563eb
    );

    color: white;

    font-size: 2rem;

    box-shadow:
        0 10px 25px rgba(37, 99, 235, 0.22);
}


/* =========================================================
   SIDEBAR CARD
========================================================= */

.side-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;

    border: 1px solid #eef2f7;

    box-shadow:
        0 5px 20px rgba(15, 23, 42, 0.06);
}

.side-card-header {
    display: flex;
    align-items: center;
    gap: 12px;

    padding: 1rem 1.1rem;

    background: linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );

    color: white;
}

.side-card-header small {
    opacity: 0.85;
}

.header-icon {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: rgba(255,255,255,.18);

    border-radius: 10px;
}

.side-card-body {
    padding: 1rem 1.1rem;
}

.stat-row {
    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 0.8rem 0;

    border-bottom: 1px solid #f1f5f9;
}

.stat-row:last-child {
    border-bottom: none;
}

.stat-label {
    color: #64748b;
    font-size: .85rem;
}

.stat-value {
    font-weight: 700;
    color: #1e293b;
}


/* =========================================================
   QUICK ACTION
========================================================= */

.quick-card {
    padding: 1rem;

    border-radius: 16px;

    background: linear-gradient(
        135deg,
        #fffbeb,
        #fef3c7
    );

    border: 1px solid #fde68a;
}

.quick-card-header {
    display: flex;
    align-items: center;
    gap: 8px;

    margin-bottom: .9rem;

    font-weight: 700;
    color: #92400e;
}

.quick-card-header i {
    color: #f59e0b;
}

.quick-btn {
    border-radius: 10px;
    padding: .65rem .8rem;
}


/* =========================================================
   CONTENT HEADER
========================================================= */

.content-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: .3rem .2rem;
}


/* =========================================================
   SHOWING INFO
========================================================= */

.showing-card {
    display: flex;
    align-items: center;
    gap: 12px;

    padding: .9rem 1rem;

    border-radius: 14px;

    background: #eff6ff;

    border: 1px solid #bfdbfe;

    color: #1e40af;
}

.showing-icon {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #dbeafe;

    color: #2563eb;

    flex-shrink: 0;
}


/* =========================================================
   HISTORY CARD
========================================================= */

.history-card {
    background: white;

    border-radius: 18px;

    border: 1px solid #eef2f7;

    box-shadow:
        0 6px 25px rgba(15, 23, 42, 0.06);

    overflow: hidden;
}

.history-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 1.25rem 1.5rem;

    border-bottom: 1px solid #eef2f7;
}

.transaction-count {
    background: #eff6ff;
    color: #2563eb;

    padding: .4rem .75rem;

    border-radius: 20px;

    font-size: .75rem;
    font-weight: 700;
}

.history-card-body {
    padding: 1.5rem;
}


/* =========================================================
   TRANSACTION
========================================================= */

.transaction-item {
    padding: .25rem 0;
}

.transaction-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;

    gap: 1rem;
}

.invoice-wrapper {
    display: flex;
    align-items: center;

    gap: 12px;
}

.transaction-icon {
    width: 48px;
    height: 48px;

    border-radius: 14px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 1.2rem;

    flex-shrink: 0;
}

.invoice-label {
    font-size: .65rem;
    font-weight: 700;

    color: #94a3b8;

    letter-spacing: .7px;
}

.invoice-number {
    color: #1e293b;
    font-size: 1rem;
}

.transaction-date {
    color: #94a3b8;
}


/* =========================================================
   STATUS
========================================================= */

.status-wrapper {
    display: flex;
    align-items: center;
    justify-content: flex-end;

    flex-wrap: wrap;

    gap: 6px;
}

.status-pill,
.payment-pill {
    display: inline-flex;
    align-items: center;

    gap: 5px;

    padding: .42rem .7rem;

    border-radius: 20px;

    font-size: .7rem;

    font-weight: 700;

    white-space: nowrap;
}

.status-warning {
    color: #92400e;
    background: #fef3c7;
}

.status-info {
    color: #075985;
    background: #e0f2fe;
}

.status-primary {
    color: #1e40af;
    background: #dbeafe;
}

.status-success {
    color: #166534;
    background: #dcfce7;
}

.status-dark {
    color: #334155;
    background: #e2e8f0;
}

.payment-unpaid {
    background: #fee2e2;
    color: #b91c1c;
}

.payment-paid {
    background: #dcfce7;
    color: #166534;
}


/* =========================================================
   DIVIDER
========================================================= */

.transaction-divider {
    height: 1px;

    background: #f1f5f9;

    margin: 1rem 0;
}


/* =========================================================
   BODY
========================================================= */

.transaction-body {
    display: grid;

    grid-template-columns: 1fr 220px;

    gap: 2rem;
}

.transaction-details {
    display: flex;
    flex-direction: column;

    gap: .9rem;
}

.detail-row {
    display: flex;
    align-items: flex-start;

    gap: 10px;
}

.detail-icon {
    width: 32px;
    height: 32px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: #f8fafc;

    color: #64748b;

    flex-shrink: 0;
}

.detail-label {
    display: block;

    color: #94a3b8;

    font-size: .68rem;

    margin-bottom: 2px;

    font-weight: 600;
}

.detail-value {
    color: #334155;

    font-size: .84rem;

    line-height: 1.5;
}

.package-list {
    display: flex;
    flex-wrap: wrap;

    gap: 5px;
}

.package-tag {
    padding: .3rem .55rem;

    border-radius: 7px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    color: #475569;

    font-size: .7rem;

    font-weight: 600;
}


/* =========================================================
   PRICE
========================================================= */

.transaction-price {
    padding-left: 1.5rem;

    border-left: 1px solid #f1f5f9;

    display: flex;
    flex-direction: column;

    justify-content: center;

    text-align: right;
}

.weight-box {
    display: inline-flex;

    align-items: center;

    justify-content: flex-end;

    gap: 8px;

    margin-bottom: 1rem;

    color: #0891b2;
}

.weight-box i {
    width: 32px;
    height: 32px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    background: #cffafe;
}

.weight-box small {
    display: block;

    color: #94a3b8;

    font-size: .65rem;
}

.weight-box strong {
    display: block;

    color: #0e7490;

    font-size: .8rem;
}

.price-label {
    color: #94a3b8;

    font-size: .7rem;

    margin-bottom: .2rem;
}

.price-value {
    color: #16a34a;

    font-size: 1.15rem;

    font-weight: 800;

    margin-bottom: 1rem;
}

.detail-btn {
    border-radius: 10px;

    padding: .6rem .8rem;

    font-size: .78rem;

    font-weight: 600;
}


/* =========================================================
   SPACE
========================================================= */

.transaction-space {
    height: 1px;

    background: #f1f5f9;

    margin: 1.5rem 0;
}


/* =========================================================
   EMPTY
========================================================= */

.empty-state {
    text-align: center;

    padding: 4rem 1rem;
}

.empty-icon {
    width: 85px;
    height: 85px;

    margin: 0 auto 1.25rem;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #f1f5f9;

    color: #94a3b8;

    font-size: 2.2rem;
}


/* =========================================================
   PAGINATION
========================================================= */

.pagination-wrapper {
    display: flex;
    justify-content: center;

    padding-top: 1.5rem;

    border-top: 1px solid #f1f5f9;
}

.pagination svg,
.pagination .w-5,
.pagination .h-5 {
    width: 12px !important;
    height: 12px !important;
}


/* =========================================================
   RESPONSIVE TABLET
========================================================= */

@media (max-width: 991px) {

    .sidebar-sticky {
        position: static !important;
    }

    .transaction-body {
        grid-template-columns: 1fr;
    }

    .transaction-price {
        padding-left: 0;

        padding-top: 1rem;

        border-left: none;

        border-top: 1px solid #f1f5f9;

        text-align: left;
    }

    .weight-box {
        justify-content: flex-start;
    }

    .status-wrapper {
        justify-content: flex-start;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .history-card-header {
        padding: 1rem;
    }

    .history-card-body {
        padding: 1rem;
    }

    .transaction-top {
        flex-direction: column;
    }

    .status-wrapper {
        width: 100%;
    }

    .showing-card {
        align-items: flex-start;

        flex-wrap: wrap;
    }

    .showing-card .btn {
        width: 100%;
    }

}


/* =========================================================
   SMALL MOBILE
========================================================= */

@media (max-width: 576px) {

    .container-fluid {
        padding-left: .6rem;
        padding-right: .6rem;
    }

    .page-icon {
        width: 62px;
        height: 62px;

        border-radius: 18px;

        font-size: 1.6rem;
    }

    .page-intro h3 {
        font-size: 1.25rem;
    }

    .history-card {
        border-radius: 14px;
    }

    .history-card-header {
        flex-direction: column;

        align-items: flex-start;

        gap: .7rem;
    }

    .invoice-wrapper {
        align-items: flex-start;
    }

    .transaction-icon {
        width: 42px;
        height: 42px;

        border-radius: 11px;

        font-size: 1rem;
    }

    .invoice-number {
        font-size: .9rem;
    }

    .status-pill,
    .payment-pill {
        font-size: .65rem;

        padding: .35rem .55rem;
    }

    .detail-value {
        font-size: .78rem;
    }

    .price-value {
        font-size: 1.05rem;
    }

    .detail-btn {
        width: 100%;
    }

}

</style>
@endsection