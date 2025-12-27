@extends('layouts.app')

@section('title', 'Detail Kurir')

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
    margin-bottom: 1.5rem;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    margin-bottom: 1.5rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.table-modern {
    border-collapse: separate;
    border-spacing: 0;
}

.table-modern th {
    background: #f8fafc;
    border: none;
    padding: 1rem;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

.table-modern td {
    border: none;
    padding: 1rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.table-modern tr:hover {
    background: #f8fafc;
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
    
    .stats-card {
        padding: 1.5rem;
    }
}
</style>

<!-- Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2 fw-bold">
                <i class="bi bi-person-badge me-3"></i>
                Detail Kurir
            </h1>
            <p class="mb-0 opacity-90">Informasi lengkap dan statistik kurir {{ $kurir->name }}</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <span class="badge bg-light text-dark fs-6">
                <i class="bi bi-calendar-plus me-1"></i>
                Bergabung {{ $kurir->created_at->format('M Y') }}
            </span>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Stats Card -->
        <div class="stats-card">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="mb-2 fw-bold">{{ $kurir->name }}</h2>
                    <p class="mb-0 opacity-90">{{ $kurir->email }} • {{ $kurir->phone }}</p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-4 stat-item">
                            <div class="stat-number">{{ $kurir->transaksiKurir->count() }}</div>
                            <div class="opacity-90">Total Tugas</div>
                        </div>
                        <div class="col-4 stat-item">
                            <div class="stat-number">{{ $kurir->transaksiKurir->where('status_transaksi', 'selesai')->count() }}</div>
                            <div class="opacity-90">Selesai</div>
                        </div>
                        <div class="col-4 stat-item">
                            <div class="stat-number">{{ $kurir->transaksiKurir->whereNotIn('status_transaksi', ['selesai'])->count() }}</div>
                            <div class="opacity-90">Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="detail-card">
            <div class="card-body p-4">
                <!-- Kurir Information -->
                <div class="detail-section">
                    <h5 class="mb-3 fw-bold text-dark">
                        <i class="bi bi-person-lines-fill me-2"></i>
                        Informasi Kurir
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="bi bi-person fs-3 text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Nama Lengkap</h6>
                                            <div class="text-muted">{{ $kurir->name }}</div>
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
                                            <i class="bi bi-envelope fs-3 text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Email</h6>
                                            <div class="text-muted">{{ $kurir->email }}</div>
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
                                            <i class="bi bi-telephone fs-3 text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Telepon</h6>
                                            <div class="text-muted">{{ $kurir->phone }}</div>
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
                                            <i class="bi bi-geo-alt fs-3 text-danger"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Alamat</h6>
                                            <div class="text-muted">{{ $kurir->address }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Task History -->
                <div class="detail-section">
                    <h5 class="mb-3 fw-bold text-dark">
                        <i class="bi bi-clock-history me-2"></i>
                        Riwayat Tugas Terbaru
                    </h5>
                    
                    @if($kurir->transaksiKurir->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th width="15%">Invoice</th>
                                        <th width="25%">Pelanggan</th>
                                        <th width="15%">Status</th>
                                        <th width="20%">Total</th>
                                        <th width="25%">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kurir->transaksiKurir->take(10) as $transaksi)
                                        <tr>
                                            <td><span class="fw-bold text-primary">{{ $transaksi->kode_invoice }}</span></td>
                                            <td>
                                                <div class="fw-medium">{{ $transaksi->user->name }}</div>
                                                <small class="text-muted">{{ $transaksi->user->phone }}</small>
                                            </td>
                                            <td>
                                                @if($transaksi->status_transaksi === 'dijemput_kurir')
                                                    <span class="badge bg-info text-white">🚛 Dijemput</span>
                                                @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                    <span class="badge bg-primary text-white">🧽 Proses</span>
                                                @elseif($transaksi->status_transaksi === 'siap_antar')
                                                    <span class="badge bg-success text-white">📦 Siap Antar</span>
                                                @elseif($transaksi->status_transaksi === 'selesai')
                                                    <span class="badge bg-dark text-white">✅ Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
                                            </td>
                                            <td>
                                                <div class="text-muted small">
                                                    {{ $transaksi->created_at->format('d M Y') }}<br>
                                                    <small>{{ $transaksi->created_at->format('H:i') }}</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($kurir->transaksiKurir->count() > 10)
                            <div class="text-center mt-3">
                                <small class="text-muted">Menampilkan 10 tugas terbaru dari {{ $kurir->transaksiKurir->count() }} total tugas</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <h5 class="text-muted mt-3">Belum Ada Tugas</h5>
                            <p class="text-muted">Kurir ini belum mendapat tugas pengiriman</p>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                    <a href="{{ route('admin.kurir.index') }}" class="btn btn-outline-secondary btn-action">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <a href="{{ route('admin.kurir.edit', $kurir) }}" class="btn btn-warning btn-action">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Kurir
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection