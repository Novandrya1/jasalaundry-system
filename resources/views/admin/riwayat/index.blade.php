@extends('layouts.app')

@section('title', 'Laporan & Riwayat')

@section('content')

<style>
    .report-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border-radius: 18px;
        padding: 28px 30px;
        color: white;
        margin-bottom: 24px;
        box-shadow: 0 8px 25px rgba(17, 153, 142, 0.20);
    }

    .report-header h1 {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .report-header p {
        margin-bottom: 0;
        opacity: .9;
    }

    .report-date {
        background: rgba(255, 255, 255, .18);
        border: 1px solid rgba(255, 255, 255, .3);
        border-radius: 12px;
        padding: 12px 16px;
        text-align: center;
    }

    .report-date small {
        display: block;
        opacity: .8;
        margin-bottom: 3px;
    }

    .report-date strong {
        font-size: 18px;
    }

    .stat-card {
        background: white;
        border: none;
        border-radius: 15px;
        padding: 20px;
        height: 100%;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .07);
        transition: .2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 22px rgba(0, 0, 0, .10);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .icon-blue {
        background: #e8f1ff;
        color: #0d6efd;
    }

    .icon-green {
        background: #e8f8ef;
        color: #198754;
    }

    .icon-cyan {
        background: #e7f9fc;
        color: #0dcaf0;
    }

    .icon-orange {
        background: #fff3df;
        color: #fd7e14;
    }

    .stat-label {
        color: #6b7280;
        font-size: 14px;
        margin-top: 12px;
        margin-bottom: 3px;
    }

    .stat-value {
        font-size: 23px;
        font-weight: 700;
        color: #1f2937;
    }

    .section-card {
        background: white;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .07);
        overflow: hidden;
    }

    .section-title {
        padding: 18px 20px;
        border-bottom: 1px solid #eef1f4;
        font-weight: 600;
        font-size: 17px;
        color: #1f2937;
    }

    .filter-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 18px;
        border: 1px solid #edf0f4;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .form-select,
    .form-control {
        border-radius: 9px;
        min-height: 42px;
        border-color: #dfe3e8;
    }

    .form-select:focus,
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .10);
    }

    .quick-btn {
        border-radius: 9px;
        font-size: 13px;
    }

    .table-report {
        margin-bottom: 0;
    }

    .table-report th {
        background: #f8fafc;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        border-bottom: 1px solid #e5e7eb;
        padding: 14px;
        white-space: nowrap;
    }

    .table-report td {
        padding: 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .table-report tbody tr:hover {
        background: #f8fafc;
    }

    .invoice-code {
        font-weight: 700;
        color: #0d6efd;
    }

    .customer-name {
        font-weight: 600;
        color: #1f2937;
    }

    .amount {
        font-weight: 700;
        color: #198754;
    }

    .status-pill {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 4px;
        white-space: nowrap;
    }

    .summary-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #edf0f4;
    }

    .summary-box .label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .summary-box .value {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 50px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }

    .mobile-report-card {
        background: white;
        border: 1px solid #edf0f4;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 12px;
    }

    .mobile-report-card hr {
        border-color: #edf0f4;
    }

    .chart-wrapper {
        position: relative;
        height: 300px;
    }

    @media (max-width: 768px) {
        .report-header {
            padding: 22px;
        }

        .report-header h1 {
            font-size: 24px;
        }

        .report-date {
            margin-top: 15px;
        }

        .stat-value {
            font-size: 20px;
        }

        .chart-wrapper {
            height: 260px;
        }
    }
</style>


{{-- =====================================================
     HEADER LAPORAN
===================================================== --}}
<div class="report-header">

    <div class="row align-items-center">

        <div class="col-md-8">

            <div class="d-flex align-items-center gap-2 mb-2">

                <i class="bi bi-bar-chart-line-fill fs-3"></i>

                <h1 class="mb-0">
                    Laporan & Riwayat
                </h1>

            </div>

            <p>
                Kelola transaksi dan buat laporan keuangan laundry berdasarkan periode.
            </p>

        </div>


        <div class="col-md-4">

            <div class="report-date">

                <small>
                    Periode laporan
                </small>

                @if(request('tanggal_mulai') || request('tanggal_selesai'))

                    <strong>

                        @if(request('tanggal_mulai'))

                            {{ \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d/m/Y') }}

                        @else

                            -

                        @endif

                        &nbsp; - &nbsp;

                        @if(request('tanggal_selesai'))

                            {{ \Carbon\Carbon::parse(request('tanggal_selesai'))->format('d/m/Y') }}

                        @else

                            -

                        @endif

                    </strong>

                @else

                    <strong>
                        {{ now()->format('d/m/Y') }}
                    </strong>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
     INFORMASI PERIODE
===================================================== --}}
<div class="alert alert-info border-0 shadow-sm mb-4"
     style="border-radius: 12px;">

    <div class="d-flex align-items-start gap-2">

        <i class="bi bi-info-circle-fill mt-1"></i>

        <div>

            @if(request('tanggal_mulai') || request('tanggal_selesai'))

                <strong>
                    Laporan berdasarkan periode yang dipilih.
                </strong>

                <div class="small mt-1">
                    Data transaksi dan pendapatan pada halaman ini mengikuti filter yang digunakan.
                </div>

            @else

                <strong>
                    Laporan hari ini.
                </strong>

                <div class="small mt-1">
                    Secara default sistem menampilkan transaksi hari ini.
                    Gunakan filter periode untuk melihat laporan tanggal lain.
                </div>

            @endif

        </div>

    </div>

</div>


{{-- =====================================================
     STATISTIK LAPORAN
===================================================== --}}
<div class="row g-3 mb-4">


    {{-- Total transaksi --}}
    <div class="col-xl-3 col-md-6">

        <div class="stat-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <div class="stat-label mt-0">
                        Total Transaksi
                    </div>

                    <div class="stat-value text-primary">
                        {{ number_format($totalTransaksi, 0, ',', '.') }}
                    </div>

                </div>

                <div class="stat-icon icon-blue">
                    <i class="bi bi-receipt"></i>
                </div>

            </div>

        </div>

    </div>


    {{-- Pendapatan --}}
    <div class="col-xl-3 col-md-6">

        <div class="stat-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <div class="stat-label mt-0">
                        Pendapatan Laporan
                    </div>

                    <div class="stat-value text-success" style="font-size:20px;">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </div>

                </div>

                <div class="stat-icon icon-green">
                    <i class="bi bi-cash-stack"></i>
                </div>

            </div>

        </div>

    </div>


    {{-- Pendapatan bulan --}}
    <div class="col-xl-3 col-md-6">

        <div class="stat-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <div class="stat-label mt-0">
                        Pendapatan Bulan Ini
                    </div>

                    <div class="stat-value text-info" style="font-size:20px;">
                        Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                    </div>

                </div>

                <div class="stat-icon icon-cyan">
                    <i class="bi bi-calendar-month"></i>
                </div>

            </div>

        </div>

    </div>


    {{-- Rata-rata --}}
    <div class="col-xl-3 col-md-6">

        <div class="stat-card">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <div class="stat-label mt-0">

                        @if(request('tanggal_mulai') && request('tanggal_selesai'))

                            Rata-rata Pendapatan / Hari

                        @else

                            Pendapatan Hari Ini

                        @endif

                    </div>

                    <div class="stat-value text-warning" style="font-size:20px;">
                        Rp {{ number_format($rataRataHarian, 0, ',', '.') }}
                    </div>

                </div>

                <div class="stat-icon icon-orange">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
     QUICK PERIOD
===================================================== --}}
<div class="section-card mb-4">

    <div class="section-title">

        <i class="bi bi-calendar3 me-2"></i>

        Pilih Periode Laporan

    </div>


    <div class="p-3">

        <div class="d-flex flex-wrap gap-2">

            {{-- Hari Ini --}}
            <a href="{{ route('admin.riwayat.index') }}"
               class="btn btn-primary quick-btn">

                <i class="bi bi-calendar-day me-1"></i>

                Hari Ini

            </a>


            {{-- Kemarin --}}
            <a href="{{ route('admin.riwayat.index', [
                    'tanggal_mulai' => now()->subDay()->format('Y-m-d'),
                    'tanggal_selesai' => now()->subDay()->format('Y-m-d')
                ]) }}"
               class="btn btn-outline-primary quick-btn">

                <i class="bi bi-calendar-minus me-1"></i>

                Kemarin

            </a>


            {{-- 7 Hari --}}
            <a href="{{ route('admin.riwayat.index', [
                    'tanggal_mulai' => now()->subDays(6)->format('Y-m-d'),
                    'tanggal_selesai' => now()->format('Y-m-d')
                ]) }}"
               class="btn btn-outline-primary quick-btn">

                <i class="bi bi-calendar-week me-1"></i>

                7 Hari Terakhir

            </a>


            {{-- Bulan --}}
            <a href="{{ route('admin.riwayat.index', [
                    'tanggal_mulai' => now()->startOfMonth()->format('Y-m-d'),
                    'tanggal_selesai' => now()->format('Y-m-d')
                ]) }}"
               class="btn btn-outline-primary quick-btn">

                <i class="bi bi-calendar-month me-1"></i>

                Bulan Ini

            </a>

        </div>

    </div>

</div>


{{-- =====================================================
     FILTER LAPORAN
===================================================== --}}
<div class="section-card mb-4">

    <div class="section-title">

        <i class="bi bi-funnel me-2"></i>

        Filter Laporan

    </div>


    <div class="p-3">

        <form method="GET"
              action="{{ route('admin.riwayat.index') }}">

            <div class="filter-box">

                <div class="row g-3">


                    {{-- Tanggal mulai --}}
                    <div class="col-lg-3 col-md-6">

                        <label class="form-label">
                            Tanggal Mulai
                        </label>

                        <input type="date"
                               class="form-control"
                               name="tanggal_mulai"
                               value="{{ request('tanggal_mulai') }}">

                    </div>


                    {{-- Tanggal selesai --}}
                    <div class="col-lg-3 col-md-6">

                        <label class="form-label">
                            Tanggal Selesai
                        </label>

                        <input type="date"
                               class="form-control"
                               name="tanggal_selesai"
                               value="{{ request('tanggal_selesai') }}">

                    </div>


                    {{-- Status pembayaran --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            Status Pembayaran
                        </label>

                        <select name="status_bayar"
                                class="form-select">

                            <option value="">
                                Semua
                            </option>

                            <option value="lunas"
                                {{ request('status_bayar') == 'lunas' ? 'selected' : '' }}>
                                Lunas
                            </option>

                            <option value="belum_bayar"
                                {{ request('status_bayar') == 'belum_bayar' ? 'selected' : '' }}>
                                Belum Bayar
                            </option>

                        </select>

                    </div>


                    {{-- Metode pembayaran --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            Metode Pembayaran
                        </label>

                        <select name="metode_bayar"
                                class="form-select">

                            <option value="">
                                Semua
                            </option>

                            <option value="tunai"
                                {{ request('metode_bayar') == 'tunai' ? 'selected' : '' }}>
                                Tunai
                            </option>

                            <option value="transfer"
                                {{ request('metode_bayar') == 'transfer' ? 'selected' : '' }}>
                                Transfer
                            </option>

                        </select>

                    </div>


                    {{-- Kurir --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label">
                            Kurir
                        </label>

                        <select name="kurir_id"
                                class="form-select">

                            <option value="">
                                Semua
                            </option>

                            @foreach($kurirs as $kurir)

                                <option value="{{ $kurir->id }}"
                                    {{ request('kurir_id') == $kurir->id ? 'selected' : '' }}>

                                    {{ $kurir->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Status transaksi --}}
                    <div class="col-lg-4 col-md-6">

                        <label class="form-label">
                            Status Transaksi
                        </label>

                        <select name="status"
                                class="form-select">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="request_jemput"
                                {{ request('status') == 'request_jemput' ? 'selected' : '' }}>
                                Menunggu Penjemputan
                            </option>

                            <option value="dijemput_kurir"
                                {{ request('status') == 'dijemput_kurir' ? 'selected' : '' }}>
                                Dijemput Kurir
                            </option>

                            <option value="proses_cuci"
                                {{ request('status') == 'proses_cuci' ? 'selected' : '' }}>
                                Sedang Dicuci
                            </option>

                            <option value="siap_antar"
                                {{ request('status') == 'siap_antar' ? 'selected' : '' }}>
                                Siap Diantar
                            </option>

                            <option value="selesai"
                                {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        </select>

                    </div>


                    {{-- Tombol --}}
                    <div class="col-lg-8 col-md-6 d-flex align-items-end">

                        <div class="d-flex flex-wrap gap-2 w-100">

                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="bi bi-search me-1"></i>

                                Tampilkan Laporan

                            </button>


                            <a href="{{ route('admin.riwayat.index') }}"
                               class="btn btn-outline-secondary">

                                <i class="bi bi-arrow-counterclockwise me-1"></i>

                                Reset

                            </a>


                            <button type="button"
                                    onclick="cetakLaporan()"
                                    class="btn btn-success">

                                <i class="bi bi-printer me-1"></i>

                                Cetak Laporan

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- =====================================================
     GRAFIK
===================================================== --}}
<div class="row g-4 mb-4">


    {{-- Grafik pendapatan --}}
    <div class="col-lg-8">

        <div class="section-card h-100">

            <div class="section-title">

                <i class="bi bi-bar-chart-line me-2"></i>

                Grafik Pendapatan

                @if(request('tanggal_mulai') && request('tanggal_selesai'))

                    <span class="text-muted fw-normal fs-6">
                        (periode dipilih)
                    </span>

                @else

                    <span class="text-muted fw-normal fs-6">
                        (7 hari terakhir)
                    </span>

                @endif

            </div>


            <div class="p-3">

                <div class="chart-wrapper">

                    <canvas id="pendapatanChart"></canvas>

                </div>

            </div>

        </div>

    </div>


    {{-- Grafik status --}}
    <div class="col-lg-4">

        <div class="section-card h-100">

            <div class="section-title">

                <i class="bi bi-pie-chart me-2"></i>

                Status Transaksi

            </div>


            <div class="p-3">

                <div class="chart-wrapper">

                    <canvas id="statusChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
     RINGKASAN LAPORAN
===================================================== --}}
<div class="section-card mb-4">

    <div class="section-title">

        <i class="bi bi-clipboard-data me-2"></i>

        Ringkasan Laporan

    </div>


    <div class="p-3">

        <div class="row g-3">


            {{-- Total transaksi --}}
            <div class="col-md-4">

                <div class="summary-box">

                    <div class="label">
                        Total Transaksi
                    </div>

                    <div class="value">
                        {{ number_format($totalTransaksi, 0, ',', '.') }}
                        transaksi
                    </div>

                </div>

            </div>


            {{-- Total pendapatan --}}
            <div class="col-md-4">

                <div class="summary-box">

                    <div class="label">
                        Total Pendapatan Lunas
                    </div>

                    <div class="value text-success">

                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}

                    </div>

                </div>

            </div>


            {{-- Periode --}}
            <div class="col-md-4">

                <div class="summary-box">

                    <div class="label">
                        Periode
                    </div>

                    <div class="value">

                        @if(request('tanggal_mulai') || request('tanggal_selesai'))

                            Periode Filter

                        @else

                            Hari Ini

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
     DAFTAR TRANSAKSI
===================================================== --}}
<div class="section-card">


    <div class="section-title d-flex justify-content-between align-items-center">

        <div>

            <i class="bi bi-receipt me-2"></i>

            Daftar Transaksi

        </div>


        <span class="badge bg-primary">

            {{ $totalTransaksi }} Transaksi

        </span>

    </div>


    @if($transaksis->count() > 0)


        {{-- =================================================
             DESKTOP
        ================================================== --}}
        <div class="table-responsive d-none d-lg-block">

            <table class="table table-report">

                <thead>

                    <tr>

                        <th>
                            Invoice
                        </th>

                        <th>
                            Pelanggan
                        </th>

                        <th>
                            Paket
                        </th>

                        <th>
                            Berat
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Pembayaran
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th class="text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($transaksis as $transaksi)

                        <tr>


                            {{-- Invoice --}}
                            <td>

                                <span class="invoice-code">

                                    {{ $transaksi->kode_invoice }}

                                </span>

                            </td>


                            {{-- Pelanggan --}}
                            <td>

                                <div class="customer-name">

                                    {{ $transaksi->user->name }}

                                </div>

                                <small class="text-muted">

                                    {{ $transaksi->user->phone ?? $transaksi->user->email }}

                                </small>

                            </td>


                            {{-- Paket --}}
                            <td>

                                @foreach($transaksi->detailTransaksis as $detail)

                                    <span class="badge bg-light text-dark border mb-1">

                                        {{ $detail->paket->nama_paket }}

                                    </span>

                                @endforeach

                            </td>


                            {{-- Berat --}}
                            <td>

                                @if($transaksi->berat_aktual)

                                    <span class="badge bg-info">

                                        {{ $transaksi->berat_aktual }} kg

                                    </span>

                                @else

                                    <small class="text-muted">

                                        Belum ditimbang

                                    </small>

                                @endif

                            </td>


                            {{-- Total --}}
                            <td>

                                @if($transaksi->diskon > 0)

                                    <small class="text-muted text-decoration-line-through">

                                        Rp
                                        {{ number_format(
                                            $transaksi->total_harga + $transaksi->diskon,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </small>

                                    <br>

                                    <small class="text-danger">

                                        Diskon Rp
                                        {{ number_format(
                                            $transaksi->diskon,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </small>

                                @endif


                                <div class="amount">

                                    Rp
                                    {{ number_format(
                                        $transaksi->total_harga,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </div>

                            </td>


                            {{-- Pembayaran --}}
                            <td>

                                @if($transaksi->status_bayar === 'lunas')

                                    <span class="status-pill bg-success text-white">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Lunas

                                    </span>

                                @else

                                    <span class="status-pill bg-danger text-white">

                                        <i class="bi bi-clock me-1"></i>

                                        Belum Bayar

                                    </span>

                                @endif


                                <br>


                                <small class="text-muted">

                                    @if($transaksi->metode_bayar === 'tunai')

                                        Tunai

                                    @elseif($transaksi->metode_bayar === 'transfer')

                                        Transfer

                                    @else

                                        -

                                    @endif

                                </small>

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($transaksi->status_transaksi === 'request_jemput')

                                    <span class="status-pill bg-warning text-dark">
                                        Menunggu
                                    </span>

                                @elseif($transaksi->status_transaksi === 'dijemput_kurir')

                                    <span class="status-pill bg-info text-white">
                                        Dijemput
                                    </span>

                                @elseif($transaksi->status_transaksi === 'proses_cuci')

                                    <span class="status-pill bg-primary text-white">
                                        Dicuci
                                    </span>

                                @elseif($transaksi->status_transaksi === 'siap_antar')

                                    <span class="status-pill bg-success text-white">
                                        Siap Antar
                                    </span>

                                @elseif($transaksi->status_transaksi === 'selesai')

                                    <span class="status-pill bg-dark text-white">
                                        Selesai
                                    </span>

                                @else

                                    <span class="status-pill bg-secondary text-white">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- Tanggal --}}
                            <td>

                                <div>

                                    {{ $transaksi->created_at->format('d/m/Y') }}

                                </div>

                                <small class="text-muted">

                                    {{ $transaksi->created_at->format('H:i') }}

                                </small>

                            </td>


                            {{-- Aksi --}}
                            <td>

                                <div class="d-flex gap-1 justify-content-center">

                                    <a href="{{ route('admin.transaksi.show', $transaksi) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Lihat transaksi">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    <a href="{{ route('admin.riwayat.cetak', $transaksi) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-success"
                                       title="Cetak transaksi">

                                        <i class="bi bi-printer"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- =================================================
             MOBILE
        ================================================== --}}
        <div class="d-lg-none p-3">

            @foreach($transaksis as $transaksi)

                <div class="mobile-report-card">


                    <div class="d-flex justify-content-between">

                        <div>

                            <div class="invoice-code">

                                {{ $transaksi->kode_invoice }}

                            </div>

                            <div class="customer-name mt-1">

                                {{ $transaksi->user->name }}

                            </div>

                        </div>


                        <div class="text-end">

                            @if($transaksi->status_bayar === 'lunas')

                                <span class="status-pill bg-success text-white">

                                    Lunas

                                </span>

                            @else

                                <span class="status-pill bg-danger text-white">

                                    Belum Bayar

                                </span>

                            @endif

                        </div>

                    </div>


                    <hr>


                    <div class="row">


                        <div class="col-7">

                            <small class="text-muted">
                                Paket
                            </small>

                            <div class="mt-1">

                                @foreach($transaksi->detailTransaksis as $detail)

                                    <span class="badge bg-light text-dark border">

                                        {{ $detail->paket->nama_paket }}

                                    </span>

                                @endforeach

                            </div>


                            <small class="text-muted d-block mt-2">

                                {{ $transaksi->created_at->format('d/m/Y H:i') }}

                            </small>

                        </div>


                        <div class="col-5 text-end">

                            <small class="text-muted">
                                Total
                            </small>

                            <div class="amount">

                                Rp
                                {{ number_format(
                                    $transaksi->total_harga,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </div>


                            @if($transaksi->berat_aktual)

                                <span class="badge bg-info mt-1">

                                    {{ $transaksi->berat_aktual }} kg

                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="d-flex justify-content-end gap-2 mt-3">

                        <a href="{{ route('admin.transaksi.show', $transaksi) }}"
                           class="btn btn-sm btn-outline-primary">

                            <i class="bi bi-eye"></i>

                            Lihat

                        </a>


                        <a href="{{ route('admin.riwayat.cetak', $transaksi) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-success">

                            <i class="bi bi-printer"></i>

                            Cetak

                        </a>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- =================================================
             PAGINATION
        ================================================== --}}
        @if($transaksis->hasPages())

            <div class="p-3 border-top d-flex justify-content-center">

                {{ $transaksis->appends(request()->query())->links() }}

            </div>

        @endif


    @else


        {{-- =================================================
             EMPTY STATE
        ================================================== --}}
        <div class="empty-state">

            <i class="bi bi-file-earmark-x"></i>

            <h5 class="text-muted">

                Tidak ada transaksi

            </h5>


            <p class="text-muted mb-4">

                @if(request('tanggal_mulai') || request('tanggal_selesai'))

                    Tidak ditemukan transaksi pada periode yang dipilih.

                @else

                    Belum ada transaksi untuk hari ini.

                @endif

            </p>


            <a href="{{ route('admin.riwayat.index') }}"
               class="btn btn-primary">

                <i class="bi bi-calendar-day me-1"></i>

                Lihat Hari Ini

            </a>

        </div>

    @endif

</div>

@endsection


{{-- =====================================================
     JAVASCRIPT
===================================================== --}}
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    /* =====================================================
       CETAK LAPORAN
    ===================================================== */

    function cetakLaporan() {

        const params = new URLSearchParams();


        const status =
            document.querySelector('[name="status"]').value;

        const statusBayar =
            document.querySelector('[name="status_bayar"]').value;

        const tanggalMulai =
            document.querySelector('[name="tanggal_mulai"]').value;

        const tanggalSelesai =
            document.querySelector('[name="tanggal_selesai"]').value;

        const metodeBayar =
            document.querySelector('[name="metode_bayar"]').value;

        const kurirId =
            document.querySelector('[name="kurir_id"]').value;


        if (status) {
            params.append('status', status);
        }

        if (statusBayar) {
            params.append('status_bayar', statusBayar);
        }

        if (tanggalMulai) {
            params.append('tanggal_mulai', tanggalMulai);
        }

        if (tanggalSelesai) {
            params.append('tanggal_selesai', tanggalSelesai);
        }

        if (metodeBayar) {
            params.append('metode_bayar', metodeBayar);
        }

        if (kurirId) {
            params.append('kurir_id', kurirId);
        }


        const url =
            '{{ route("admin.riwayat.cetak-laporan") }}'
            + '?'
            + params.toString();


        window.open(url, '_blank');

    }


    /* =====================================================
       GRAFIK PENDAPATAN
    ===================================================== */

    const pendapatanCanvas =
        document.getElementById('pendapatanChart');


    if (pendapatanCanvas) {

        const chartLabels =
            {!! json_encode($chartLabels) !!};

        const chartData =
            {!! json_encode($chartData) !!};


        const hasData =
            chartData.some(value => Number(value) > 0);


        new Chart(pendapatanCanvas, {

            type: 'line',

            data: {

                labels: chartLabels,

                datasets: [{

                    label: 'Pendapatan',

                    data: chartData,

                    borderColor: '#198754',

                    backgroundColor: 'rgba(25, 135, 84, 0.10)',

                    borderWidth: 2,

                    fill: true,

                    tension: 0.35,

                    pointRadius: 4,

                    pointHoverRadius: 6

                }]

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,


                interaction: {

                    intersect: false,

                    mode: 'index'

                },


                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {

                            callback: function(value) {

                                return 'Rp ' +
                                    Number(value)
                                    .toLocaleString('id-ID');

                            }

                        }

                    }

                },


                plugins: {

                    legend: {

                        display: false

                    },


                    tooltip: {

                        callbacks: {

                            label: function(context) {

                                return 'Pendapatan: Rp ' +
                                    Number(context.parsed.y)
                                    .toLocaleString('id-ID');

                            }

                        }

                    }

                }

            }

        });


        if (!hasData) {

            const parent =
                pendapatanCanvas.parentElement;

            const message =
                document.createElement('div');

            message.className =
                'text-center text-muted mt-2';

            message.innerHTML =
                '<i class="bi bi-info-circle me-1"></i>' +
                'Belum ada data pendapatan pada periode ini.';

            parent.appendChild(message);

        }

    }


    /* =====================================================
       GRAFIK STATUS TRANSAKSI
    ===================================================== */

    const statusCanvas =
        document.getElementById('statusChart');


    if (statusCanvas) {

        const statusLabels =
            {!! json_encode($statusLabels) !!};

        const statusData =
            {!! json_encode($statusData) !!};


        const hasStatusData =
            statusData.some(value => Number(value) > 0);


        if (hasStatusData) {

            new Chart(statusCanvas, {

                type: 'doughnut',

                data: {

                    labels: statusLabels,

                    datasets: [{

                        data: statusData,

                        backgroundColor: [

                            '#ffc107',

                            '#0dcaf0',

                            '#0d6efd',

                            '#198754',

                            '#212529'

                        ],

                        borderWidth: 2,

                        borderColor: '#ffffff'

                    }]

                },


                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    cutout: '65%',


                    plugins: {

                        legend: {

                            position: 'bottom',

                            labels: {

                                padding: 15,

                                usePointStyle: true

                            }

                        },


                        tooltip: {

                            callbacks: {

                                label: function(context) {

                                    return context.label +
                                        ': ' +
                                        context.parsed +
                                        ' transaksi';

                                }

                            }

                        }

                    }

                }

            });

        } else {

            const parent =
                statusCanvas.parentElement;


            parent.innerHTML = `

                <div class="h-100
                            d-flex
                            align-items-center
                            justify-content-center
                            text-muted">

                    <div class="text-center">

                        <i class="bi bi-pie-chart fs-1 mb-2 d-block"></i>

                        <div>
                            Belum ada data transaksi
                        </div>

                    </div>

                </div>

            `;

        }

    }

</script>

@endsection