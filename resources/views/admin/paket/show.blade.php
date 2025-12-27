@extends('layouts.app')

@section('title', 'Detail Paket')

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

.detail-card {
    border: none;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.info-card {
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.price-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    margin-bottom: 1.5rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
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

.detail-section {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .price-card {
        padding: 1.5rem;
    }
}
</style>

<!-- Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2 fw-bold">
                <i class="bi bi-eye me-3"></i>
                Detail Paket Laundry
            </h1>
            <p class="mb-0 opacity-90">Informasi lengkap paket {{ $paket->nama_paket }}</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            @if($paket->is_active)
                <span class="status-badge bg-success text-white">
                    <i class="bi bi-check-circle me-1"></i>
                    Paket Aktif
                </span>
            @else
                <span class="status-badge bg-secondary text-white">
                    <i class="bi bi-x-circle me-1"></i>
                    Paket Nonaktif
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Price Card -->
        <div class="price-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2 fw-bold">{{ $paket->nama_paket }}</h2>
                    <p class="mb-0 opacity-90">{{ $paket->deskripsi ?: 'Tidak ada deskripsi tersedia' }}</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="display-6 fw-bold">Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}</div>
                    <div class="opacity-90">per {{ $paket->satuan == 'kg' ? 'kilogram' : 'pieces' }}</div>
                </div>
            </div>
        </div>
        
        <div class="detail-card">
            <div class="card-body p-4">
                <!-- Package Information -->
                <div class="detail-section">
                    <h5 class="mb-3 fw-bold text-dark">
                        <i class="bi bi-info-circle me-2"></i>
                        Informasi Paket
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="bi bi-rulers fs-3 text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Satuan</h6>
                                            <span class="badge bg-primary">
                                                {{ $paket->satuan == 'kg' ? '📏 Kilogram (kg)' : '📦 Pieces (pcs)' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="bi bi-toggle-{{ $paket->is_active ? 'on' : 'off' }} fs-3 {{ $paket->is_active ? 'text-success' : 'text-secondary' }}"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Status Paket</h6>
                                            @if($paket->is_active)
                                                <span class="badge bg-success">✅ Tersedia untuk Pelanggan</span>
                                            @else
                                                <span class="badge bg-secondary">❌ Tidak Tersedia</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Timestamp Information -->
                <div class="detail-section">
                    <h5 class="mb-3 fw-bold text-dark">
                        <i class="bi bi-clock-history me-2"></i>
                        Riwayat Paket
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="bi bi-calendar-plus fs-3 text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Dibuat</h6>
                                            <div class="text-muted">{{ $paket->created_at->format('d M Y, H:i') }}</div>
                                            <small class="text-muted">{{ $paket->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="bi bi-calendar-check fs-3 text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Terakhir Diperbarui</h6>
                                            <div class="text-muted">{{ $paket->updated_at->format('d M Y, H:i') }}</div>
                                            <small class="text-muted">{{ $paket->updated_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                    <a href="{{ route('admin.paket.index') }}" class="btn btn-outline-secondary btn-action">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <a href="{{ route('admin.paket.edit', $paket) }}" class="btn btn-warning btn-action">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Paket
                    </a>
                    <form action="{{ route('admin.paket.destroy', $paket) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-action">
                            <i class="bi bi-trash me-2"></i>
                            Hapus Paket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection