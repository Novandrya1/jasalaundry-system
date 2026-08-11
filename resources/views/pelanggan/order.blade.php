@extends('layouts.app')

@section('title', 'Pesan Laundry')

@section('content')
<div class="order-page">

    <div class="container-fluid px-3 px-lg-4 py-4 py-lg-5">

        {{-- Page Header --}}
        <div class="page-heading mb-4 mb-lg-5">
            <div class="heading-icon">
                <i class="bi bi-basket3-fill"></i>
            </div>

            <div>
                <span class="heading-label">LAYANAN LAUNDRY</span>
                <h2 class="heading-title">Pesan Laundry</h2>
                <p class="heading-subtitle">
                    Pilih paket dan lengkapi detail pesanan Anda
                </p>
            </div>
        </div>

        <div class="row g-4">

            {{-- =========================
                LEFT : ORDER SUMMARY
            ========================== --}}
            <div class="col-lg-4 col-xl-3 order-2 order-lg-1">

                <div class="summary-wrapper">

                    {{-- Summary Card --}}
                    <div class="summary-card">

                        <div class="summary-header">
                            <div class="summary-header-icon">
                                <i class="bi bi-receipt"></i>
                            </div>

                            <div>
                                <h5>Ringkasan Pesanan</h5>
                                <span>Detail pesanan Anda</span>
                            </div>
                        </div>

                        <div class="summary-body">

                            <div class="summary-row">
                                <div class="summary-label">
                                    <i class="bi bi-box-seam"></i>
                                    <span>Paket</span>
                                </div>

                                <strong id="selected-package">
                                    Belum dipilih
                                </strong>
                            </div>

                            <div class="summary-row">
                                <div class="summary-label">
                                    <i class="bi bi-tag"></i>
                                    <span>Harga</span>
                                </div>

                                <strong id="selected-price" class="price-text">
                                    -
                                </strong>
                            </div>

                            <div class="summary-row">
                                <div class="summary-label">
                                    <i class="bi bi-wallet2"></i>
                                    <span>Pembayaran</span>
                                </div>

                                <strong id="selected-payment">
                                    Belum dipilih
                                </strong>
                            </div>

                        </div>

                        <div class="summary-footer">
                            <i class="bi bi-shield-check"></i>
                            <span>Data pesanan Anda aman</span>
                        </div>

                    </div>


                    {{-- Tips --}}
                    <div class="tips-card">

                        <div class="tips-title">
                            <div class="tips-icon">
                                <i class="bi bi-lightbulb-fill"></i>
                            </div>

                            <span>Tips Penting</span>
                        </div>

                        <ul>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Harga dihitung berdasarkan berat aktual
                            </li>

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Kurir akan menghubungi sebelum menjemput
                            </li>

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Estimasi pengerjaan 1–2 hari kerja
                            </li>
                        </ul>

                    </div>

                </div>

            </div>


            {{-- =========================
                RIGHT : FORM
            ========================== --}}
            <div class="col-lg-8 col-xl-9 order-1 order-lg-2">

                <div class="order-card">

                    <form method="POST"
                          action="{{ route('pelanggan.order.store') }}"
                          id="orderForm">

                        @csrf


                        {{-- =========================
                            STEP 1
                        ========================== --}}
                        <div class="form-section">

                            <div class="section-heading">

                                <div class="step-badge">
                                    1
                                </div>

                                <div>
                                    <h4>Pilih Paket Laundry</h4>
                                    <p>Pilih paket yang sesuai dengan kebutuhan Anda</p>
                                </div>

                            </div>


                            <div class="packages-grid">

                                @foreach($pakets as $paket)

                                    <div class="package-option"
                                         data-package-id="{{ $paket->id }}"
                                         data-package-name="{{ $paket->nama_paket }}"
                                         data-package-price="Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}/{{ $paket->satuan }}">

                                        <input
                                            type="radio"
                                            name="paket_id"
                                            value="{{ $paket->id }}"
                                            id="paket_{{ $paket->id }}"
                                            class="package-radio"
                                            {{ old('paket_id') == $paket->id ? 'checked' : '' }}
                                        >

                                        <label for="paket_{{ $paket->id }}">

                                            <div class="package-top">

                                                <div class="package-icon">
                                                    <i class="bi bi-droplet-fill"></i>
                                                </div>

                                                <div class="package-check">
                                                    <i class="bi bi-check"></i>
                                                </div>

                                            </div>

                                            <div class="package-name">
                                                {{ $paket->nama_paket }}
                                            </div>

                                            <div class="package-price">
                                                Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}
                                                <span>/{{ $paket->satuan }}</span>
                                            </div>

                                            @if($paket->deskripsi)
                                                <div class="package-description">
                                                    {{ $paket->deskripsi }}
                                                </div>
                                            @endif

                                        </label>

                                    </div>

                                @endforeach

                            </div>

                            @error('paket_id')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Divider --}}
                        <div class="section-divider"></div>


                        {{-- =========================
                            STEP 2
                        ========================== --}}
                        <div class="form-section">

                            <div class="section-heading">

                                <div class="step-badge">
                                    2
                                </div>

                                <div>
                                    <h4>Detail Pesanan</h4>
                                    <p>Masukkan informasi penjemputan dan catatan</p>
                                </div>

                            </div>


                            <div class="row g-3">

                                {{-- Address --}}
                                <div class="col-12">

                                    <label class="field-label">
                                        Alamat Penjemputan
                                        <span>*</span>
                                    </label>

                                    <div class="input-box">

                                        <div class="input-icon">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </div>

                                        <textarea
                                            class="form-control @error('alamat_jemput') is-invalid @enderror"
                                            name="alamat_jemput"
                                            rows="3"
                                            placeholder="Masukkan alamat lengkap untuk penjemputan"
                                            required
                                        >{{ old('alamat_jemput', auth()->user()->address) }}</textarea>

                                    </div>

                                    @error('alamat_jemput')
                                        <div class="field-error">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- Catatan --}}
                                <div class="col-md-6">

                                    <label class="field-label">
                                        Catatan
                                        <small>(opsional)</small>
                                    </label>

                                    <div class="input-box">

                                        <div class="input-icon">
                                            <i class="bi bi-chat-left-text-fill"></i>
                                        </div>

                                        <textarea
                                            class="form-control @error('catatan') is-invalid @enderror"
                                            name="catatan"
                                            rows="3"
                                            placeholder="Contoh: pisahkan pakaian putih..."
                                        >{{ old('catatan') }}</textarea>

                                    </div>

                                    @error('catatan')
                                        <div class="field-error">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                {{-- Promo --}}
                                <div class="col-md-6">

                                    <label class="field-label">
                                        Kode Promo
                                        <small>(opsional)</small>
                                    </label>

                                    <div class="input-box">

                                        <div class="input-icon">
                                            <i class="bi bi-ticket-perforated-fill"></i>
                                        </div>

                                        <input
                                            type="text"
                                            class="form-control @error('kode_promo') is-invalid @enderror"
                                            name="kode_promo"
                                            value="{{ old('kode_promo') }}"
                                            placeholder="Masukkan kode promo"
                                        >

                                    </div>

                                    <div class="field-hint">
                                        <i class="bi bi-info-circle"></i>
                                        Kode promo dapat diperoleh dari dashboard
                                    </div>

                                    @error('kode_promo')
                                        <div class="field-error">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                        </div>


                        {{-- Divider --}}
                        <div class="section-divider"></div>


                        {{-- =========================
                            STEP 3
                        ========================== --}}
                        <div class="form-section">

                            <div class="section-heading">

                                <div class="step-badge">
                                    3
                                </div>

                                <div>
                                    <h4>Metode Pembayaran</h4>
                                    <p>Pilih metode pembayaran yang Anda inginkan</p>
                                </div>

                            </div>


                            <div class="payment-options">

                                {{-- Tunai --}}
                                <div class="payment-option"
                                     data-payment="tunai">

                                    <input
                                        type="radio"
                                        name="metode_bayar"
                                        value="tunai"
                                        id="tunai"
                                        class="payment-radio"
                                        {{ old('metode_bayar', 'tunai') == 'tunai' ? 'checked' : '' }}
                                    >

                                    <label for="tunai">

                                        <div class="payment-icon cash">
                                            <i class="bi bi-cash-stack"></i>
                                        </div>

                                        <div class="payment-info">
                                            <strong>Bayar Tunai</strong>
                                            <span>Bayar saat pengantaran</span>
                                        </div>

                                        <div class="payment-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>

                                    </label>

                                </div>


                                {{-- Transfer --}}
                                <div class="payment-option"
                                     data-payment="transfer">

                                    <input
                                        type="radio"
                                        name="metode_bayar"
                                        value="transfer"
                                        id="transfer"
                                        class="payment-radio"
                                        {{ old('metode_bayar') == 'transfer' ? 'checked' : '' }}
                                    >

                                    <label for="transfer">

                                        <div class="payment-icon bank">
                                            <i class="bi bi-bank2"></i>
                                        </div>

                                        <div class="payment-info">
                                            <strong>Transfer Bank</strong>
                                            <span>Transfer setelah konfirmasi</span>
                                        </div>

                                        <div class="payment-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>

                                    </label>

                                </div>

                            </div>


                            @error('metode_bayar')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror


                            {{-- Bank Information --}}
                            <div id="bank-info" class="bank-info-card">

                                <div class="bank-info-header">
                                    <div class="bank-info-icon">
                                        <i class="bi bi-bank"></i>
                                    </div>

                                    <div>
                                        <strong>Informasi Rekening</strong>
                                        <span>Silakan transfer ke salah satu rekening berikut</span>
                                    </div>
                                </div>


                                <div class="row g-3 mt-1">

                                    <div class="col-md-6">

                                        <div class="bank-account">

                                            <div class="bank-name">
                                                <span>Bank BCA</span>
                                                <i class="bi bi-credit-card"></i>
                                            </div>

                                            <div class="account-number">
                                                1234567890
                                            </div>

                                            <small>
                                                a.n. JasaLaundry
                                            </small>

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <div class="bank-account">

                                            <div class="bank-name">
                                                <span>Bank Mandiri</span>
                                                <i class="bi bi-credit-card"></i>
                                            </div>

                                            <div class="account-number">
                                                0987654321
                                            </div>

                                            <small>
                                                a.n. JasaLaundry
                                            </small>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- =========================
                            ACTION
                        ========================== --}}
                        <div class="form-actions">

                            <a href="{{ route('pelanggan.dashboard') }}"
                               class="btn-back">

                                <i class="bi bi-arrow-left"></i>
                                Kembali

                            </a>


                            <button type="submit"
                                    class="btn-submit">

                                <span>Konfirmasi Pesanan</span>

                                <i class="bi bi-arrow-right"></i>

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

/* =====================================================
   PAGE
===================================================== */

.order-page {
    background: #f8fafc;
    min-height: calc(100vh - 70px);
}


/* =====================================================
   HEADER
===================================================== */

.page-heading {
    display: flex;
    align-items: center;
    gap: 16px;
}

.heading-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: white;
    font-size: 24px;
    box-shadow: 0 8px 20px rgba(37, 99, 235, .2);
}

.heading-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    color: #2563eb;
}

.heading-title {
    font-size: 28px;
    font-weight: 750;
    margin: 2px 0 2px;
    color: #111827;
}

.heading-subtitle {
    margin: 0;
    color: #64748b;
    font-size: 14px;
}


/* =====================================================
   MAIN CARD
===================================================== */

.order-card {
    background: white;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 8px 30px rgba(15, 23, 42, .05);
    overflow: hidden;
}

.order-card form {
    padding: 28px;
}


/* =====================================================
   SUMMARY
===================================================== */

.summary-wrapper {
    position: sticky;
    top: 90px;
}

.summary-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
}

.summary-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: white;
}

.summary-header-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(255,255,255,.18);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.summary-header h5 {
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 2px;
}

.summary-header span {
    font-size: 11px;
    opacity: .8;
}

.summary-body {
    padding: 8px 18px;
}

.summary-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 15px 0;
    border-bottom: 1px solid #f1f5f9;
}

.summary-row:last-child {
    border-bottom: none;
}

.summary-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #64748b;
    font-size: 13px;
}

.summary-label i {
    color: #3b82f6;
}

.summary-row strong {
    color: #1e293b;
    font-size: 13px;
    text-align: right;
}

.summary-row .price-text {
    color: #2563eb;
}

.summary-footer {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 12px 18px;
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
}

.summary-footer i {
    color: #16a34a;
}


/* =====================================================
   TIPS
===================================================== */

.tips-card {
    margin-top: 14px;
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 14px;
    padding: 16px;
}

.tips-title {
    display: flex;
    align-items: center;
    gap: 9px;
    color: #92400e;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 12px;
}

.tips-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #fef3c7;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tips-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.tips-card li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    color: #78350f;
    font-size: 11px;
    line-height: 1.5;
    margin-bottom: 8px;
}

.tips-card li:last-child {
    margin-bottom: 0;
}

.tips-card li i {
    color: #f59e0b;
    margin-top: 2px;
}


/* =====================================================
   SECTION
===================================================== */

.form-section {
    padding: 4px 0;
}

.section-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 22px;
}

.step-badge {
    width: 38px;
    height: 38px;
    flex-shrink: 0;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eff6ff;
    color: #2563eb;
    font-weight: 800;
    font-size: 15px;
}

.section-heading h4 {
    margin: 0 0 3px;
    font-size: 17px;
    font-weight: 700;
    color: #1e293b;
}

.section-heading p {
    margin: 0;
    color: #64748b;
    font-size: 12px;
}

.section-divider {
    height: 1px;
    background: #eef2f7;
    margin: 28px 0;
}


/* =====================================================
   PACKAGES
===================================================== */

.packages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 14px;
}

.package-option {
    position: relative;
}

.package-radio,
.payment-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.package-option label {
    display: block;
    position: relative;
    height: 100%;
    padding: 18px;
    background: white;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    cursor: pointer;
    transition: all .2s ease;
}

.package-option label:hover {
    border-color: #93c5fd;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, .08);
}

.package-option.selected label {
    border-color: #2563eb;
    background: #f8fbff;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
}

.package-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}

.package-icon {
    width: 42px;
    height: 42px;
    border-radius: 11px;
    background: #eff6ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
}

.package-check {
    width: 23px;
    height: 23px;
    border-radius: 50%;
    border: 1.5px solid #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
}

.package-option.selected .package-check {
    background: #2563eb;
    border-color: #2563eb;
}

.package-name {
    color: #1e293b;
    font-weight: 700;
    font-size: 14px;
    margin-bottom: 5px;
}

.package-price {
    color: #2563eb;
    font-size: 16px;
    font-weight: 800;
}

.package-price span {
    color: #64748b;
    font-size: 11px;
    font-weight: 500;
}

.package-description {
    margin-top: 12px;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
    color: #64748b;
    font-size: 11px;
    line-height: 1.5;
}


/* =====================================================
   FORM FIELD
===================================================== */

.field-label {
    display: block;
    margin-bottom: 7px;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
}

.field-label span {
    color: #ef4444;
}

.field-label small {
    color: #94a3b8;
    font-weight: 400;
}

.input-box {
    display: flex;
    align-items: stretch;
    border: 1px solid #dbe2ea;
    border-radius: 10px;
    overflow: hidden;
    background: white;
    transition: .2s;
}

.input-box:focus-within {
    border-color: #60a5fa;
    box-shadow: 0 0 0 3px rgba(59,130,246,.08);
}

.input-icon {
    width: 42px;
    flex-shrink: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 12px;
    background: #f8fafc;
    color: #64748b;
}

.input-box .form-control {
    border: none !important;
    box-shadow: none !important;
    font-size: 13px;
    padding: 11px 12px;
}

.field-hint {
    margin-top: 6px;
    color: #94a3b8;
    font-size: 10px;
}

.field-hint i {
    margin-right: 3px;
}

.field-error,
.error-message {
    color: #dc2626;
    font-size: 11px;
    margin-top: 6px;
}


/* =====================================================
   PAYMENT
===================================================== */

.payment-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}

.payment-option label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    cursor: pointer;
    transition: .2s;
}

.payment-option label:hover {
    border-color: #93c5fd;
}

.payment-option.selected label {
    border-color: #2563eb;
    background: #f8fbff;
    box-shadow: 0 0 0 3px rgba(37,99,235,.07);
}

.payment-icon {
    width: 44px;
    height: 44px;
    flex-shrink: 0;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.payment-icon.cash {
    background: #ecfdf5;
    color: #16a34a;
}

.payment-icon.bank {
    background: #eff6ff;
    color: #2563eb;
}

.payment-info {
    display: flex;
    flex-direction: column;
    gap: 3px;
    flex: 1;
}

.payment-info strong {
    font-size: 13px;
    color: #1e293b;
}

.payment-info span {
    font-size: 10px;
    color: #64748b;
}

.payment-check {
    color: #cbd5e1;
    font-size: 18px;
}

.payment-option.selected .payment-check {
    color: #2563eb;
}


/* =====================================================
   BANK
===================================================== */

.bank-info-card {
    display: none;
    margin-top: 14px;
    padding: 16px;
    background: #f8fbff;
    border: 1px solid #bfdbfe;
    border-radius: 14px;
}

.bank-info-header {
    display: flex;
    align-items: center;
    gap: 10px;
}

.bank-info-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    background: #dbeafe;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bank-info-header strong {
    display: block;
    color: #1e293b;
    font-size: 12px;
}

.bank-info-header span {
    display: block;
    color: #64748b;
    font-size: 10px;
    margin-top: 2px;
}

.bank-account {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 11px;
    padding: 13px;
}

.bank-name {
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #334155;
    font-size: 12px;
    font-weight: 700;
}

.bank-name i {
    color: #2563eb;
}

.account-number {
    margin-top: 10px;
    color: #2563eb;
    font-size: 17px;
    font-weight: 800;
    letter-spacing: 1px;
}

.bank-account small {
    color: #64748b;
    font-size: 10px;
}


/* =====================================================
   BUTTON
===================================================== */

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 30px;
    padding-top: 22px;
    border-top: 1px solid #eef2f7;
}

.btn-back,
.btn-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 44px;
    padding: 0 18px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: .2s;
}

.btn-back {
    border: 1px solid #dbe2ea;
    color: #475569;
    background: white;
}

.btn-back:hover {
    background: #f8fafc;
    color: #1e293b;
}

.btn-submit {
    border: none;
    color: white;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    box-shadow: 0 5px 15px rgba(37,99,235,.18);
}

.btn-submit:hover {
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(37,99,235,.25);
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 991px) {

    .summary-wrapper {
        position: static;
    }

    .summary-card {
        margin-top: 0;
    }

    .order-card form {
        padding: 22px;
    }

}


@media (max-width: 767px) {

    .order-page {
        min-height: 100vh;
    }

    .page-heading {
        gap: 12px;
    }

    .heading-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 19px;
    }

    .heading-title {
        font-size: 22px;
    }

    .heading-subtitle {
        font-size: 12px;
    }

    .packages-grid {
        grid-template-columns: 1fr;
    }

    .payment-options {
        grid-template-columns: 1fr;
    }

    .order-card form {
        padding: 18px;
    }

    .section-heading {
        align-items: flex-start;
    }

    .section-heading h4 {
        font-size: 15px;
    }

    .section-heading p {
        font-size: 11px;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .btn-back,
    .btn-submit {
        width: 100%;
    }

}


@media (max-width: 480px) {

    .container-fluid {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    .order-card {
        border-radius: 14px;
    }

    .order-card form {
        padding: 15px;
    }

    .summary-header {
        padding: 15px;
    }

    .summary-body {
        padding: 6px 15px;
    }

    .tips-card {
        padding: 13px;
    }

}

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================
       PACKAGE
    ========================================== */

    const packageOptions =
        document.querySelectorAll('.package-option');

    const selectedPackage =
        document.getElementById('selected-package');

    const selectedPrice =
        document.getElementById('selected-price');


    packageOptions.forEach(option => {

        option.addEventListener('click', function () {

            packageOptions.forEach(item => {
                item.classList.remove('selected');
            });

            this.classList.add('selected');

            const input =
                this.querySelector('input[type="radio"]');

            input.checked = true;

            selectedPackage.textContent =
                this.dataset.packageName;

            selectedPrice.textContent =
                this.dataset.packagePrice;

        });

    });


    /* ==========================================
       PAYMENT
    ========================================== */

    const paymentOptions =
        document.querySelectorAll('.payment-option');

    const selectedPayment =
        document.getElementById('selected-payment');

    const bankInfo =
        document.getElementById('bank-info');


    paymentOptions.forEach(option => {

        option.addEventListener('click', function () {

            paymentOptions.forEach(item => {
                item.classList.remove('selected');
            });

            this.classList.add('selected');

            const input =
                this.querySelector('input[type="radio"]');

            input.checked = true;

            const payment =
                this.dataset.payment;

            if (payment === 'tunai') {

                selectedPayment.textContent =
                    'Bayar Tunai (COD)';

                bankInfo.style.display = 'none';

            } else {

                selectedPayment.textContent =
                    'Transfer Bank';

                bankInfo.style.display = 'block';

            }

        });

    });


    /* ==========================================
       INITIAL PACKAGE
    ========================================== */

    const checkedPackage =
        document.querySelector(
            'input[name="paket_id"]:checked'
        );

    if (checkedPackage) {

        const option =
            checkedPackage.closest('.package-option');

        option.classList.add('selected');

        selectedPackage.textContent =
            option.dataset.packageName;

        selectedPrice.textContent =
            option.dataset.packagePrice;

    }


    /* ==========================================
       INITIAL PAYMENT
    ========================================== */

    const checkedPayment =
        document.querySelector(
            'input[name="metode_bayar"]:checked'
        );

    if (checkedPayment) {

        const option =
            checkedPayment.closest('.payment-option');

        option.classList.add('selected');

        if (checkedPayment.value === 'tunai') {

            selectedPayment.textContent =
                'Bayar Tunai (COD)';

            bankInfo.style.display = 'none';

        } else {

            selectedPayment.textContent =
                'Transfer Bank';

            bankInfo.style.display = 'block';

        }

    }

});

</script>

@endsection