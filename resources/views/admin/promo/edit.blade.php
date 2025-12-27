@extends('layouts.app')

@section('title', 'Edit Promo')

@section('content')
<style>
.page-header {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    border-radius: 20px;
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(250, 112, 154, 0.3);
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
    border-bottom: 1px solid #e2e8f0;
    padding: 1.25rem 1.5rem;
    margin: -1.5rem -1.5rem 1.5rem -1.5rem;
}

.form-control:focus {
    border-color: #fa709a;
    box-shadow: 0 0 0 0.2rem rgba(250, 112, 154, 0.25);
}

.form-select:focus {
    border-color: #fa709a;
    box-shadow: 0 0 0 0.2rem rgba(250, 112, 154, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #f85a8a 0%, #fed130 100%);
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
}
</style>

<!-- Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2 fw-bold"><i class="bi bi-pencil"></i> Edit Promo</h1>
            <p class="mb-0 opacity-90">Perbarui informasi promo yang sudah ada</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.promo.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.promo.update', $promo) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Info -->
                    <div class="form-section">
                        <h6 class="fw-bold mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Dasar</h6>
                    </div>
                    
                    <div class="mb-4">
                        <label for="judul" class="form-label fw-medium">Judul Promo</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" name="judul" value="{{ old('judul', $promo->judul) }}" 
                               placeholder="Masukkan judul promo yang menarik" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-medium">Deskripsi Promo</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4" 
                                  placeholder="Jelaskan detail promo dan syarat ketentuan" required>{{ old('deskripsi', $promo->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Discount Settings -->
                    <div class="form-section">
                        <h6 class="fw-bold mb-0"><i class="bi bi-percent me-2"></i>Pengaturan Diskon</h6>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tipe_diskon" class="form-label fw-medium">Tipe Diskon</label>
                            <select class="form-select @error('tipe_diskon') is-invalid @enderror" 
                                    id="tipe_diskon" name="tipe_diskon" required>
                                <option value="persen" {{ old('tipe_diskon', $promo->tipe_diskon) == 'persen' ? 'selected' : '' }}>Persentase (%)</option>
                                <option value="nominal" {{ old('tipe_diskon', $promo->tipe_diskon) == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                            </select>
                            @error('tipe_diskon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="diskon_persen" class="form-label fw-medium">Diskon Persen (%)</label>
                            <input type="number" class="form-control @error('diskon_persen') is-invalid @enderror" 
                                   id="diskon_persen" name="diskon_persen" value="{{ old('diskon_persen', $promo->diskon_persen) }}" 
                                   min="0" max="100" step="0.01" placeholder="0">
                            @error('diskon_persen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="diskon_nominal" class="form-label fw-medium">Diskon Nominal (Rp)</label>
                            <input type="number" class="form-control @error('diskon_nominal') is-invalid @enderror" 
                                   id="diskon_nominal" name="diskon_nominal" value="{{ old('diskon_nominal', $promo->diskon_nominal) }}" 
                                   min="0" step="100" placeholder="0">
                            @error('diskon_nominal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Period Settings -->
                    <div class="form-section">
                        <h6 class="fw-bold mb-0"><i class="bi bi-calendar-range me-2"></i>Periode Promo</h6>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_mulai" class="form-label fw-medium">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                   id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $promo->tanggal_mulai->format('Y-m-d')) }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_selesai" class="form-label fw-medium">Tanggal Selesai</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                   id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $promo->tanggal_selesai->format('Y-m-d')) }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">
                                Promo Aktif (tampil di dashboard pelanggan)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.promo.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Promo
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
    
    function toggleDiskonFields() {
        if (tipeDiskon.value === 'persen') {
            diskonPersen.disabled = false;
            diskonNominal.disabled = true;
            diskonNominal.value = 0;
        } else {
            diskonPersen.disabled = true;
            diskonPersen.value = 0;
            diskonNominal.disabled = false;
        }
    }
    
    // Initial setup
    toggleDiskonFields();
    
    // Listen for changes
    tipeDiskon.addEventListener('change', toggleDiskonFields);
});
</script>
@endsection