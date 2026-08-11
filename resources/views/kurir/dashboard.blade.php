@extends('layouts.app')

@section('title', 'Dashboard Kurir')

@section('content')

<style>
    .kurir-dashboard {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* =========================
       HEADER
    ========================= */
    .welcome-card {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: white;
        border-radius: 18px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.18);
    }

    .welcome-card h4 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .welcome-card p {
        margin: 0;
        opacity: .9;
        font-size: 14px;
    }

    .date-box {
        background: rgba(255,255,255,.15);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    /* =========================
       STAT
    ========================= */
    .stat-card {
        background: #fff;
        border: 1px solid #eef0f4;
        border-radius: 15px;
        padding: 18px;
        height: 100%;
        transition: .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(0,0,0,.07);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-number {
        font-size: 23px;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-label {
        color: #6b7280;
        font-size: 12px;
    }

    /* =========================
       SECTION
    ========================= */
    .section-card {
        background: #fff;
        border: 1px solid #eef0f4;
        border-radius: 16px;
        overflow: hidden;
    }

    .section-header {
        padding: 17px 20px;
        border-bottom: 1px solid #eef0f4;
    }

    .section-header h6 {
        font-weight: 700;
        margin: 0;
    }

    /* =========================
       TASK
    ========================= */
    .task-card {
        padding: 18px 20px;
        border-bottom: 1px solid #f0f1f4;
        transition: .2s ease;
    }

    .task-card:last-child {
        border-bottom: none;
    }

    .task-card:hover {
        background: #fafbff;
    }

    .task-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
    }

    .task-title {
        font-size: 14px;
        font-weight: 700;
        color: #1f2937;
    }

    .customer-name {
        font-size: 13px;
        color: #374151;
        font-weight: 500;
    }

    .address {
        color: #6b7280;
        font-size: 12px;
        line-height: 1.5;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .task-time {
        font-size: 11px;
        color: #9ca3af;
    }

    .task-actions .btn {
        width: 34px;
        height: 34px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
    }

    /* =========================
       EMPTY
    ========================= */
    .empty-state {
        padding: 50px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        font-size: 28px;
    }

    /* =========================
       MOBILE
    ========================= */
    @media (max-width: 768px) {

        .kurir-dashboard {
            padding: 0;
        }

        .welcome-card {
            padding: 18px;
            border-radius: 14px;
            margin-bottom: 15px;
        }

        .welcome-card h4 {
            font-size: 17px;
        }

        .welcome-card p {
            font-size: 12px;
        }

        .date-box {
            margin-top: 12px;
            font-size: 11px;
            padding: 8px 11px;
        }

        .stat-card {
            padding: 14px 12px;
            border-radius: 12px;
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            font-size: 15px;
        }

        .stat-number {
            font-size: 19px;
        }

        .stat-label {
            font-size: 10px;
        }

        .section-header {
            padding: 14px 15px;
        }

        .section-header h6 {
            font-size: 13px;
        }

        .task-card {
            padding: 15px;
        }

        .task-icon {
            width: 38px;
            height: 38px;
            font-size: 15px;
        }

        .task-title {
            font-size: 12px;
        }

        .customer-name {
            font-size: 11px;
        }

        .address {
            font-size: 10px;
        }

        .status-badge {
            font-size: 9px;
            padding: 4px 8px;
        }

        .task-time {
            font-size: 9px;
        }

        .task-actions .btn {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }
    }
</style>

<div class="kurir-dashboard">

    {{-- =========================
        WELCOME
    ========================== --}}
    <div class="welcome-card">
        <div class="row align-items-center">

            <div class="col-md-8">
                <h4>
                    Halo, {{ auth()->user()->name }} 👋
                </h4>

                <p>
                    Berikut tugas pengantaran yang perlu kamu selesaikan hari ini.
                </p>
            </div>

            <div class="col-md-4 text-md-end">
                <div class="date-box">
                    <i class="bi bi-calendar3"></i>
                    {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>

        </div>
    </div>


    {{-- =========================
        STATISTIK
    ========================== --}}
    <div class="row g-3 mb-4">

        {{-- Tugas Baru --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card">

                <div class="d-flex align-items-center">

                    <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-bell"></i>
                    </div>

                    <div>
                        <div class="stat-number">
                            {{ $tugasBaru }}
                        </div>

                        <div class="stat-label">
                            Tugas Baru
                        </div>
                    </div>

                </div>

            </div>
        </div>


        {{-- Dalam Proses --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card">

                <div class="d-flex align-items-center">

                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>

                    <div>
                        <div class="stat-number">
                            {{ $tugasProses }}
                        </div>

                        <div class="stat-label">
                            Dalam Proses
                        </div>
                    </div>

                </div>

            </div>
        </div>


        {{-- Selesai --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card">

                <div class="d-flex align-items-center">

                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-check-lg"></i>
                    </div>

                    <div>
                        <div class="stat-number">
                            {{ $tugasSelesai }}
                        </div>

                        <div class="stat-label">
                            Selesai Hari Ini
                        </div>
                    </div>

                </div>

            </div>
        </div>


        {{-- Total --}}
        <div class="col-6 col-lg-3">
            <div class="stat-card">

                <div class="d-flex align-items-center">

                    <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                        <i class="bi bi-list-check"></i>
                    </div>

                    <div>
                        <div class="stat-number">
                            {{ $totalTugas }}
                        </div>

                        <div class="stat-label">
                            Total Tugas
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>


    {{-- =========================
        TUGAS HARI INI
    ========================== --}}
    <div class="section-card mb-4">

        <div class="section-header d-flex justify-content-between align-items-center">

            <div>
                <h6>
                    <i class="bi bi-truck text-primary me-1"></i>
                    Tugas Hari Ini
                </h6>

                <small class="text-muted">
                    Tugas yang perlu kamu kerjakan
                </small>
            </div>

            <a href="{{ route('kurir.tugas') }}"
               class="btn btn-sm btn-outline-primary">

                <i class="bi bi-list"></i>

                <span class="d-none d-sm-inline">
                    Semua Tugas
                </span>

            </a>

        </div>


        {{-- LIST TUGAS --}}
        @if($transaksiTerbaru->count() > 0)

            @foreach($transaksiTerbaru as $transaksi)

                @php

                    $status = $transaksi->status_transaksi;

                    /*
                    |--------------------------------------------------------------------------
                    | Status
                    |--------------------------------------------------------------------------
                    */

                    if ($status === 'dijemput_kurir') {

                        $statusText = 'Jemput Laundry';
                        $statusClass = 'bg-warning text-dark';
                        $icon = 'bi-truck';
                        $iconClass = 'bg-warning bg-opacity-10 text-warning';

                    } elseif ($status === 'siap_antar') {

                        $statusText = 'Siap Diantar';
                        $statusClass = 'bg-success text-white';
                        $icon = 'bi-box-seam';
                        $iconClass = 'bg-success bg-opacity-10 text-success';

                    } elseif ($status === 'selesai') {

                        $statusText = 'Selesai';
                        $statusClass = 'bg-secondary text-white';
                        $icon = 'bi-check-circle';
                        $iconClass = 'bg-secondary bg-opacity-10 text-secondary';

                    } else {

                        $statusText = 'Dalam Proses';
                        $statusClass = 'bg-primary text-white';
                        $icon = 'bi-clock';
                        $iconClass = 'bg-primary bg-opacity-10 text-primary';

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Nomor WhatsApp
                    |--------------------------------------------------------------------------
                    */

                    $cleanPhone = preg_replace(
                        '/[^0-9]/',
                        '',
                        $transaksi->user->phone ?? ''
                    );

                    if (
                        $cleanPhone &&
                        substr($cleanPhone, 0, 1) === '0'
                    ) {
                        $cleanPhone = '62' . substr($cleanPhone, 1);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | WhatsApp Message
                    |--------------------------------------------------------------------------
                    */

                    $message =
                        "Halo {$transaksi->user->name}, " .
                        "saya kurir dari JasaLaundry untuk pesanan " .
                        "{$transaksi->kode_invoice}.";

                @endphp


                <div class="task-card">

                    <div class="row align-items-center">

                        {{-- INFO TUGAS --}}
                        <div class="col-lg-8">

                            <div class="d-flex align-items-start">

                                {{-- ICON --}}
                                <div class="task-icon {{ $iconClass }} me-3">
                                    <i class="bi {{ $icon }}"></i>
                                </div>


                                {{-- DETAIL --}}
                                <div class="flex-grow-1">

                                    <div class="d-flex align-items-center gap-2 flex-wrap">

                                        <span class="task-title">
                                            {{ $transaksi->kode_invoice }}
                                        </span>

                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>

                                    </div>


                                    <div class="customer-name mt-1">

                                        <i class="bi bi-person me-1"></i>

                                        {{ $transaksi->user->name }}

                                    </div>


                                    <div class="address mt-1">

                                        <i class="bi bi-geo-alt me-1"></i>

                                        {{ Str::limit($transaksi->alamat_jemput, 80) }}

                                    </div>


                                    {{-- PAKET --}}
                                    <div class="mt-2 d-flex flex-wrap gap-1">

                                        @foreach($transaksi->detailTransaksis as $detail)

                                            <span class="badge bg-light text-dark border"
                                                  style="font-size:10px; font-weight:500;">

                                                {{ $detail->paket->nama_paket }}

                                            </span>

                                        @endforeach

                                    </div>


                                    <div class="task-time mt-2">

                                        <i class="bi bi-clock me-1"></i>

                                        {{ $transaksi->created_at->format('d/m/Y H:i') }}

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ACTION --}}
                        <div class="col-lg-4 mt-3 mt-lg-0">

                            <div class="task-actions d-flex justify-content-lg-end gap-2">

                                {{-- Detail --}}
                                <a href="{{ route('kurir.transaksi.show', $transaksi) }}"
                                   class="btn btn-outline-primary"
                                   title="Lihat Detail">

                                    <i class="bi bi-eye"></i>

                                </a>


                                {{-- WhatsApp --}}
                                @if($cleanPhone)

                                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($message) }}"
                                       target="_blank"
                                       class="btn btn-outline-success"
                                       title="Hubungi Pelanggan">

                                        <i class="bi bi-whatsapp"></i>

                                    </a>

                                @endif


                                {{-- Maps --}}
                                @if($transaksi->alamat_jemput)

                                    <a href="https://maps.google.com/?q={{ urlencode($transaksi->alamat_jemput) }}"
                                       target="_blank"
                                       class="btn btn-outline-info"
                                       title="Buka Maps">

                                        <i class="bi bi-geo-alt"></i>

                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        @else

            {{-- EMPTY --}}
            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-check2-all"></i>
                </div>

                <h6 class="fw-bold">
                    Tidak ada tugas hari ini
                </h6>

                <p class="text-muted small mb-3">
                    Saat ada tugas baru, tugas tersebut akan muncul di sini.
                </p>

                <a href="{{ route('kurir.tugas') }}"
                   class="btn btn-sm btn-outline-primary">

                    <i class="bi bi-clock-history me-1"></i>

                    Lihat Riwayat

                </a>

            </div>

        @endif

    </div>


    {{-- =========================
        PETUNJUK SINGKAT
    ========================== --}}
    <div class="section-card mb-4">

        <div class="section-header">

            <h6>
                <i class="bi bi-info-circle text-primary me-1"></i>
                Cara Kerja
            </h6>

        </div>

        <div class="card-body p-3">

            <div class="row g-3">

                <div class="col-4 text-center">

                    <div class="stat-icon bg-warning bg-opacity-10 text-warning mx-auto mb-2">
                        <i class="bi bi-truck"></i>
                    </div>

                    <small class="fw-semibold d-block">
                        Jemput
                    </small>

                    <small class="text-muted" style="font-size:10px;">
                        Ambil laundry
                    </small>

                </div>


                <div class="col-4 text-center">

                    <div class="stat-icon bg-success bg-opacity-10 text-success mx-auto mb-2">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <small class="fw-semibold d-block">
                        Antar
                    </small>

                    <small class="text-muted" style="font-size:10px;">
                        Antar ke pelanggan
                    </small>

                </div>


                <div class="col-4 text-center">

                    <div class="stat-icon bg-primary bg-opacity-10 text-primary mx-auto mb-2">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <small class="fw-semibold d-block">
                        Selesai
                    </small>

                    <small class="text-muted" style="font-size:10px;">
                        Selesaikan tugas
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection