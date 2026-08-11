@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')

<div class="container-fluid px-2 px-md-4">

    {{-- ================= HEADER ================= --}}
    <div class="task-header mb-4">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>

                    <div>
                        <div class="text-white-50 small mb-1">
                            TUGAS KURIR
                        </div>

                        <h2 class="fw-bold mb-1">
                            Detail Tugas
                        </h2>

                        <div class="header-meta">
                            <span>
                                <i class="bi bi-receipt me-1"></i>
                                {{ $transaksi->kode_invoice }}
                            </span>

                            <span class="mx-2">•</span>

                            <span>
                                <i class="bi bi-person me-1"></i>
                                {{ $transaksi->user->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('kurir.tugas') }}" class="btn btn-light header-back-btn">
                    <i class="bi bi-arrow-left me-2"></i>
                    Kembali ke Tugas
                </a>
            </div>
        </div>
    </div>


    <div class="row g-4">

        {{-- ================= LEFT CONTENT ================= --}}
        <div class="col-lg-8">

            {{-- INFORMASI PELANGGAN --}}
            <div class="modern-card mb-4">

                <div class="modern-card-header">
                    <div class="section-icon blue">
                        <i class="bi bi-person-circle"></i>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">Informasi Pelanggan</h5>
                        <small class="text-muted">
                            Informasi pesanan dan pelanggan
                        </small>
                    </div>
                </div>

                <div class="modern-card-body">

                    <div class="row g-3">

                        {{-- Invoice --}}
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">
                                    <i class="bi bi-receipt"></i>
                                    Kode Invoice
                                </div>

                                <div class="info-value text-primary">
                                    {{ $transaksi->kode_invoice }}
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal --}}
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">
                                    <i class="bi bi-calendar3"></i>
                                    Tanggal Pesanan
                                </div>

                                <div class="info-value">
                                    {{ $transaksi->created_at->format('d F Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">
                                    <i class="bi bi-person"></i>
                                    Nama Pelanggan
                                </div>

                                <div class="info-value">
                                    {{ $transaksi->user->name }}
                                </div>
                            </div>
                        </div>

                        {{-- Telepon --}}
                        <div class="col-md-6">
                            <div class="info-box">
                                <div class="info-label">
                                    <i class="bi bi-telephone"></i>
                                    Nomor Telepon
                                </div>

                                <div class="info-value">
                                    @if($transaksi->user->phone)
                                        <a href="tel:{{ $transaksi->user->phone }}"
                                           class="phone-link">
                                            <i class="bi bi-telephone-fill me-1"></i>
                                            {{ $transaksi->user->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">
                                            Nomor tidak tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-12">
                            <div class="address-box">

                                <div class="d-flex align-items-start gap-3">

                                    <div class="address-icon">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="info-label mb-1">
                                            Alamat Penjemputan / Pengantaran
                                        </div>

                                        <div class="address-text">
                                            {{ $transaksi->alamat_jemput }}
                                        </div>

                                        <a href="https://maps.google.com/?q={{ urlencode($transaksi->alamat_jemput) }}"
                                           target="_blank"
                                           class="btn btn-outline-primary btn-sm mt-3">
                                            <i class="bi bi-map me-1"></i>
                                            Buka Google Maps
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>

                        {{-- Catatan --}}
                        @if($transaksi->catatan)
                            <div class="col-12">
                                <div class="note-box">
                                    <div class="note-title">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        Catatan Khusus
                                    </div>

                                    <div class="note-text">
                                        {{ $transaksi->catatan }}
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>


            {{-- DETAIL PAKET --}}
            <div class="modern-card mb-4">

                <div class="modern-card-header">
                    <div class="section-icon green">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">Detail Paket Laundry</h5>
                        <small class="text-muted">
                            Rincian layanan laundry pelanggan
                        </small>
                    </div>
                </div>

                <div class="modern-card-body">

                    <div class="table-responsive">
                        <table class="table package-table align-middle">

                            <thead>
                                <tr>
                                    <th>Paket</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($transaksi->detailTransaksis as $detail)
                                    <tr>

                                        <td>
                                            <div class="package-name">
                                                <div class="package-mini-icon">
                                                    <i class="bi bi-droplet-fill"></i>
                                                </div>

                                                <span>
                                                    {{ $detail->paket->nama_paket }}
                                                </span>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="quantity-badge">
                                                {{ $detail->jumlah }}
                                                {{ $detail->paket->satuan }}
                                            </span>
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

                            <tfoot>

                                @if($transaksi->diskon > 0)
                                    <tr>
                                        <td colspan="3" class="text-muted">
                                            Subtotal
                                        </td>

                                        <td class="text-end fw-semibold">
                                            Rp {{ number_format($transaksi->total_harga + $transaksi->diskon, 0, ',', '.') }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" class="text-danger">
                                            Diskon
                                        </td>

                                        <td class="text-end text-danger fw-semibold">
                                            -Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endif

                                <tr class="total-row">
                                    <td colspan="3">
                                        Total Pembayaran
                                    </td>

                                    <td class="text-end">
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                    </td>
                                </tr>

                            </tfoot>

                        </table>
                    </div>

                </div>
            </div>

        </div>


        {{-- ================= RIGHT CONTENT ================= --}}
        <div class="col-lg-4">

            {{-- TIMELINE --}}
            <div class="modern-card mb-4">

                <div class="modern-card-header">
                    <div class="section-icon orange">
                        <i class="bi bi-clock-history"></i>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">Status Pesanan</h5>
                        <small class="text-muted">
                            Perjalanan pesanan laundry
                        </small>
                    </div>
                </div>

                <div class="modern-card-body">

                    <div class="timeline">

                        {{-- PESANAN --}}
                        <div class="timeline-item completed">

                            <div class="timeline-dot">
                                <i class="bi bi-check"></i>
                            </div>

                            <div class="timeline-content">
                                <h6>Pesanan Dibuat</h6>

                                <small>
                                    {{ $transaksi->created_at->format('d F Y, H:i') }}
                                </small>
                            </div>

                        </div>


                        {{-- DIJEMPUT --}}
                        <div class="timeline-item
                            {{ $transaksi->status_transaksi === 'dijemput_kurir'
                                ? 'active'
                                : (in_array($transaksi->status_transaksi, ['proses_cuci', 'siap_antar', 'selesai'])
                                    ? 'completed'
                                    : '') }}">

                            <div class="timeline-dot">
                                @if(in_array($transaksi->status_transaksi, ['dijemput_kurir', 'proses_cuci', 'siap_antar', 'selesai']))
                                    <i class="bi bi-truck"></i>
                                @else
                                    <i class="bi bi-truck"></i>
                                @endif
                            </div>

                            <div class="timeline-content">
                                <h6>Dijemput Kurir</h6>

                                @if($transaksi->tanggal_jemput)
                                    <small>
                                        {{ $transaksi->tanggal_jemput->format('d F Y, H:i') }}
                                    </small>
                                @else
                                    <small class="text-muted">
                                        Menunggu penjemputan
                                    </small>
                                @endif
                            </div>

                        </div>


                        {{-- PROSES CUCI --}}
                        <div class="timeline-item
                            {{ $transaksi->status_transaksi === 'proses_cuci'
                                ? 'active'
                                : (in_array($transaksi->status_transaksi, ['siap_antar', 'selesai'])
                                    ? 'completed'
                                    : '') }}">

                            <div class="timeline-dot">
                                <i class="bi bi-droplet"></i>
                            </div>

                            <div class="timeline-content">

                                <h6>Proses Cuci</h6>

                                @if($transaksi->tanggal_proses_cuci)
                                    <small class="d-block">
                                        {{ $transaksi->tanggal_proses_cuci->format('d F Y, H:i') }}
                                    </small>
                                @else
                                    <small class="text-muted">
                                        Menunggu proses cuci
                                    </small>
                                @endif

                                @if($transaksi->berat_aktual)
                                    @php
                                        $paket = $transaksi->detailTransaksis->first()->paket;
                                        $labelText = $paket->satuan === 'kg' ? 'Berat' : 'Jumlah';
                                    @endphp

                                    <div class="mt-2">
                                        <span class="measurement-badge">
                                            <i class="bi bi-speedometer2 me-1"></i>
                                            {{ $labelText }}:
                                            {{ $transaksi->berat_aktual }}
                                            {{ $paket->satuan }}
                                        </span>
                                    </div>
                                @endif

                            </div>

                        </div>


                        {{-- SIAP ANTAR --}}
                        <div class="timeline-item
                            {{ $transaksi->status_transaksi === 'siap_antar'
                                ? 'active'
                                : ($transaksi->status_transaksi === 'selesai'
                                    ? 'completed'
                                    : '') }}">

                            <div class="timeline-dot">
                                <i class="bi bi-box-arrow-up"></i>
                            </div>

                            <div class="timeline-content">

                                <h6>Siap Diantar</h6>

                                @if($transaksi->tanggal_siap_antar)
                                    <small>
                                        {{ $transaksi->tanggal_siap_antar->format('d F Y, H:i') }}
                                    </small>
                                @else
                                    <small class="text-muted">
                                        Menunggu siap antar
                                    </small>
                                @endif

                            </div>

                        </div>


                        {{-- SELESAI --}}
                        <div class="timeline-item
                            {{ $transaksi->status_transaksi === 'selesai'
                                ? 'completed'
                                : '' }}">

                            <div class="timeline-dot">
                                <i class="bi bi-check-circle"></i>
                            </div>

                            <div class="timeline-content">

                                <h6>Selesai</h6>

                                @if($transaksi->tanggal_selesai)
                                    <small>
                                        {{ $transaksi->tanggal_selesai->format('d F Y, H:i') }}
                                    </small>
                                @else
                                    <small class="text-muted">
                                        Belum selesai
                                    </small>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>
            </div>


            {{-- AKSI KURIR --}}
            <div class="modern-card">

                <div class="modern-card-header">
                    <div class="section-icon purple">
                        <i class="bi bi-tools"></i>
                    </div>

                    <div>
                        <h5 class="mb-0 fw-bold">Aksi Kurir</h5>
                        <small class="text-muted">
                            Tindakan yang dapat dilakukan
                        </small>
                    </div>
                </div>

                <div class="modern-card-body">

                    @if($transaksi->status_transaksi === 'siap_antar')

                        <div class="action-status success">
                            <div class="action-status-icon">
                                <i class="bi bi-box-arrow-up"></i>
                            </div>

                            <div>
                                <strong>Siap untuk Diantar</strong>
                                <small>Pesanan siap dikirim ke pelanggan</small>
                            </div>
                        </div>

                        <form method="POST"
                              action="{{ route('kurir.transaksi.status', $transaksi) }}"
                              class="mt-3">

                            @csrf
                            @method('PATCH')

                            <input type="hidden"
                                   name="status_transaksi"
                                   value="selesai">

                            <button type="submit"
                                    class="btn btn-success btn-action w-100"
                                    onclick="return confirm('Konfirmasi pengantaran selesai?')">

                                <i class="bi bi-check-circle me-2"></i>
                                Selesaikan Pengantaran

                            </button>

                        </form>

                    @elseif($transaksi->status_transaksi === 'selesai')

                        <div class="action-status completed">
                            <div class="action-status-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>

                            <div>
                                <strong>Pengantaran Selesai</strong>
                                <small>Pesanan telah selesai diantar</small>
                            </div>
                        </div>

                    @elseif($transaksi->status_transaksi === 'dijemput_kurir')

                        <div class="action-status warning">
                            <div class="action-status-icon">
                                <i class="bi bi-clock"></i>
                            </div>

                            <div>
                                <strong>Menunggu Proses Cuci</strong>
                                <small>Pesanan sudah dijemput kurir</small>
                            </div>
                        </div>

                    @else

                        <div class="action-status primary">
                            <div class="action-status-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>

                            <div>
                                <strong>Pesanan Dalam Proses</strong>
                                <small>Belum ada tindakan yang diperlukan</small>
                            </div>
                        </div>

                    @endif


                    {{-- WHATSAPP --}}
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

                    @if($cleanPhone)
                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($message) }}"
                           target="_blank"
                           class="btn btn-whatsapp w-100 mt-3">

                            <i class="bi bi-whatsapp me-2"></i>
                            Hubungi Pelanggan via WhatsApp

                        </a>
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

.modern-card {
    background: #fff;
    border: 1px solid #eef2f7;
    border-radius: 18px;
    box-shadow: 0 5px 20px rgba(15, 23, 42, 0.06);
    overflow: hidden;
}

.modern-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 1.15rem 1.35rem;
    border-bottom: 1px solid #eef2f7;
    background: #fff;
}

.modern-card-body {
    padding: 1.35rem;
}


/* =========================================================
   HEADER
========================================================= */

.task-header {
    padding: 1.5rem 1.75rem;
    border-radius: 18px;
    color: #fff;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.20);
}

.header-icon {
    width: 58px;
    height: 58px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    background: rgba(255,255,255,0.16);
    font-size: 1.55rem;
}

.task-header h2 {
    font-size: 1.6rem;
}

.header-meta {
    font-size: 0.9rem;
    opacity: 0.9;
}

.header-back-btn {
    border: none;
    border-radius: 10px;
    padding: 0.65rem 1rem;
    font-weight: 600;
}


/* =========================================================
   SECTION ICON
========================================================= */

.section-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.1rem;
}

.section-icon.blue {
    background: #eff6ff;
    color: #2563eb;
}

.section-icon.green {
    background: #ecfdf5;
    color: #059669;
}

.section-icon.orange {
    background: #fff7ed;
    color: #ea580c;
}

.section-icon.purple {
    background: #f5f3ff;
    color: #7c3aed;
}


/* =========================================================
   INFO BOX
========================================================= */

.info-box {
    height: 100%;
    padding: 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: #f8fafc;
}

.info-label {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #64748b;
    font-size: 0.78rem;
    font-weight: 600;
    margin-bottom: 0.4rem;
}

.info-label i {
    color: #3b82f6;
}

.info-value {
    font-weight: 600;
    color: #1e293b;
    word-break: break-word;
}

.phone-link {
    color: #16a34a;
    text-decoration: none;
    font-weight: 600;
}

.phone-link:hover {
    text-decoration: underline;
}


/* =========================================================
   ADDRESS
========================================================= */

.address-box {
    padding: 1.15rem;
    border-radius: 14px;
    background: #eff6ff;
    border: 1px solid #dbeafe;
}

.address-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #dbeafe;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.address-text {
    color: #334155;
    line-height: 1.6;
}


/* =========================================================
   NOTE
========================================================= */

.note-box {
    padding: 1rem 1.15rem;
    border-radius: 12px;
    background: #fffbeb;
    border: 1px solid #fde68a;
}

.note-title {
    color: #92400e;
    font-weight: 700;
    margin-bottom: 0.35rem;
}

.note-text {
    color: #78350f;
    line-height: 1.5;
}


/* =========================================================
   PACKAGE TABLE
========================================================= */

.package-table {
    margin-bottom: 0;
}

.package-table thead th {
    background: #f8fafc;
    color: #64748b;
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    padding: 0.9rem 0.75rem;
}

.package-table tbody td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid #f1f5f9;
}

.package-name {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.package-mini-icon {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eff6ff;
    color: #2563eb;
}

.quantity-badge {
    display: inline-block;
    background: #f1f5f9;
    color: #475569;
    padding: 0.35rem 0.6rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
}

.package-table tfoot td {
    padding: 0.8rem 0.75rem;
}

.total-row td {
    background: #ecfdf5 !important;
    color: #047857;
    font-size: 1rem;
    font-weight: 700;
    border-top: 1px solid #bbf7d0;
}


/* =========================================================
   TIMELINE
========================================================= */

.timeline {
    position: relative;
    padding-left: 34px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 14px;
    top: 8px;
    bottom: 8px;
    width: 2px;
    background: #e2e8f0;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-dot {
    position: absolute;
    left: -34px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #fff;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
    z-index: 2;
    font-size: 0.75rem;
}

.timeline-content {
    padding: 0.8rem 0.9rem;
    border-radius: 11px;
    background: #f8fafc;
    border: 1px solid #eef2f7;
}

.timeline-content h6 {
    margin-bottom: 0.25rem;
    font-weight: 700;
    color: #334155;
}

.timeline-content small {
    color: #64748b;
}

.timeline-item.active .timeline-dot {
    background: #f59e0b;
    color: #fff;
}

.timeline-item.active .timeline-content {
    background: #fffbeb;
    border-color: #fde68a;
}

.timeline-item.completed .timeline-dot {
    background: #10b981;
    color: #fff;
}

.timeline-item.completed .timeline-content {
    background: #f0fdf4;
    border-color: #bbf7d0;
}


/* =========================================================
   MEASUREMENT
========================================================= */

.measurement-badge {
    display: inline-flex;
    align-items: center;
    background: #e0f2fe;
    color: #0369a1;
    padding: 0.35rem 0.65rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
}


/* =========================================================
   ACTION STATUS
========================================================= */

.action-status {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 1rem;
    border-radius: 12px;
    border: 1px solid;
}

.action-status-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.action-status strong {
    display: block;
    margin-bottom: 2px;
}

.action-status small {
    display: block;
    color: #64748b;
}

.action-status.success {
    background: #f0fdf4;
    border-color: #bbf7d0;
    color: #166534;
}

.action-status.success .action-status-icon {
    background: #dcfce7;
    color: #16a34a;
}

.action-status.completed {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #334155;
}

.action-status.completed .action-status-icon {
    background: #e2e8f0;
    color: #475569;
}

.action-status.warning {
    background: #fffbeb;
    border-color: #fde68a;
    color: #92400e;
}

.action-status.warning .action-status-icon {
    background: #fef3c7;
    color: #d97706;
}

.action-status.primary {
    background: #eff6ff;
    border-color: #bfdbfe;
    color: #1e40af;
}

.action-status.primary .action-status-icon {
    background: #dbeafe;
    color: #2563eb;
}


/* =========================================================
   BUTTONS
========================================================= */

.btn-action {
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-weight: 600;
}

.btn-whatsapp {
    background: #16a34a;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-weight: 600;
}

.btn-whatsapp:hover {
    background: #15803d;
    color: #fff;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 991px) {

    .task-header {
        padding: 1.35rem;
    }

    .modern-card-body {
        padding: 1.15rem;
    }

}

@media (max-width: 768px) {

    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .task-header {
        border-radius: 14px;
    }

    .header-icon {
        width: 48px;
        height: 48px;
        font-size: 1.25rem;
    }

    .task-header h2 {
        font-size: 1.3rem;
    }

    .header-meta {
        font-size: 0.78rem;
    }

    .header-back-btn {
        width: 100%;
        margin-top: 0.5rem;
    }

    .modern-card {
        border-radius: 14px;
    }

    .modern-card-header {
        padding: 1rem;
    }

    .modern-card-body {
        padding: 1rem;
    }

    .section-icon {
        width: 38px;
        height: 38px;
    }

    .package-table {
        min-width: 600px;
    }

}

@media (max-width: 576px) {

    .container-fluid {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .task-header {
        padding: 1rem;
    }

    .task-header .d-flex {
        align-items: flex-start !important;
    }

    .header-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
    }

    .task-header h2 {
        font-size: 1.15rem;
    }

    .header-meta {
        font-size: 0.72rem;
    }

    .header-meta .mx-2 {
        margin-left: 0.25rem !important;
        margin-right: 0.25rem !important;
    }

    .info-box {
        padding: 0.85rem;
    }

    .address-box {
        padding: 0.9rem;
    }

    .address-icon {
        width: 36px;
        height: 36px;
    }

    .timeline {
        padding-left: 30px;
    }

    .timeline::before {
        left: 12px;
    }

    .timeline-dot {
        left: -30px;
        width: 26px;
        height: 26px;
    }

    .action-status {
        align-items: flex-start;
    }

}

</style>

@endsection