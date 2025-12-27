@extends('layouts.app')

@section('title', 'Proses Transaksi')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="row">
        <!-- Left Sidebar - Transaction Info -->
        <div class="col-lg-4 col-xl-3 mb-4 order-2 order-lg-1">
            <div class="sticky-top" style="top: 100px;">
                <!-- Header -->
                <div class="text-center mb-3">
                    <div class="transaction-icon mb-3">
                        <i class="bi bi-gear"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Proses Transaksi</h4>
                    <p class="text-muted small">{{ $transaksi->kode_invoice }}</p>
                </div>

                <!-- Customer Info Card -->
                <div class="info-card mb-3">
                    <div class="info-header">
                        <i class="bi bi-person-circle"></i>
                        <span>Informasi Pelanggan</span>
                    </div>
                    <div class="info-content">
                        <div class="info-item">
                            <span class="label">Nama:</span>
                            <span class="value">{{ $transaksi->user->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Telepon:</span>
                            <span class="value">{{ $transaksi->user->phone }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Email:</span>
                            <span class="value">{{ $transaksi->user->email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Package Info Card -->
                <div class="info-card mb-3">
                    <div class="info-header">
                        <i class="bi bi-box"></i>
                        <span>Detail Paket</span>
                    </div>
                    <div class="info-content">
                        @foreach($transaksi->detailTransaksis as $detail)
                        <div class="package-item">
                            <div class="package-name">{{ $detail->paket->nama_paket }}</div>
                            <div class="package-price">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}/{{ $detail->paket->satuan }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Price Calculator -->
                <div class="calculator-card">
                    <div class="calculator-header">
                        <i class="bi bi-calculator"></i>
                        <span>Kalkulasi Harga</span>
                    </div>
                    <div class="calculator-content">
                        @php
                            $paket = $transaksi->detailTransaksis->first()->paket;
                            $isKg = $paket->satuan === 'kg';
                            $currentValue = $transaksi->berat_aktual ? $transaksi->berat_aktual . ' ' . $paket->satuan : ($isKg ? 'Belum ditimbang' : 'Belum dihitung');
                        @endphp
                        <div class="calc-item">
                            <span class="calc-label">{{ $isKg ? 'Berat' : 'Jumlah' }}:</span>
                            <span class="calc-value" id="current-weight">{{ $currentValue }}</span>
                        </div>
                        <div class="calc-item">
                            <span class="calc-label">Harga/{{ $paket->satuan }}:</span>
                            <span class="calc-value">Rp {{ number_format($transaksi->detailTransaksis->first()->harga_satuan, 0, ',', '.') }}</span>
                        </div>
                        <div class="calc-total">
                            <span class="calc-label">Total:</span>
                            <span class="calc-value" id="total-price">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content - Form -->
        <div class="col-lg-8 col-xl-9 order-1 order-lg-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 p-md-4">
                    <!-- Address & Notes -->
                    <div class="section-card mb-4">
                        <div class="section-header">
                            <i class="bi bi-geo-alt"></i>
                            <span>Alamat & Catatan</span>
                        </div>
                        <div class="section-content">
                            <div class="address-item">
                                <strong>Alamat Penjemputan:</strong>
                                <p class="mb-2">{{ $transaksi->alamat_jemput }}</p>
                            </div>
                            @if($transaksi->catatan)
                            <div class="notes-item">
                                <strong>Catatan Khusus:</strong>
                                <p class="mb-0">{{ $transaksi->catatan }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('admin.transaksi.update', $transaksi) }}" id="transactionForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Weight & Courier Section -->
                        <div class="section-card mb-4">
                            <div class="section-header">
                                <i class="bi bi-scales"></i>
                                <span>Penimbangan & Kurir</span>
                            </div>
                            <div class="section-content">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        @php
                                            $paket = $transaksi->detailTransaksis->first()->paket;
                                            $isKg = $paket->satuan === 'kg';
                                            $labelText = $isKg ? 'Berat Aktual' : 'Jumlah Aktual';
                                            $placeholderText = $isKg ? '0.0' : '1';
                                            $stepValue = $isKg ? '0.1' : '1';
                                        @endphp
                                        <div class="form-floating">
                                            <input type="number" class="form-control @error('berat_aktual') is-invalid @enderror" 
                                                   id="berat_aktual" name="berat_aktual" 
                                                   value="{{ old('berat_aktual', $transaksi->berat_aktual) }}" 
                                                   step="{{ $stepValue }}" min="0" placeholder="{{ $placeholderText }}">
                                            <label for="berat_aktual">{{ $labelText }} ({{ $paket->satuan }})</label>
                                            @error('berat_aktual')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select @error('kurir_id') is-invalid @enderror" 
                                                    id="kurir_id" name="kurir_id">
                                                <option value="">Pilih Kurir</option>
                                                @foreach($kurirs as $kurir)
                                                    <option value="{{ $kurir->id }}" 
                                                            {{ old('kurir_id', $transaksi->kurir_id) == $kurir->id ? 'selected' : '' }}>
                                                        {{ $kurir->name }} - {{ $kurir->phone }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="kurir_id">Pilih Kurir</label>
                                            @error('kurir_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div class="section-card mb-4">
                            <div class="section-header">
                                <i class="bi bi-arrow-repeat"></i>
                                <span>Status Transaksi & Pembayaran</span>
                            </div>
                            <div class="section-content">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="status-selector">
                                            <label class="form-label fw-semibold">Status Transaksi</label>
                                            <div class="status-options">
                                                <div class="status-option {{ old('status_transaksi', $transaksi->status_transaksi) == 'request_jemput' ? 'selected' : '' }}" data-status="request_jemput">
                                                    <input type="radio" name="status_transaksi" value="request_jemput" 
                                                           {{ old('status_transaksi', $transaksi->status_transaksi) == 'request_jemput' ? 'checked' : '' }} class="d-none">
                                                    <div class="status-icon bg-warning"><i class="bi bi-clock"></i></div>
                                                    <div class="status-text">
                                                        <div class="status-title">Menunggu Penjemputan</div>
                                                        <div class="status-desc">Pesanan baru masuk</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="status-option {{ old('status_transaksi', $transaksi->status_transaksi) == 'dijemput_kurir' ? 'selected' : '' }}" data-status="dijemput_kurir">
                                                    <input type="radio" name="status_transaksi" value="dijemput_kurir" 
                                                           {{ old('status_transaksi', $transaksi->status_transaksi) == 'dijemput_kurir' ? 'checked' : '' }} class="d-none">
                                                    <div class="status-icon bg-info"><i class="bi bi-truck"></i></div>
                                                    <div class="status-text">
                                                        <div class="status-title">Dijemput Kurir</div>
                                                        <div class="status-desc">Dalam perjalanan</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="status-option {{ old('status_transaksi', $transaksi->status_transaksi) == 'proses_cuci' ? 'selected' : '' }}" data-status="proses_cuci">
                                                    <input type="radio" name="status_transaksi" value="proses_cuci" 
                                                           {{ old('status_transaksi', $transaksi->status_transaksi) == 'proses_cuci' ? 'checked' : '' }} class="d-none">
                                                    <div class="status-icon bg-primary"><i class="bi bi-droplet"></i></div>
                                                    <div class="status-text">
                                                        <div class="status-title">Sedang Dicuci</div>
                                                        <div class="status-desc">Proses pencucian</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="status-option {{ old('status_transaksi', $transaksi->status_transaksi) == 'siap_antar' ? 'selected' : '' }}" data-status="siap_antar">
                                                    <input type="radio" name="status_transaksi" value="siap_antar" 
                                                           {{ old('status_transaksi', $transaksi->status_transaksi) == 'siap_antar' ? 'checked' : '' }} class="d-none">
                                                    <div class="status-icon bg-success"><i class="bi bi-check-circle"></i></div>
                                                    <div class="status-text">
                                                        <div class="status-title">Siap Diantar</div>
                                                        <div class="status-desc">Siap untuk pengantaran</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="status-option {{ old('status_transaksi', $transaksi->status_transaksi) == 'selesai' ? 'selected' : '' }}" data-status="selesai">
                                                    <input type="radio" name="status_transaksi" value="selesai" 
                                                           {{ old('status_transaksi', $transaksi->status_transaksi) == 'selesai' ? 'checked' : '' }} class="d-none">
                                                    <div class="status-icon bg-dark"><i class="bi bi-check-all"></i></div>
                                                    <div class="status-text">
                                                        <div class="status-title">Selesai</div>
                                                        <div class="status-desc">Transaksi selesai</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('status_transaksi')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="payment-section">
                                            <label class="form-label fw-semibold">Status Pembayaran</label>
                                            <div class="payment-method-info mb-3">
                                                <div class="method-badge">
                                                    @if($transaksi->metode_bayar === 'transfer')
                                                        <i class="bi bi-bank"></i> Transfer Bank
                                                    @else
                                                        <i class="bi bi-cash"></i> Tunai (COD)
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="payment-options">
                                                <div class="payment-option {{ old('status_bayar', $transaksi->status_bayar) == 'belum_bayar' ? 'selected' : '' }}" data-payment="belum_bayar">
                                                    <input type="radio" name="status_bayar" value="belum_bayar" 
                                                           {{ old('status_bayar', $transaksi->status_bayar) == 'belum_bayar' ? 'checked' : '' }} class="d-none">
                                                    <div class="payment-icon bg-warning"><i class="bi bi-clock"></i></div>
                                                    <div class="payment-text">Belum Bayar</div>
                                                </div>
                                                
                                                <div class="payment-option {{ old('status_bayar', $transaksi->status_bayar) == 'lunas' ? 'selected' : '' }}" data-payment="lunas">
                                                    <input type="radio" name="status_bayar" value="lunas" 
                                                           {{ old('status_bayar', $transaksi->status_bayar) == 'lunas' ? 'checked' : '' }} class="d-none">
                                                    <div class="payment-icon bg-success"><i class="bi bi-check-circle"></i></div>
                                                    <div class="payment-text">Lunas</div>
                                                </div>
                                            </div>
                                            @error('status_bayar')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-md-row gap-2 gap-md-3">
                            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary flex-fill order-3 order-md-1">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            @if($transaksi->metode_bayar === 'transfer')
                                <a href="{{ \App\Services\WhatsAppService::sendNotification($transaksi->user->phone, \App\Services\WhatsAppService::getPaymentMessage($transaksi)) }}" 
                                   target="_blank" class="btn btn-success flex-fill order-2">
                                    <i class="bi bi-whatsapp me-2"></i>Kirim Info Pembayaran
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary flex-fill order-1 order-md-3">
                                <i class="bi bi-check-circle me-2"></i>Update Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Transaction Icon */
.transaction-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin: 0 auto;
}

/* Info Cards */
.info-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
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

.info-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #f3f4f6;
}

.info-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.info-item .label {
    color: #6b7280;
    font-size: 0.9rem;
}

.info-item .value {
    font-weight: 500;
    color: #111827;
    text-align: right;
}

/* Package Items */
.package-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.package-item:last-child {
    border-bottom: none;
}

.package-name {
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.25rem;
}

.package-price {
    color: #2563eb;
    font-weight: 500;
    font-size: 0.9rem;
}

/* Calculator Card */
.calculator-card {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-radius: 12px;
    color: white;
    overflow: hidden;
}

.calculator-header {
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    background: rgba(255, 255, 255, 0.1);
}

.calculator-content {
    padding: 1rem;
}

.calc-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.calc-total {
    display: flex;
    justify-content: space-between;
    padding-top: 0.75rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    font-weight: 600;
    font-size: 1.1rem;
}

.calc-label {
    opacity: 0.9;
}

.calc-value {
    font-weight: 600;
}

/* Section Cards */
.section-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
}

.section-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.section-content {
    padding: 1.25rem;
}

/* Address & Notes */
.address-item, .notes-item {
    margin-bottom: 1rem;
}

.address-item:last-child, .notes-item:last-child {
    margin-bottom: 0;
}

/* Status Selector */
.status-options {
    display: grid;
    gap: 0.75rem;
}

.status-option {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.status-option:hover {
    border-color: #3b82f6;
    background: #f8fafc;
}

.status-option.selected {
    border-color: #2563eb;
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
}

.status-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.status-title {
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.25rem;
}

.status-desc {
    color: #6b7280;
    font-size: 0.85rem;
}

/* Payment Section */
.method-badge {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    font-weight: 500;
    color: #374151;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.payment-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}

.payment-option {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.payment-option:hover {
    border-color: #3b82f6;
    background: #f8fafc;
}

.payment-option.selected {
    border-color: #2563eb;
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
}

.payment-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin: 0 auto 0.5rem;
}

.payment-text {
    font-weight: 600;
    color: #111827;
}

/* Form Controls */
.form-floating > .form-control:focus,
.form-floating > .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
}

/* Responsive */
@media (max-width: 991px) {
    .sticky-top {
        position: static !important;
    }
    
    .status-options {
        grid-template-columns: 1fr;
    }
    
    .payment-options {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .transaction-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .status-option {
        padding: 0.75rem;
    }
    
    .status-icon {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
    
    .section-content {
        padding: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status option selection
    const statusOptions = document.querySelectorAll('.status-option');
    statusOptions.forEach(option => {
        option.addEventListener('click', function() {
            const status = this.dataset.status;
            const input = this.querySelector('input[type="radio"]');
            
            statusOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            input.checked = true;
        });
    });
    
    // Payment option selection
    const paymentOptions = document.querySelectorAll('.payment-option');
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            const payment = this.dataset.payment;
            const input = this.querySelector('input[type="radio"]');
            
            paymentOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            input.checked = true;
        });
    });
    
    // Real-time price calculation
    const beratInput = document.getElementById('berat_aktual');
    const hargaSatuan = {{ $transaksi->detailTransaksis->first()->harga_satuan }};
    const satuan = '{{ $transaksi->detailTransaksis->first()->paket->satuan }}';
    const isKg = satuan === 'kg';
    
    beratInput.addEventListener('input', function() {
        const jumlah = parseFloat(this.value) || 0;
        const total = jumlah * hargaSatuan;
        
        // Update display
        const currentWeightSpan = document.getElementById('current-weight');
        const totalPriceSpan = document.getElementById('total-price');
        
        if (jumlah > 0) {
            currentWeightSpan.textContent = jumlah + ' ' + satuan;
            totalPriceSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
        } else {
            currentWeightSpan.textContent = isKg ? 'Belum ditimbang' : 'Belum dihitung';
            totalPriceSpan.textContent = 'Rp 0';
        }
    });
});
</script>
@endsection