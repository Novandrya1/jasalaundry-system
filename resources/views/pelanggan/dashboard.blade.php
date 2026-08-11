@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')

<style>
    /* ================================
       DASHBOARD PELANGGAN
    ================================= */

    .customer-page {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Hero */
    .welcome-card {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #2563eb 0%, #4f46e5 55%, #7c3aed 100%);
        color: white;
        border-radius: 20px;
        padding: 28px 30px;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(37, 99, 235, .20);
    }

    .welcome-card::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
        right: -70px;
        top: -90px;
    }

    .welcome-card::after {
        content: "";
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,.06);
        right: 100px;
        bottom: -70px;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .welcome-title {
        font-size: 1.45rem;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .welcome-subtitle {
        margin-bottom: 20px;
        opacity: .9;
    }

    .btn-order-main {
        background: white;
        color: #2563eb;
        border: none;
        padding: 11px 20px;
        border-radius: 10px;
        font-weight: 700;
        transition: .2s;
    }

    .btn-order-main:hover {
        background: #f8fafc;
        color: #1d4ed8;
        transform: translateY(-2px);
    }

    /* Section */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .section-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .section-link {
        font-size: .85rem;
        text-decoration: none;
        color: #2563eb;
        font-weight: 600;
    }

    /* Stats */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 18px;
        border: 1px solid #e5e7eb;
        height: 100%;
        transition: .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,.08);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        margin-bottom: 12px;
    }

    .stat-number {
        font-size: 1.35rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 2px;
    }

    .stat-label {
        font-size: .8rem;
        color: #64748b;
        margin: 0;
    }

    /* Active order */
    .order-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 12px;
        transition: .2s;
    }

    .order-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,.07);
    }

    .invoice {
        font-weight: 700;
        color: #1e293b;
    }

    .order-date {
        color: #64748b;
        font-size: .8rem;
    }

    .order-price {
        color: #16a34a;
        font-size: 1rem;
        font-weight: 700;
    }

    .status-badge {
        border-radius: 20px;
        padding: 6px 10px;
        font-size: .72rem;
        font-weight: 600;
    }

    /* Quick menu */
    .quick-card {
        display: block;
        text-decoration: none;
        color: inherit;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px 15px;
        text-align: center;
        height: 100%;
        transition: .2s;
    }

    .quick-card:hover {
        color: inherit;
        transform: translateY(-3px);
        border-color: #93c5fd;
        box-shadow: 0 8px 25px rgba(0,0,0,.07);
    }

    .quick-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 1.3rem;
        color: white;
    }

    .quick-title {
        font-size: .9rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .quick-description {
        color: #64748b;
        font-size: .75rem;
        margin: 0;
    }

    /* Service */
    .service-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 18px;
        height: 100%;
        transition: .2s;
    }

    .service-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,.07);
    }

    .service-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.15rem;
        margin-bottom: 13px;
    }

    .service-name {
        font-weight: 700;
        font-size: .92rem;
        margin-bottom: 5px;
        color: #1e293b;
    }

    .service-description {
        color: #64748b;
        font-size: .75rem;
        margin-bottom: 12px;
    }

    .service-price {
        color: #16a34a;
        font-size: 1rem;
        font-weight: 700;
    }

    .service-unit {
        color: #64748b;
        font-size: .7rem;
    }

    /* Promo */
    .promo-banner {
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        border-radius: 18px;
        color: white;
        padding: 22px;
        position: relative;
        overflow: hidden;
    }

    .promo-banner::after {
        content: "\f3e5";
        font-family: bootstrap-icons;
        position: absolute;
        right: 25px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 6rem;
        opacity: .10;
    }

    .promo-banner-content {
        position: relative;
        z-index: 2;
    }

    /* How it works */
    .step-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 16px;
        height: 100%;
    }

    .step-number {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .85rem;
        margin-bottom: 10px;
    }

    .step-title {
        font-weight: 700;
        font-size: .85rem;
        margin-bottom: 5px;
    }

    .step-text {
        color: #64748b;
        font-size: .75rem;
        margin: 0;
        line-height: 1.5;
    }

    /* Info */
    .info-box {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
    }

    .info-list {
        margin: 0;
        padding-left: 18px;
    }

    .info-list li {
        color: #64748b;
        font-size: .8rem;
        margin-bottom: 8px;
    }

    /* Empty */
    .empty-order {
        text-align: center;
        padding: 30px 20px;
        background: white;
        border: 1px dashed #cbd5e1;
        border-radius: 16px;
    }

    .empty-order-icon {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 1.3rem;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .customer-page {
            padding: 0 2px;
        }

        .welcome-card {
            padding: 22px 18px;
            border-radius: 16px;
            margin-bottom: 18px;
        }

        .welcome-title {
            font-size: 1.15rem;
        }

        .welcome-subtitle {
            font-size: .8rem;
            margin-bottom: 15px;
        }

        .btn-order-main {
            width: 100%;
            font-size: .85rem;
        }

        .section-title {
            font-size: .95rem;
        }

        .section-link {
            font-size: .75rem;
        }

        .stat-card {
            padding: 14px;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            font-size: .95rem;
        }

        .stat-number {
            font-size: 1.15rem;
        }

        .stat-label {
            font-size: .7rem;
        }

        .quick-card {
            padding: 15px 8px;
        }

        .quick-icon {
            width: 42px;
            height: 42px;
            font-size: 1.1rem;
        }

        .quick-title {
            font-size: .75rem;
        }

        .quick-description {
            font-size: .65rem;
        }

        .service-card {
            padding: 15px;
        }

        .service-name {
            font-size: .82rem;
        }

        .service-description {
            font-size: .68rem;
        }

        .service-price {
            font-size: .9rem;
        }

        .order-card {
            padding: 15px;
        }

        .invoice {
            font-size: .85rem;
        }

        .order-date {
            font-size: .7rem;
        }

        .order-price {
            font-size: .9rem;
        }

        .status-badge {
            font-size: .65rem;
            padding: 5px 8px;
        }

        .step-card {
            padding: 14px;
        }

        .promo-banner {
            padding: 18px;
        }

        .promo-banner h5 {
            font-size: .95rem;
        }

        .promo-banner p {
            font-size: .75rem;
        }
    }
</style>


<div class="customer-page">

    {{-- ==========================================
         WELCOME
    =========================================== --}}
    <div class="welcome-card">
        <div class="welcome-content">

            <div class="welcome-title">
                Halo, {{ auth()->user()->name }}! 👋
            </div>

            <div class="welcome-subtitle">
                Laundry jadi lebih mudah. Pesan sekarang, kami yang urus.
            </div>

            <a href="{{ route('pelanggan.order') }}"
               class="btn btn-order-main">
                <i class="bi bi-plus-circle me-1"></i>
                Pesan Laundry Sekarang
            </a>

        </div>
    </div>


    {{-- ==========================================
         STATUS RINGKAS
    =========================================== --}}
    <div class="section-header">
        <h5 class="section-title">Ringkasan Pesanan</h5>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-6 col-md-3">
            <div class="stat-card">

                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-receipt"></i>
                </div>

                <div class="stat-number">
                    {{ $totalPesanan }}
                </div>

                <p class="stat-label">
                    Total Pesanan
                </p>

            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="stat-card">

                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <div class="stat-number">
                    {{ $pesananAktif }}
                </div>

                <p class="stat-label">
                    Sedang Diproses
                </p>

            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="stat-card">

                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div class="stat-number">
                    {{ $pesananSelesai }}
                </div>

                <p class="stat-label">
                    Selesai
                </p>

            </div>
        </div>


        <div class="col-6 col-md-3">
            <div class="stat-card">

                <div class="stat-icon bg-danger-subtle text-danger">
                    <i class="bi bi-tag"></i>
                </div>

                <div class="stat-number">
                    {{ $promoTersedia }}
                </div>

                <p class="stat-label">
                    Promo Tersedia
                </p>

            </div>
        </div>

    </div>


    {{-- ==========================================
         PESANAN AKTIF
    =========================================== --}}
    <div class="section-header">

        <h5 class="section-title">
            <i class="bi bi-bag-check me-1 text-primary"></i>
            Pesanan Saya
        </h5>

        <a href="{{ route('pelanggan.riwayat', ['tab' => 'pesanan']) }}"
           class="section-link">
            Lihat semua
            <i class="bi bi-arrow-right"></i>
        </a>

    </div>


    @if($pesananSaya && $pesananSaya->count() > 0)

        @foreach($pesananSaya->take(3) as $transaksi)

            <div class="order-card">

                <div class="row align-items-center">

                    <div class="col-8">

                        <div class="invoice">
                            {{ $transaksi->kode_invoice }}
                        </div>

                        <div class="order-date mb-2">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $transaksi->created_at->format('d M Y, H:i') }}
                        </div>

                        <div class="order-price">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </div>

                    </div>

                    <div class="col-4 text-end">

                        @if($transaksi->status_transaksi === 'request_jemput')

                            <span class="badge bg-warning text-dark status-badge">
                                <i class="bi bi-clock me-1"></i>
                                Menunggu
                            </span>

                        @elseif($transaksi->status_transaksi === 'dijemput_kurir')

                            <span class="badge bg-info status-badge">
                                <i class="bi bi-truck me-1"></i>
                                Dijemput
                            </span>

                        @elseif($transaksi->status_transaksi === 'proses_cuci')

                            <span class="badge bg-primary status-badge">
                                <i class="bi bi-droplet me-1"></i>
                                Dicuci
                            </span>

                        @elseif($transaksi->status_transaksi === 'siap_antar')

                            <span class="badge bg-success status-badge">
                                <i class="bi bi-box-seam me-1"></i>
                                Siap Antar
                            </span>

                        @elseif($transaksi->status_transaksi === 'selesai')

                            <span class="badge bg-success status-badge">
                                <i class="bi bi-check-circle me-1"></i>
                                Selesai
                            </span>

                        @else

                            <span class="badge bg-secondary status-badge">
                                {{ ucfirst(str_replace('_', ' ', $transaksi->status_transaksi)) }}
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    @else

        <div class="empty-order mb-4">

            <div class="empty-order-icon">
                <i class="bi bi-bag"></i>
            </div>

            <h6 class="fw-bold">
                Belum ada pesanan
            </h6>

            <p class="text-muted small mb-3">
                Yuk, mulai pesan laundry sekarang.
            </p>

            <a href="{{ route('pelanggan.order') }}"
               class="btn btn-primary btn-sm px-3">

                <i class="bi bi-plus-circle me-1"></i>
                Pesan Laundry

            </a>

        </div>

    @endif


    {{-- ==========================================
         AKSI CEPAT
    =========================================== --}}
    <div class="section-header mt-4">

        <h5 class="section-title">
            Akses Cepat
        </h5>

    </div>

    <div class="row g-3 mb-4">

        <div class="col-4">

            <a href="{{ route('pelanggan.order') }}"
               class="quick-card">

                <div class="quick-icon"
                     style="background: linear-gradient(135deg,#2563eb,#4f46e5);">

                    <i class="bi bi-plus-lg"></i>

                </div>

                <div class="quick-title">
                    Pesan
                </div>

                <p class="quick-description">
                    Buat pesanan baru
                </p>

            </a>

        </div>


        <div class="col-4">

            <a href="{{ route('pelanggan.riwayat', ['tab' => 'pesanan']) }}"
               class="quick-card">

                <div class="quick-icon"
                     style="background: linear-gradient(135deg,#f59e0b,#f97316);">

                    <i class="bi bi-box-seam"></i>

                </div>

                <div class="quick-title">
                    Pesanan
                </div>

                <p class="quick-description">
                    Cek pesanan aktif
                </p>

            </a>

        </div>


        <div class="col-4">

            <a href="{{ route('pelanggan.riwayat', ['tab' => 'riwayat']) }}"
               class="quick-card">

                <div class="quick-icon"
                     style="background: linear-gradient(135deg,#10b981,#059669);">

                    <i class="bi bi-clock-history"></i>

                </div>

                <div class="quick-title">
                    Riwayat
                </div>

                <p class="quick-description">
                    Lihat pesanan lama
                </p>

            </a>

        </div>

    </div>


    {{-- ==========================================
         PROMO
    =========================================== --}}
    @if($promos && $promos->count() > 0)

        <div class="section-header">

            <h5 class="section-title">
                <i class="bi bi-gift me-1 text-danger"></i>
                Promo Untuk Anda
            </h5>

        </div>

        <div class="promo-banner mb-4">

            <div class="promo-banner-content">

                <h5 class="fw-bold mb-2">
                    Ada promo menarik! 🎉
                </h5>

                <p class="mb-3 opacity-90">
                    Dapatkan harga lebih hemat untuk laundry Anda.
                </p>

                <button class="btn btn-light btn-sm fw-semibold"
                        data-bs-toggle="modal"
                        data-bs-target="#promoModal">

                    <i class="bi bi-gift me-1"></i>
                    Lihat Promo

                </button>

            </div>

        </div>


        {{-- Promo Modal --}}
        <div class="modal fade"
             id="promoModal"
             tabindex="-1">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-gift text-primary me-2"></i>
                            Promo Tersedia
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        @foreach($promos as $promo)

                            <div class="border rounded-3 p-3 mb-3">

                                <div class="d-flex justify-content-between align-items-start">

                                    <div>

                                        <h6 class="fw-bold mb-1">
                                            {{ $promo->judul }}
                                        </h6>

                                        <p class="small text-muted mb-2">
                                            {{ $promo->deskripsi }}
                                        </p>

                                        <span class="badge bg-success">
                                            {{ $promo->diskon_text }}
                                        </span>

                                    </div>

                                    <button id="btn-klaim-{{ $promo->id }}"
                                            class="btn btn-primary btn-sm"
                                            onclick="klaimPromo({{ $promo->id }})">

                                        <span class="btn-text">
                                            Klaim
                                        </span>

                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </span>

                                    </button>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- ==========================================
         LAYANAN LAUNDRY
    =========================================== --}}
    <div class="section-header mt-4">

        <h5 class="section-title">
            Pilih Layanan Laundry
        </h5>

        <a href="{{ route('pelanggan.order') }}"
           class="section-link">

            Semua layanan
            <i class="bi bi-arrow-right"></i>

        </a>

    </div>


    <div class="row g-3 mb-4">

        {{-- Cuci Kering + Setrika --}}
        <div class="col-6 col-md-3">

            <div class="service-card">

                <div class="service-icon"
                     style="background: linear-gradient(135deg,#2563eb,#4f46e5);">

                    <i class="bi bi-stars"></i>

                </div>

                <div class="service-name">
                    Cuci + Setrika
                </div>

                <div class="service-description">
                    Bersih, kering dan siap dipakai.
                </div>

                <div class="service-price">
                    Rp 7.000
                </div>

                <div class="service-unit mb-3">
                    per kg
                </div>

                <a href="{{ route('pelanggan.order', ['paket' => 'cuci-kering-setrika']) }}"
                   class="btn btn-primary btn-sm w-100">

                    Pilih

                </a>

            </div>

        </div>


        {{-- Laundry Cepat --}}
        <div class="col-6 col-md-3">

            <div class="service-card">

                <div class="service-icon"
                     style="background: linear-gradient(135deg,#f97316,#ef4444);">

                    <i class="bi bi-lightning-charge"></i>

                </div>

                <div class="service-name">
                    Laundry Cepat
                </div>

                <div class="service-description">
                    Cocok untuk kebutuhan mendesak.
                </div>

                <div class="service-price">
                    Rp 9.000
                </div>

                <div class="service-unit mb-3">
                    per kg
                </div>

                <a href="{{ route('pelanggan.order', ['paket' => 'laundry-cepat']) }}"
                   class="btn btn-primary btn-sm w-100">

                    Pilih

                </a>

            </div>

        </div>


        {{-- Setrika --}}
        <div class="col-6 col-md-3">

            <div class="service-card">

                <div class="service-icon"
                     style="background: linear-gradient(135deg,#10b981,#059669);">

                    <i class="bi bi-brightness-high"></i>

                </div>

                <div class="service-name">
                    Setrika + Lipat
                </div>

                <div class="service-description">
                    Rapi, wangi dan siap disimpan.
                </div>

                <div class="service-price">
                    Rp 5.000
                </div>

                <div class="service-unit mb-3">
                    per kg
                </div>

                <a href="{{ route('pelanggan.order', ['paket' => 'setrika-wangi-lipat']) }}"
                   class="btn btn-primary btn-sm w-100">

                    Pilih

                </a>

            </div>

        </div>


        {{-- Cuci Kering --}}
        <div class="col-6 col-md-3">

            <div class="service-card">

                <div class="service-icon"
                     style="background: linear-gradient(135deg,#8b5cf6,#7c3aed);">

                    <i class="bi bi-droplet"></i>

                </div>

                <div class="service-name">
                    Cuci Kering
                </div>

                <div class="service-description">
                    Cucian bersih dan kering.
                </div>

                <div class="service-price">
                    Rp 6.000
                </div>

                <div class="service-unit mb-3">
                    per kg
                </div>

                <a href="{{ route('pelanggan.order', ['paket' => 'cuci-kering']) }}"
                   class="btn btn-primary btn-sm w-100">

                    Pilih

                </a>

            </div>

        </div>

    </div>


    {{-- ==========================================
         JEMPUT & ANTAR
    =========================================== --}}
    <div class="info-box mb-4">

        <div class="d-flex align-items-start">

            <div class="stat-icon bg-primary-subtle text-primary me-3 mb-0">
                <i class="bi bi-truck"></i>
            </div>

            <div>

                <h6 class="fw-bold mb-1">
                    Butuh Laundry Jemput & Antar?
                </h6>

                <p class="text-muted small mb-3">
                    Tidak perlu datang ke outlet. Kurir kami akan menjemput
                    dan mengantarkan laundry ke alamat Anda.
                </p>

                <a href="{{ route('pelanggan.order') }}"
                   class="btn btn-primary btn-sm">

                    <i class="bi bi-truck me-1"></i>
                    Pesan Jemput & Antar

                </a>

            </div>

        </div>

    </div>


    {{-- ==========================================
         CARA PESAN
    =========================================== --}}
    <div class="section-header">

        <h5 class="section-title">
            Cara Pesan Laundry
        </h5>

    </div>


    <div class="row g-3 mb-4">

        <div class="col-6 col-md-3">

            <div class="step-card">

                <div class="step-number">
                    1
                </div>

                <div class="step-title">
                    Pilih Layanan
                </div>

                <p class="step-text">
                    Pilih paket laundry sesuai kebutuhan.
                </p>

            </div>

        </div>


        <div class="col-6 col-md-3">

            <div class="step-card">

                <div class="step-number">
                    2
                </div>

                <div class="step-title">
                    Isi Pesanan
                </div>

                <p class="step-text">
                    Masukkan detail dan alamat jika menggunakan kurir.
                </p>

            </div>

        </div>


        <div class="col-6 col-md-3">

            <div class="step-card">

                <div class="step-number">
                    3
                </div>

                <div class="step-title">
                    Laundry Diproses
                </div>

                <p class="step-text">
                    Pantau status laundry melalui menu Pesanan Saya.
                </p>

            </div>

        </div>


        <div class="col-6 col-md-3">

            <div class="step-card">

                <div class="step-number">
                    4
                </div>

                <div class="step-title">
                    Selesai
                </div>

                <p class="step-text">
                    Laundry siap diambil atau diantar kembali.
                </p>

            </div>

        </div>

    </div>


    {{-- ==========================================
         INFORMASI
    =========================================== --}}
    <div class="row g-3 mb-4">

        <div class="col-md-6">

            <div class="info-box h-100">

                <h6 class="fw-bold mb-3">
                    <i class="bi bi-clock text-primary me-2"></i>
                    Jam Operasional
                </h6>

                <div class="d-flex justify-content-between mb-2">

                    <span class="small">
                        Senin - Jumat
                    </span>

                    <span class="small text-muted">
                        08:00 - 20:00
                    </span>

                </div>

                <div class="d-flex justify-content-between mb-2">

                    <span class="small">
                        Sabtu
                    </span>

                    <span class="small text-muted">
                        08:00 - 18:00
                    </span>

                </div>

                <div class="d-flex justify-content-between">

                    <span class="small">
                        Minggu
                    </span>

                    <span class="small text-muted">
                        09:00 - 17:00
                    </span>

                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="info-box h-100">

                <h6 class="fw-bold mb-3 text-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    Barang yang Tidak Diterima
                </h6>

                <ul class="info-list">

                    <li>
                        Pakaian dalam
                    </li>

                    <li>
                        Barang berbahan kulit / suede
                    </li>

                    <li>
                        Barang dengan noda cat atau oli berat
                    </li>

                </ul>

            </div>

        </div>

    </div>


    {{-- ==========================================
         PENUTUP
    =========================================== --}}
    <div class="text-center py-3 mb-3">

        <h6 class="fw-bold">
            Laundry lebih mudah bersama JasaLaundry ✨
        </h6>

        <p class="text-muted small mb-3">
            Pesan sekarang dan biarkan kami mengurus laundry Anda.
        </p>

        <a href="{{ route('pelanggan.order') }}"
           class="btn btn-primary px-4">

            <i class="bi bi-plus-circle me-1"></i>
            Mulai Pesan Laundry

        </a>

    </div>

</div>


@endsection


@section('scripts')

<script>

function klaimPromo(promoId) {

    if (!confirm(
        'Yakin ingin mengklaim promo ini? Anda akan mendapat kode promo setelah disetujui admin.'
    )) {
        return;
    }

    const btn = document.getElementById(`btn-klaim-${promoId}`);

    if (!btn) {
        return;
    }

    const btnText = btn.querySelector('.btn-text');
    const btnLoading = btn.querySelector('.btn-loading');

    btn.disabled = true;

    btnText.classList.add('d-none');
    btnLoading.classList.remove('d-none');

    fetch('/pelanggan/promo/klaim', {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':
                document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
        },

        body: JSON.stringify({
            promo_id: promoId
        })

    })

    .then(response => response.json())

    .then(data => {

        if (data.success) {

            alert(
                'Promo berhasil diklaim! Admin akan memvalidasi dan mengirim kode promo via WhatsApp.'
            );

            const modalElement =
                document.getElementById('promoModal');

            const modal =
                bootstrap.Modal.getInstance(modalElement);

            if (modal) {
                modal.hide();
            }

            location.reload();

        } else {

            alert(
                data.message ||
                'Gagal mengklaim promo.'
            );

            resetPromoButton();

        }

    })

    .catch(error => {

        console.error(error);

        alert(
            'Terjadi kesalahan. Silakan coba lagi.'
        );

        resetPromoButton();

    });


    function resetPromoButton() {

        btn.disabled = false;

        btnText.classList.remove('d-none');
        btnLoading.classList.add('d-none');

    }
}

</script>

@endsection