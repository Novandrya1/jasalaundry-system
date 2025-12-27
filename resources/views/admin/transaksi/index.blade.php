@extends('layouts.app')

@section('title', 'Kelola Transaksi')

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

.filter-card {
    border: none;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}

.transaction-card {
    border: none;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
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

.customer-info {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 0.75rem;
}

.action-btn {
    border-radius: 8px;
    padding: 0.4rem 0.6rem;
    margin: 0 0.1rem;
}

.mobile-transaction {
    border: none;
    border-radius: 12px;
    margin-bottom: 1rem;
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.mobile-transaction:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.empty-state {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    .table-responsive {
        font-size: 0.85rem;
    }
    .action-btn {
        padding: 0.3rem 0.5rem;
        font-size: 0.8rem;
    }
}
</style>

<!-- Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2 fw-bold"><i class="bi bi-receipt"></i> Kelola Transaksi</h1>
            <p class="mb-0 opacity-90">Proses dan kelola semua transaksi laundry</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <span class="badge bg-light text-dark fs-6">
                Total: {{ $transaksis->total() }} Transaksi
            </span>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="filter-card">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('admin.transaksi.index') }}">
            <div class="row align-items-end">
                <div class="col-lg-4 col-md-6 mb-3">
                    <label for="status" class="form-label fw-medium">Filter Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="request_jemput" {{ request('status') == 'request_jemput' ? 'selected' : '' }}>
                            🕐 Menunggu Penjemputan
                        </option>
                        <option value="dijemput_kurir" {{ request('status') == 'dijemput_kurir' ? 'selected' : '' }}>
                            🚛 Dijemput Kurir
                        </option>
                        <option value="proses_cuci" {{ request('status') == 'proses_cuci' ? 'selected' : '' }}>
                            🧽 Sedang Dicuci
                        </option>
                        <option value="siap_antar" {{ request('status') == 'siap_antar' ? 'selected' : '' }}>
                            📦 Siap Diantar
                        </option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                            ✅ Selesai
                        </option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <label for="tanggal" class="form-label fw-medium">Filter Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal') }}">
                </div>
                <div class="col-lg-4 col-md-12 mb-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Daftar Transaksi -->
<div class="row">
    <div class="col-12">
        <div class="transaction-card">
            <div class="card-body p-0">
                @if($transaksis->count() > 0)
                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th width="12%">Kode Invoice</th>
                                    <th width="15%">Pelanggan</th>
                                    <th width="12%">Paket</th>
                                    <th width="8%">Berat</th>
                                    <th width="12%">Total</th>
                                    <th width="15%">Status</th>
                                    <th width="10%">Kurir</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="6%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksis as $transaksi)
                                    <tr>
                                        <td><span class="fw-bold text-primary">{{ $transaksi->kode_invoice }}</span></td>
                                        <td>
                                            <div class="customer-info">{{ $transaksi->user->name }}</div>
                                            <small class="text-muted">{{ $transaksi->user->phone }}</small>
                                        </td>
                                        <td>
                                            @foreach($transaksi->detailTransaksis as $detail)
                                                <span class="badge bg-light text-dark border me-1">{{ $detail->paket->nama_paket }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($transaksi->berat_aktual)
                                                <span class="badge bg-info text-white">{{ $transaksi->berat_aktual }} kg</span>
                                            @else
                                                <span class="text-muted small">Belum ditimbang</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaksi->diskon > 0)
                                                <div><small class="text-muted text-decoration-line-through">Rp {{ number_format($transaksi->total_harga + $transaksi->diskon, 0, ',', '.') }}</small></div>
                                                <div class="text-danger small">-Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</div>
                                            @endif
                                            <div class="fw-bold text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
                                            @if($transaksi->promoClaim)
                                                <small class="badge bg-secondary">{{ $transaksi->promoClaim->kode_promo }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaksi->status_transaksi === 'request_jemput')
                                                <span class="status-badge bg-warning text-dark">🕐 Menunggu</span>
                                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                                <span class="status-badge bg-info text-white">🚛 Dijemput</span>
                                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                <span class="status-badge bg-primary text-white">🧽 Dicuci</span>
                                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                                <span class="status-badge bg-success text-white">📦 Siap Antar</span>
                                            @elseif($transaksi->status_transaksi === 'selesai')
                                                <span class="status-badge bg-dark text-white">✅ Selesai</span>
                                            @endif
                                            <br>
                                            @if($transaksi->status_bayar === 'belum_bayar')
                                                <span class="status-badge bg-danger text-white mt-1">💳 Belum Bayar</span>
                                            @else
                                                <span class="status-badge bg-success text-white mt-1">💰 Lunas</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaksi->kurir)
                                                <span class="fw-medium">{{ $transaksi->kurir->name }}</span>
                                            @else
                                                <span class="text-muted small">Belum ditugaskan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-muted small">
                                                {{ $transaksi->created_at->format('d/m/Y') }}<br>
                                                <small>{{ $transaksi->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('admin.transaksi.show', $transaksi) }}" class="action-btn btn btn-outline-info btn-sm" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @if($transaksi->status_transaksi !== 'selesai')
                                                    <a href="{{ route('admin.transaksi.edit', $transaksi) }}" class="action-btn btn btn-outline-warning btn-sm" title="Proses">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Mobile Cards -->
                    <div class="d-lg-none p-3">
                        @foreach($transaksis as $transaksi)
                            <div class="mobile-transaction">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="fw-bold mb-0">{{ $transaksi->kode_invoice }}</h6>
                                        <div class="text-end">
                                            @if($transaksi->status_transaksi === 'request_jemput')
                                                <span class="badge bg-warning text-dark">🕐 Menunggu</span>
                                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                                <span class="badge bg-info text-white">🚛 Dijemput</span>
                                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                <span class="badge bg-primary text-white">🧽 Dicuci</span>
                                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                                <span class="badge bg-success text-white">📦 Siap Antar</span>
                                            @elseif($transaksi->status_transaksi === 'selesai')
                                                <span class="badge bg-dark text-white">✅ Selesai</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-8">
                                            <p class="mb-1 fw-medium">{{ $transaksi->user->name }}</p>
                                            <p class="mb-1 small text-muted">{{ $transaksi->user->phone }}</p>
                                            <div class="mb-1">
                                                @foreach($transaksi->detailTransaksis as $detail)
                                                    <span class="badge bg-light text-dark border me-1">{{ $detail->paket->nama_paket }}</span>
                                                @endforeach
                                            </div>
                                            @if($transaksi->kurir)
                                                <p class="mb-1 small"><i class="bi bi-person"></i> {{ $transaksi->kurir->name }}</p>
                                            @endif
                                        </div>
                                        <div class="col-4 text-end">
                                            @if($transaksi->berat_aktual)
                                                <p class="mb-1"><span class="badge bg-info text-white">{{ $transaksi->berat_aktual }} kg</span></p>
                                            @endif
                                            <p class="mb-1 fw-bold text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                                            @if($transaksi->status_bayar === 'belum_bayar')
                                                <span class="badge bg-danger text-white">💳 Belum Bayar</span>
                                            @else
                                                <span class="badge bg-success text-white">💰 Lunas</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted">{{ $transaksi->created_at->format('d/m/Y H:i') }}</small>
                                        <div>
                                            <a href="{{ route('admin.transaksi.show', $transaksi) }}" class="btn btn-outline-info btn-sm me-1">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($transaksi->status_transaksi !== 'selesai')
                                                <a href="{{ route('admin.transaksi.edit', $transaksi) }}" class="btn btn-outline-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($transaksis->hasPages())
                        <div class="d-flex justify-content-center p-3">
                            {{ $transaksis->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h4 class="text-muted mb-2">Belum ada transaksi</h4>
                        <p class="text-muted mb-4">Transaksi akan muncul di sini setelah pelanggan melakukan pemesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection