@extends('layouts.app')

@section('title', 'Edit Kurir')

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
                Edit Data Kurir
            </h1>
            <p class="mb-0 opacity-90">Perbarui informasi kurir {{ $kurir->name }}</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.kurir.index') }}" class="btn btn-light btn-lg">
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
                        <i class="bi bi-person-gear me-2"></i>
                        Informasi Kurir
                    </h5>
                </div>
                
                <form method="POST" action="{{ route('admin.kurir.update', $kurir) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="name" class="form-label fw-medium">
                                    <i class="bi bi-person me-1"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $kurir->name) }}" 
                                       placeholder="Masukkan nama lengkap kurir" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="email" class="form-label fw-medium">
                                    <i class="bi bi-envelope me-1"></i> Email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $kurir->email) }}" 
                                       placeholder="kurir@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Email akan digunakan untuk login</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="password" class="form-label fw-medium">
                                    <i class="bi bi-lock me-1"></i> Password Baru
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" 
                                       placeholder="Kosongkan jika tidak diubah">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimal 8 karakter (kosongkan jika tidak diubah)</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-medium">
                                    <i class="bi bi-lock-fill me-1"></i> Konfirmasi Password
                                </label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="form-label fw-medium">
                            <i class="bi bi-telephone me-1"></i> Nomor Telepon
                        </label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $kurir->phone) }}" 
                               placeholder="081234567890" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: 08xxxxxxxxxx (tanpa spasi atau tanda hubung)</small>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label fw-medium">
                            <i class="bi bi-geo-alt me-1"></i> Alamat Lengkap
                        </label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="4" 
                                  placeholder="Masukkan alamat lengkap kurir..." required>{{ old('address', $kurir->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Alamat akan digunakan untuk koordinasi pengiriman</small>
                    </div>

                    <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                        <a href="{{ route('admin.kurir.index') }}" class="btn btn-outline-secondary btn-action">
                            <i class="bi bi-x-circle me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-action">
                            <i class="bi bi-check-circle me-2"></i>
                            Update Kurir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection