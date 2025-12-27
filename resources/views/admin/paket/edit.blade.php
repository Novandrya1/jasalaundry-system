@extends('layouts.app')

@section('title', 'Edit Paket')

@section('content')
<style>
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
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
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.input-group-text {
    background: #667eea;
    color: white;
    border: 1px solid #667eea;
    border-radius: 8px 0 0 8px;
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
                <i class="bi bi-pencil-square me-3"></i>
                Edit Paket Laundry
            </h1>
            <p class="mb-0 opacity-90">Perbarui informasi paket laundry</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.paket.index') }}" class="btn btn-light btn-lg">
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
                        <i class="bi bi-box me-2"></i>
                        Informasi Paket
                    </h5>
                </div>
                
                <form method="POST" action="{{ route('admin.paket.update', $paket) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="nama_paket" class="form-label fw-medium">
                            <i class="bi bi-tag me-1"></i> Nama Paket
                        </label>
                        <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" 
                               id="nama_paket" name="nama_paket" value="{{ old('nama_paket', $paket->nama_paket) }}" 
                               placeholder="Contoh: Cuci Kering, Cuci Setrika" required>
                        @error('nama_paket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="harga_per_kg" class="form-label fw-medium">
                                    <i class="bi bi-currency-dollar me-1"></i> Harga
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">Rp</span>
                                    <input type="number" class="form-control @error('harga_per_kg') is-invalid @enderror" 
                                           id="harga_per_kg" name="harga_per_kg" value="{{ old('harga_per_kg', $paket->harga_per_kg) }}" 
                                           placeholder="5000" min="0" step="100" required>
                                    @error('harga_per_kg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Masukkan harga dalam rupiah</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="satuan" class="form-label fw-medium">
                                    <i class="bi bi-rulers me-1"></i> Satuan
                                </label>
                                <select class="form-select @error('satuan') is-invalid @enderror" 
                                        id="satuan" name="satuan" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    <option value="kg" {{ old('satuan', $paket->satuan) == 'kg' ? 'selected' : '' }}>
                                        📏 Kilogram (kg)
                                    </option>
                                    <option value="pcs" {{ old('satuan', $paket->satuan) == 'pcs' ? 'selected' : '' }}>
                                        📦 Pieces (pcs)
                                    </option>
                                </select>
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-medium">
                            <i class="bi bi-card-text me-1"></i> Deskripsi
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4" 
                                  placeholder="Jelaskan detail layanan paket ini...">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Berikan deskripsi yang jelas tentang layanan paket ini</small>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active', $paket->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">
                                <i class="bi bi-check-circle me-1"></i>
                                Paket Aktif (dapat dipilih pelanggan)
                            </label>
                        </div>
                        <small class="text-muted ms-4">Centang jika paket ini tersedia untuk pelanggan</small>
                    </div>

                    <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                        <a href="{{ route('admin.paket.index') }}" class="btn btn-outline-secondary btn-action">
                            <i class="bi bi-x-circle me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-action">
                            <i class="bi bi-check-circle me-2"></i>
                            Update Paket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection