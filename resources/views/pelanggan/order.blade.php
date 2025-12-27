@extends('layouts.app')

@section('title', 'Pesan Laundry')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="row">
        <!-- Left Sidebar - Order Summary -->
        <div class="col-lg-4 col-xl-3 mb-4 order-2 order-lg-1">
            <div class="sticky-top" style="top: 100px;">
                <!-- Header -->
                <div class="text-center mb-3 mb-lg-4">
                    <div class="order-icon mb-2 mb-lg-3">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <h3 class="fw-bold mb-1 mb-lg-2 h4 h-lg-3">Pesan Laundry</h3>
                    <p class="text-muted small">Layanan laundry terpercaya</p>
                </div>

                <!-- Order Summary Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-receipt me-2"></i>Ringkasan Pesanan</h6>
                    </div>
                    <div class="card-body">
                        <div id="order-summary">
                            <div class="summary-item">
                                <span class="text-muted">Paket:</span>
                                <span id="selected-package" class="fw-semibold">Belum dipilih</span>
                            </div>
                            <div class="summary-item">
                                <span class="text-muted">Harga:</span>
                                <span id="selected-price" class="fw-semibold text-primary">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="text-muted">Pembayaran:</span>
                                <span id="selected-payment" class="fw-semibold">Belum dipilih</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="info-card">
                    <div class="info-header">
                        <i class="bi bi-lightbulb"></i>
                        <span>Tips Penting</span>
                    </div>
                    <ul class="info-list">
                        <li>Harga dihitung berdasarkan berat aktual</li>
                        <li>Kurir akan menghubungi sebelum jemput</li>
                        <li>Estimasi 1-2 hari kerja</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Content - Form -->
        <div class="col-lg-8 col-xl-9 order-1 order-lg-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 p-md-4 p-lg-5">
                    <form method="POST" action="{{ route('pelanggan.order.store') }}" id="orderForm">
                        @csrf
                        
                        <!-- Step 1: Pilih Paket -->
                        <div class="form-step mb-5">
                            <div class="step-header">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h5 class="step-title">Pilih Paket Laundry</h5>
                                    <p class="step-desc">Pilih paket yang sesuai kebutuhan</p>
                                </div>
                            </div>
                            
                            <div class="packages-grid">
                                @foreach($pakets as $paket)
                                <div class="package-option" data-package-id="{{ $paket->id }}" 
                                     data-package-name="{{ $paket->nama_paket }}" 
                                     data-package-price="Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}/{{ $paket->satuan }}">
                                    <input type="radio" name="paket_id" value="{{ $paket->id }}" id="paket_{{ $paket->id }}" class="d-none">
                                    <label for="paket_{{ $paket->id }}" class="package-label">
                                        <div class="package-content">
                                            <div class="package-icon">
                                                <i class="bi bi-droplet-half"></i>
                                            </div>
                                            <h6 class="package-name">{{ $paket->nama_paket }}</h6>
                                            <div class="package-price">Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}<span>/{{ $paket->satuan }}</span></div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('paket_id')
                                <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Step 2: Detail -->
                        <div class="form-step mb-5">
                            <div class="step-header">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h5 class="step-title">Detail Pesanan</h5>
                                    <p class="step-desc">Informasi penjemputan dan catatan</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        <textarea class="form-control @error('alamat_jemput') is-invalid @enderror" 
                                                  name="alamat_jemput" rows="3" 
                                                  placeholder="Alamat lengkap untuk penjemputan" required>{{ old('alamat_jemput', auth()->user()->address) }}</textarea>
                                        @error('alamat_jemput')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-chat-text"></i></span>
                                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                                  name="catatan" rows="2" 
                                                  placeholder="Catatan khusus (opsional)">{{ old('catatan') }}</textarea>
                                        @error('catatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-gift"></i></span>
                                        <input type="text" class="form-control @error('kode_promo') is-invalid @enderror" 
                                               name="kode_promo" value="{{ old('kode_promo') }}"
                                               placeholder="Kode promo (opsional)">
                                        @error('kode_promo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Dapatkan dari dashboard</small>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Payment -->
                        <div class="form-step mb-4">
                            <div class="step-header">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h5 class="step-title">Metode Pembayaran</h5>
                                    <p class="step-desc">Pilih cara pembayaran</p>
                                </div>
                            </div>

                            <div class="payment-options">
                                <div class="payment-option" data-payment="tunai">
                                    <input type="radio" name="metode_bayar" value="tunai" id="tunai" 
                                           {{ old('metode_bayar', 'tunai') == 'tunai' ? 'checked' : '' }} class="d-none">
                                    <label for="tunai" class="payment-label">
                                        <div class="payment-icon"><i class="bi bi-cash"></i></div>
                                        <div class="payment-info">
                                            <h6>Bayar Tunai (COD)</h6>
                                            <p>Bayar saat pengantaran</p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="payment-option" data-payment="transfer">
                                    <input type="radio" name="metode_bayar" value="transfer" id="transfer" 
                                           {{ old('metode_bayar') == 'transfer' ? 'checked' : '' }} class="d-none">
                                    <label for="transfer" class="payment-label">
                                        <div class="payment-icon"><i class="bi bi-bank"></i></div>
                                        <div class="payment-info">
                                            <h6>Transfer Bank</h6>
                                            <p>Transfer setelah konfirmasi</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @error('metode_bayar')
                                <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror

                            <!-- Bank Info -->
                            <div id="bank-info" class="bank-info-card" style="display: none;">
                                <h6><i class="bi bi-bank me-2"></i>Informasi Rekening</h6>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="bank-item">
                                            <strong>Bank BCA</strong><br>
                                            <code>1234567890</code><br>
                                            <small>a.n. JasaLaundry</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bank-item">
                                            <strong>Bank Mandiri</strong><br>
                                            <code>0987654321</code><br>
                                            <small>a.n. JasaLaundry</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex flex-column flex-md-row gap-2 gap-md-3">
                            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline-secondary flex-fill order-2 order-md-1">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary flex-fill order-1 order-md-2">
                                <i class="bi bi-check-circle me-2"></i>Konfirmasi Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Layout */
.order-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin: 0 auto;
}

/* Order Summary */
.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #f1f5f9;
}

.summary-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

/* Info Card */
.info-card {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 1px solid #f59e0b;
    border-radius: 12px;
    padding: 1.25rem;
}

.info-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #92400e;
    margin-bottom: 0.75rem;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    color: #78350f;
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
    padding-left: 1rem;
    position: relative;
}

.info-list li:before {
    content: '•';
    color: #f59e0b;
    position: absolute;
    left: 0;
}

/* Form Steps */
.form-step {
    position: relative;
}

.step-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}

.step-number {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-right: 1rem;
    flex-shrink: 0;
}

.step-title {
    margin: 0 0 0.25rem 0;
    font-weight: 600;
    color: #1f2937;
}

.step-desc {
    margin: 0;
    color: #6b7280;
    font-size: 0.9rem;
}

/* Package Grid */
.packages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.package-option {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.package-option:hover {
    border-color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

.package-option.selected {
    border-color: #2563eb;
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
}

.package-label {
    display: block;
    padding: 1.25rem;
    margin: 0;
    cursor: pointer;
    text-align: center;
}

.package-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin: 0 auto 0.75rem;
}

.package-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.package-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2563eb;
}

.package-price span {
    font-size: 0.8rem;
    color: #6b7280;
    font-weight: 400;
}

/* Payment Options */
.payment-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.payment-option {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.payment-option:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
}

.payment-option.selected {
    border-color: #2563eb;
    background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
}

.payment-label {
    display: flex;
    align-items: center;
    padding: 1rem;
    margin: 0;
    cursor: pointer;
}

.payment-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    margin-right: 0.75rem;
}

.payment-info h6 {
    margin: 0 0 0.25rem 0;
    font-weight: 600;
    color: #1f2937;
}

.payment-info p {
    margin: 0;
    color: #6b7280;
    font-size: 0.85rem;
}

/* Bank Info */
.bank-info-card {
    background: #f0f9ff;
    border: 1px solid #0ea5e9;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.bank-item {
    background: white;
    padding: 0.75rem;
    border-radius: 6px;
    border: 1px solid #e0f2fe;
}

.bank-item code {
    background: #f1f5f9;
    color: #2563eb;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-weight: 600;
}

/* Input Groups */
.input-group-text {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #64748b;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
}

/* Error Messages */
.error-msg {
    color: #dc2626;
    font-size: 0.85rem;
    margin-top: 0.5rem;
}

/* Responsive */
@media (max-width: 991px) {
    .sticky-top {
        position: static !important;
    }
    
    .packages-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }
    
    .payment-options {
        grid-template-columns: 1fr;
    }
    
    .step-number {
        width: 30px;
        height: 30px;
        font-size: 0.9rem;
    }
    
    .step-header {
        margin-bottom: 1rem;
    }
}

@media (max-width: 768px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .order-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .packages-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .package-label {
        padding: 1rem;
    }
    
    .package-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .payment-label {
        padding: 0.75rem;
    }
    
    .payment-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        margin-right: 0.5rem;
    }
    
    .step-header {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
    }
    
    .step-number {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .info-card {
        padding: 1rem;
    }
    
    .summary-item {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .packages-grid {
        gap: 0.5rem;
    }
    
    .package-label {
        padding: 0.75rem;
    }
    
    .package-name {
        font-size: 0.9rem;
    }
    
    .package-price {
        font-size: 1rem;
    }
    
    .payment-label {
        padding: 0.5rem;
        flex-direction: column;
        text-align: center;
    }
    
    .payment-icon {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
    
    .step-title {
        font-size: 1.1rem;
    }
    
    .step-desc {
        font-size: 0.8rem;
    }
    
    .info-card {
        padding: 0.75rem;
    }
    
    .info-list li {
        font-size: 0.8rem;
    }
    
    .bank-info-card {
        padding: 0.75rem;
    }
    
    .bank-item {
        padding: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
    }
    
    .btn {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Package selection
    const packageOptions = document.querySelectorAll('.package-option');
    const selectedPackageSpan = document.getElementById('selected-package');
    const selectedPriceSpan = document.getElementById('selected-price');
    
    packageOptions.forEach(option => {
        option.addEventListener('click', function() {
            const packageId = this.dataset.packageId;
            const packageName = this.dataset.packageName;
            const packagePrice = this.dataset.packagePrice;
            const input = this.querySelector('input[type="radio"]');
            
            // Remove selected class from all options
            packageOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selected class and check input
            this.classList.add('selected');
            input.checked = true;
            
            // Update summary
            selectedPackageSpan.textContent = packageName;
            selectedPriceSpan.textContent = packagePrice;
        });
    });
    
    // Payment method selection
    const paymentOptions = document.querySelectorAll('.payment-option');
    const selectedPaymentSpan = document.getElementById('selected-payment');
    const bankInfo = document.getElementById('bank-info');
    
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            const paymentMethod = this.dataset.payment;
            const input = this.querySelector('input[type="radio"]');
            
            // Remove selected class from all options
            paymentOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selected class and check input
            this.classList.add('selected');
            input.checked = true;
            
            // Update summary and show/hide bank info
            if (paymentMethod === 'tunai') {
                selectedPaymentSpan.textContent = 'Bayar Tunai (COD)';
                bankInfo.style.display = 'none';
            } else {
                selectedPaymentSpan.textContent = 'Transfer Bank';
                bankInfo.style.display = 'block';
            }
        });
    });
    
    // Initialize selected states
    const checkedPackage = document.querySelector('input[name="paket_id"]:checked');
    if (checkedPackage) {
        const packageOption = checkedPackage.closest('.package-option');
        packageOption.classList.add('selected');
        selectedPackageSpan.textContent = packageOption.dataset.packageName;
        selectedPriceSpan.textContent = packageOption.dataset.packagePrice;
    }
    
    const checkedPayment = document.querySelector('input[name="metode_bayar"]:checked');
    if (checkedPayment) {
        const paymentOption = checkedPayment.closest('.payment-option');
        paymentOption.classList.add('selected');
        if (checkedPayment.value === 'tunai') {
            selectedPaymentSpan.textContent = 'Bayar Tunai (COD)';
        } else {
            selectedPaymentSpan.textContent = 'Transfer Bank';
            bankInfo.style.display = 'block';
        }
    }
});
</script>
@endsection