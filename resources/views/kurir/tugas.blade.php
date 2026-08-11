@extends('layouts.app')

@section('title', 'Tugas Kurir')

@section('content')
<style>
    /* =========================
       PAGE HEADER
    ========================== */
    .courier-header {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border-radius: 18px;
        color: #fff;
        padding: 1.75rem 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 25px rgba(37, 99, 235, .18);
    }

    .courier-header-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: rgba(255,255,255,.16);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        flex-shrink: 0;
    }

    .courier-header h1 {
        font-size: 1.55rem;
        letter-spacing: -.02em;
    }

    /* =========================
       FILTER
    ========================== */
    .filter-card {
        border: 1px solid #e9eef5;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 3px 15px rgba(15, 23, 42, .05);
        margin-bottom: 1.5rem;
    }

    .filter-label {
        font-size: .85rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: .5rem;
    }

    .filter-card .form-select {
        min-height: 44px;
        border-radius: 10px;
        border-color: #dbe2ea;
    }

    .filter-card .btn {
        min-height: 44px;
        border-radius: 10px;
        font-weight: 600;
    }

    /* =========================
       TASK CARD
    ========================== */
    .task-card {
        position: relative;
        overflow: hidden;
        border: 1px solid #e9eef5;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 3px 15px rgba(15, 23, 42, .055);
        margin-bottom: 1rem;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, .09);
    }

    .task-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #94a3b8;
    }

    .task-card.status-dijemput::before {
        background: #f59e0b;
    }

    .task-card.status-proses::before {
        background: #3b82f6;
    }

    .task-card.status-siap::before {
        background: #10b981;
    }

    .task-card.status-selesai::before {
        background: #64748b;
    }

    /* =========================
       STATUS ICON
    ========================== */
    .status-icon {
        width: 50px;
        height: 50px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    /* =========================
       STATUS BADGE
    ========================== */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: .4rem .7rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 600;
        line-height: 1;
        white-space: nowrap;
    }

    /* =========================
       CUSTOMER INFO
    ========================== */
    .customer-name {
        font-size: .95rem;
        font-weight: 600;
        color: #1e293b;
    }

    .task-info {
        color: #64748b;
        font-size: .82rem;
        line-height: 1.5;
    }

    .task-info i {
        width: 18px;
        display: inline-block;
        text-align: center;
        margin-right: 4px;
    }

    .package-badge {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        border-radius: 8px;
        padding: .35rem .6rem;
        font-size: .72rem;
        font-weight: 500;
    }

    /* =========================
       PRICE / WEIGHT
    ========================== */
    .task-price {
        font-size: 1rem;
        font-weight: 700;
        color: #059669;
    }

    .weight-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #dbeafe;
        border-radius: 8px;
        padding: .35rem .6rem;
        font-size: .72rem;
        font-weight: 600;
    }

    /* =========================
       ACTION AREA
    ========================== */
    .task-action-area {
        border-left: 1px solid #edf1f5;
        padding-left: 1.5rem;
    }

    .action-btn {
        width: 38px;
        height: 38px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .task-action-area .btn:not(.action-btn) {
        border-radius: 9px;
        font-weight: 600;
        font-size: .82rem;
    }

    .task-alert {
        border-radius: 9px;
        font-size: .78rem;
        margin-bottom: .75rem;
    }

    /* =========================
       EMPTY STATE
    ========================== */
    .empty-state {
        background: #fff;
        border: 1px solid #e9eef5;
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 3px 15px rgba(15, 23, 42, .05);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto 1.25rem;
    }

    /* =========================
       PAGINATION
    ========================== */
    .pagination {
        margin-bottom: 0;
    }

    .pagination svg,
    .pagination .w-5,
    .pagination .h-5 {
        width: 14px !important;
        height: 14px !important;
    }

    .pagination .inline-flex {
        border-radius: 8px !important;
        margin: 0 2px;
    }

    /* =========================
       RESPONSIVE
    ========================== */
    @media (max-width: 991.98px) {
        .task-action-area {
            border-left: 0;
            border-top: 1px solid #edf1f5;
            padding-left: 0;
            padding-top: 1rem;
            margin-top: 1rem;
        }
    }

    @media (max-width: 767.98px) {
        .courier-header {
            padding: 1.25rem;
            border-radius: 14px;
        }

        .courier-header-icon {
            width: 44px;
            height: 44px;
            font-size: 1.2rem;
        }

        .courier-header h1 {
            font-size: 1.25rem;
        }

        .task-card {
            border-radius: 14px;
        }

        .task-card .card-body {
            padding: 1rem !important;
        }

        .status-icon {
            width: 44px;
            height: 44px;
            font-size: 1.1rem;
        }

        .status-badge {
            font-size: .68rem;
            padding: .35rem .6rem;
        }

        .task-action-area {
            margin-top: .75rem;
        }
    }

    @media (max-width: 575.98px) {
        .courier-header {
            padding: 1rem;
        }

        .courier-header .date-wrapper {
            margin-top: .75rem;
            padding-top: .75rem;
            border-top: 1px solid rgba(255,255,255,.15);
        }

        .filter-card .card-body {
            padding: 1rem !important;
        }

        .task-card .row {
            --bs-gutter-y: .75rem;
        }

        .task-price {
            font-size: .95rem;
        }

        .action-btn {
            width: 36px;
            height: 36px;
        }
    }
</style>

{{-- =========================
     HEADER
========================= --}}
<div class="courier-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center gap-3">
                <div class="courier-header-icon">
                    <i class="bi bi-list-task"></i>
                </div>

                <div>
                    <h1 class="mb-1 fw-bold">Tugas Saya</h1>
                    <p class="mb-0 opacity-75 small">
                        Kelola tugas penjemputan dan pengantaran laundry
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 date-wrapper">
            <div class="d-flex align-items-center justify-content-md-end small">
                <i class="bi bi-calendar3 me-2"></i>
                <span>{{ now()->format('d F Y') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- =========================
     FILTER
========================= --}}
<div class="filter-card">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('kurir.tugas') }}">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-7 mb-3 mb-md-0">
                    <label for="status" class="filter-label">
                        <i class="bi bi-funnel me-1"></i>
                        Filter Status Tugas
                    </label>

                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>

                        <option value="request_jemput"
                            {{ request('status') == 'request_jemput' ? 'selected' : '' }}>
                            🕐 Perlu Dijemput
                        </option>

                        <option value="dijemput_kurir"
                            {{ request('status') == 'dijemput_kurir' ? 'selected' : '' }}>
                            🚛 Sudah Dijemput
                        </option>

                        <option value="proses_cuci"
                            {{ request('status') == 'proses_cuci' ? 'selected' : '' }}>
                            🧽 Sedang Dicuci
                        </option>

                        <option value="siap_antar"
                            {{ request('status') == 'siap_antar' ? 'selected' : '' }}>
                            📦 Siap Diantar
                        </option>

                        <option value="selesai"
                            {{ request('status') == 'selesai' ? 'selected' : '' }}>
                            ✅ Selesai
                        </option>
                    </select>
                </div>

                <div class="col-lg-4 col-md-5">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-funnel me-1"></i>
                            Terapkan
                        </button>

                        <a href="{{ route('kurir.tugas') }}"
                           class="btn btn-outline-secondary"
                           title="Reset Filter">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- =========================
     DAFTAR TUGAS
========================= --}}
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

                        case 'request_jemput':
                            $statusClass = 'status-dijemput';
                            $statusIcon = 'bi-clock';
                            $statusBg = 'bg-warning bg-opacity-10 text-warning';
                            $statusText = 'bg-warning text-dark';
                            break;

                        case 'dijemput_kurir':
                            $statusClass = 'status-dijemput';
                            $statusIcon = 'bi-truck';
                            $statusBg = 'bg-warning bg-opacity-10 text-warning';
                            $statusText = 'bg-warning text-dark';
                            break;

                        case 'proses_cuci':
                            $statusClass = 'status-proses';
                            $statusIcon = 'bi-arrow-repeat';
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
                            $statusBg = 'bg-secondary bg-opacity-10 text-secondary';
                            $statusText = 'bg-secondary text-white';
                            break;
                    }
                @endphp

                <div class="task-card {{ $statusClass }}">

                    <div class="card-body p-4">

                        <div class="row align-items-center">

                            {{-- INFORMASI TUGAS --}}
                            <div class="col-lg-8 col-md-7">

                                <div class="d-flex align-items-start">

                                    <div class="status-icon {{ $statusBg }} me-3">
                                        <i class="bi {{ $statusIcon }}"></i>
                                    </div>

                                    <div class="flex-grow-1">

                                        {{-- Invoice + Status --}}
                                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">

                                            <h5 class="mb-0 fw-bold">
                                                {{ $transaksi->kode_invoice }}
                                            </h5>

                                            @if($transaksi->status_transaksi === 'request_jemput')

                                                <span class="status-badge {{ $statusText }}">
                                                    <i class="bi bi-clock me-1"></i>
                                                    Perlu Dijemput
                                                </span>

                                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')

                                                <span class="status-badge {{ $statusText }}">
                                                    <i class="bi bi-truck me-1"></i>
                                                    Sudah Dijemput
                                                </span>

                                            @elseif($transaksi->status_transaksi === 'proses_cuci')

                                                <span class="status-badge {{ $statusText }}">
                                                    <i class="bi bi-arrow-repeat me-1"></i>
                                                    Sedang Dicuci
                                                </span>

                                            @elseif($transaksi->status_transaksi === 'siap_antar')

                                                <span class="status-badge {{ $statusText }}">
                                                    <i class="bi bi-box-arrow-up me-1"></i>
                                                    Siap Diantar
                                                </span>

                                            @elseif($transaksi->status_transaksi === 'selesai')

                                                <span class="status-badge {{ $statusText }}">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Selesai
                                                </span>

                                            @endif

                                        </div>

                                        {{-- Customer --}}
                                        <div class="mb-2">
                                            <div class="customer-name">
                                                <i class="bi bi-person-circle text-primary me-1"></i>
                                                {{ $transaksi->user->name }}
                                            </div>

                                            <div class="task-info mt-1">
                                                <i class="bi bi-telephone"></i>
                                                {{ $transaksi->user->phone }}
                                            </div>
                                        </div>

                                        {{-- Address --}}
                                        <div class="task-info mb-2">
                                            <i class="bi bi-geo-alt-fill text-danger"></i>
                                            {{ $transaksi->alamat_jemput }}
                                        </div>

                                        {{-- Catatan --}}
                                        @if($transaksi->catatan)
                                            <div class="task-info mb-2">
                                                <i class="bi bi-chat-left-text"></i>
                                                <em>{{ $transaksi->catatan }}</em>
                                            </div>
                                        @endif

                                        {{-- Paket --}}
                                        <div class="d-flex flex-wrap gap-1 mb-2">

                                            @foreach($transaksi->detailTransaksis as $detail)

                                                <span class="package-badge">
                                                    <i class="bi bi-box me-1"></i>
                                                    {{ $detail->paket->nama_paket }}
                                                </span>

                                            @endforeach

                                        </div>

                                        {{-- Weight + Price --}}
                                        <div class="d-flex flex-wrap align-items-center gap-2">

                                            @if($transaksi->berat_aktual)
                                                <span class="weight-badge">
                                                    <i class="bi bi-speedometer2"></i>
                                                    {{ $transaksi->berat_aktual }} kg
                                                </span>
                                            @endif

                                            <span class="task-price">
                                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            {{-- ACTION --}}
                            <div class="col-lg-4 col-md-5">

                                <div class="task-action-area">

                                    <small class="text-muted d-block mb-3">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $transaksi->created_at->format('d/m/Y H:i') }}
                                    </small>

                                    {{-- Status Action --}}
                                    @if($transaksi->status_transaksi === 'request_jemput')

                                        <form method="POST"
                                              action="{{ route('kurir.transaksi.status', $transaksi) }}"
                                              class="mb-3">

                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden"
                                                   name="status_transaksi"
                                                   value="dijemput_kurir">

                                            <button type="submit"
                                                    class="btn btn-warning w-100"
                                                    onclick="return confirm('Konfirmasi bahwa Anda sudah menjemput laundry?')">

                                                <i class="bi bi-truck me-1"></i>
                                                Konfirmasi Jemput

                                            </button>

                                        </form>

                                    @elseif($transaksi->status_transaksi === 'siap_antar')

                                        <form method="POST"
                                              action="{{ route('kurir.transaksi.status', $transaksi) }}"
                                              class="mb-3">

                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden"
                                                   name="status_transaksi"
                                                   value="selesai">

                                            <button type="submit"
                                                    class="btn btn-success w-100"
                                                    onclick="return confirm('Konfirmasi pengantaran selesai?')">

                                                <i class="bi bi-check-circle me-1"></i>
                                                Selesai Antar

                                            </button>

                                        </form>

                                    @elseif($transaksi->status_transaksi === 'dijemput_kurir')

                                        <div class="alert alert-warning task-alert py-2">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Menunggu proses cuci
                                        </div>

                                    @elseif($transaksi->status_transaksi === 'proses_cuci')

                                        <div class="alert alert-info task-alert py-2">
                                            <i class="bi bi-arrow-repeat me-1"></i>
                                            Sedang dicuci
                                        </div>

                                    @elseif($transaksi->status_transaksi === 'selesai')

                                        <div class="alert alert-success task-alert py-2">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Pengantaran selesai
                                        </div>

                                    @endif

                                    {{-- Action Buttons --}}
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
                                           class="action-btn btn btn-outline-primary"
                                           title="Detail">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($message) }}"
                                           target="_blank"
                                           class="action-btn btn btn-outline-success"
                                           title="WhatsApp">

                                            <i class="bi bi-whatsapp"></i>

                                        </a>

                                        <a href="https://maps.google.com/?q={{ urlencode($transaksi->alamat_jemput) }}"
                                           target="_blank"
                                           class="action-btn btn btn-outline-info"
                                           title="Google Maps">

                                            <i class="bi bi-geo-alt"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

            {{-- Pagination --}}
            @if($transaksis->hasPages())

                <div class="d-flex justify-content-center mt-4">

                    {{ $transaksis->appends(request()->query())->links() }}

                </div>

            @endif

        @else

            {{-- Empty --}}
            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-inbox"></i>
                </div>

                <h4 class="fw-bold text-dark mb-2">
                    Belum Ada Tugas
                </h4>

                <p class="text-muted mb-4">
                    Tugas akan muncul di sini setelah admin menugaskan Anda.
                </p>

                <a href="{{ route('kurir.dashboard') }}"
                   class="btn btn-primary px-4">

                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali ke Dashboard

                </a>

            </div>

        @endif

    </div>
</div>

@endsection