@extends('layouts.app')

@section('title', 'Tambah Promo')

@section('content')
<style>
.page-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 20px;
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
}

.form-card {
    border: none;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.form-section {
    background: #f8fafc;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    margin: -1.5rem -1.5rem 1.5rem -1.5rem;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #f093fb;
    box-shadow: 0 0 0 0.2rem rgba(240, 147, 251, 0.25);
}

.btn-action {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-action:hover {
    transform: translateY(-2px);
}

.discount-preview {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    margin-bottom: 1.5rem;
}

.info-alert {
    background: linear-gradient(135deg, #fce7f3 0%, #fdf2f8 100%);
    border: 1px solid #f093fb;
    border-radius: 12px;
    padding: 1.5rem;
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .form-card {
        margin: 0 -0.5rem;
    }
}
</style>

<!-- Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2 fw-bold">
                <i class="bi bi-gift me-3"></i>
                Tambah Promo Baru
            </h1>
            <p class="mb-0 opacity-90">Buat promo menarik untuk meningkatkan penjualan laundry</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.promo.index') }}" class="btn btn-light btn-lg">
                <i class="bi bi-arrow-left me-2"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="card-body p-4">
                <div class="form-section">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-tag me-2"></i>
                        Informasi Promo
                    </h5>
                </div>
                
                <form method="POST" action="{{ route('admin.promo.store') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="judul" class="form-label fw-medium">
                            <i class="bi bi-card-heading me-1"></i> Judul Promo
                        </label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" name="judul" value="{{ old('judul') }}" 
                               placeholder="Contoh: Diskon 20% Pelanggan Baru" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-medium">
                            <i class="bi bi-card-text me-1"></i> Deskripsi Promo
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4" 
                                  placeholder="Jelaskan detail promo, syarat dan ketentuan..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Berikan deskripsi yang jelas tentang promo ini</small>
                    </div>

                    <!-- Discount Preview -->
                    <div class="discount-preview" id="discountPreview" style="display: none;">
                        <h4 class="mb-2">Preview Diskon</h4>
                        <div class="display-6 fw-bold" id="previewValue">0%</div>
                        <div class="opacity-90" id="previewType">Diskon Persentase</div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="tipe_diskon" class="form-label fw-medium">
                                    <i class="bi bi-percent me-1"></i> Tipe Diskon
                                </label>
                                <select class="form-select @error('tipe_diskon') is-invalid @enderror" 
                                        id="tipe_diskon" name="tipe_diskon" required>
                                    <option value="persen" {{ old('tipe_diskon') == 'persen' ? 'selected' : '' }}>
                                        📊 Persentase (%)
                                    </option>
                                    <option value="nominal" {{ old('tipe_diskon') == 'nominal' ? 'selected' : '' }}>
                                        💰 Nominal (Rp)
                                    </option>
                                </select>
                                @error('tipe_diskon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="diskon_persen" class="form-label fw-medium">
                                    <i class="bi bi-percent me-1"></i> Diskon Persen (%)
                                </label>
                                <input type="number" class="form-control @error('diskon_persen') is-invalid @enderror" 
                                       id="diskon_persen" name="diskon_persen" value="{{ old('diskon_persen', 0) }}" 
                                       min="0" max="100" step="0.01" placeholder="0">
                                @error('diskon_persen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Maksimal 100%</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="diskon_nominal" class="form-label fw-medium">
                                    <i class="bi bi-currency-dollar me-1"></i> Diskon Nominal (Rp)
                                </label>
                                <input type="number" class="form-control @error('diskon_nominal') is-invalid @enderror" 
                                       id="diskon_nominal" name="diskon_nominal" value="{{ old('diskon_nominal', 0) }}" 
                                       min="0" step="1000" placeholder="0">
                                @error('diskon_nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Dalam rupiah</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="tanggal_mulai" class="form-label fw-medium">
                                    <i class="bi bi-calendar-plus me-1"></i> Tanggal Mulai
                                </label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                       id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="tanggal_selesai" class="form-label fw-medium">
                                    <i class="bi bi-calendar-x me-1"></i> Tanggal Selesai
                                </label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                       id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">
                                <i class="bi bi-eye me-1"></i>
                                Promo Aktif (tampil di dashboard pelanggan)
                            </label>
                        </div>
                        <small class="text-muted ms-4">Centang jika promo ini tersedia untuk pelanggan</small>
                    </div>

                    <div class="info-alert mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-info-circle me-2"></i>
                            Tips Membuat Promo
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-lightbulb text-primary me-2 mt-1"></i>
                                    <small>Buat judul yang menarik dan mudah dipahami</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-calendar-check text-primary me-2 mt-1"></i>
                                    <small>Tentukan periode promo yang tepat</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-percent text-primary me-2 mt-1"></i>
                                    <small>Sesuaikan nilai diskon dengan target penjualan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                        <a href="{{ route('admin.promo.index') }}" class="btn btn-outline-secondary btn-action">
                            <i class="bi bi-x-circle me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-action">
                            <i class="bi bi-check-circle me-2"></i>
                            Simpan Promo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipeDiskon = document.getElementById('tipe_diskon');
    const diskonPersen = document.getElementById('diskon_persen');
    const diskonNominal = document.getElementById('diskon_nominal');
    const discountPreview = document.getElementById('discountPreview');
    const previewValue = document.getElementById('previewValue');
    const previewType = document.getElementById('previewType');
    
    function toggleDiskonFields() {
        if (tipeDiskon.value === 'persen') {
            diskonPersen.disabled = false;
            diskonNominal.disabled = true;
            diskonNominal.value = 0;
            previewType.textContent = 'Diskon Persentase';
        } else {
            diskonPersen.disabled = true;
            diskonPersen.value = 0;
            diskonNominal.disabled = false;
            previewType.textContent = 'Diskon Nominal';
        }
        updatePreview();
    }
    
    function updatePreview() {
        let value = 0;
        let display = '';
        
        if (tipeDiskon.value === 'persen') {
            value = parseFloat(diskonPersen.value) || 0;
            display = value + '%';
        } else {
            value = parseFloat(diskonNominal.value) || 0;
            display = 'Rp ' + value.toLocaleString('id-ID');
        }
        
        if (value > 0) {
            discountPreview.style.display = 'block';
            previewValue.textContent = display;
        } else {
            discountPreview.style.display = 'none';
        }
    }
    
    // Initial setup
    toggleDiskonFields();
    
    // Listen for changes
    tipeDiskon.addEventListener('change', toggleDiskonFields);
    diskonPersen.addEventListener('input', updatePreview);
    diskonNominal.addEventListener('input', updatePreview);
});
</script>
@endsection