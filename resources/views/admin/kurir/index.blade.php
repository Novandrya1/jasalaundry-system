@extends('layouts.app')

@section('title', 'Kelola Kurir')

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

.filter-card {
    border: none;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}

.kurir-card {
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

.kurir-info {
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

.mobile-kurir {
    border: none;
    border-radius: 12px;
    margin-bottom: 1rem;
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.mobile-kurir:hover {
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
            <h1 class="mb-2 fw-bold"><i class="bi bi-people-fill"></i> Kelola Kurir</h1>
            <p class="mb-0 opacity-90">Kelola data kurir dan monitor performa pengiriman</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.kurir.create') }}" class="btn btn-light btn-lg">
                <i class="bi bi-plus-circle me-2"></i>
                Tambah Kurir
            </a>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="filter-card">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('admin.kurir.index') }}">
            <div class="row align-items-end">
                <div class="col-lg-4 col-md-6 mb-3">
                    <label for="status" class="form-label fw-medium">Filter Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Kurir</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                            🟢 Kurir Aktif
                        </option>
                        <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>
                            🔴 Kurir Tidak Aktif
                        </option>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <label for="search" class="form-label fw-medium">Cari Kurir</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Nama atau email kurir..." value="{{ request('search') }}">
                </div>
                <div class="col-lg-4 col-md-12 mb-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.kurir.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Daftar Kurir -->
<div class="row">
    <div class="col-12">
        <div class="kurir-card">
            <div class="card-body p-0">
                @if($kurirs->count() > 0)
                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th width="8%">No</th>
                                    <th width="20%">Kurir</th>
                                    <th width="15%">Kontak</th>
                                    <th width="25%">Alamat</th>
                                    <th width="12%">📊 Tugas</th>
                                    <th width="12%">📅 Bergabung</th>
                                    <th width="8%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kurirs as $index => $kurir)
                                    <tr>
                                        <td><span class="fw-bold">{{ $kurirs->firstItem() + $index }}</span></td>
                                        <td>
                                            <div class="kurir-info">{{ $kurir->name }}</div>
                                            <small class="text-muted">{{ $kurir->email }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ $kurir->phone }}</div>
                                            <small class="text-muted">{{ $kurir->email }}</small>
                                        </td>
                                        <td>
                                            <span title="{{ $kurir->address }}">{{ Str::limit($kurir->address, 40) }}</span>
                                        </td>
                                        <td>
                                            @if($kurir->transaksi_kurir_count > 0)
                                                <span class="status-badge bg-info text-white">{{ $kurir->transaksi_kurir_count }} tugas</span>
                                            @else
                                                <span class="text-muted small">Belum ada tugas</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-muted small">
                                                {{ $kurir->created_at->format('d/m/Y') }}<br>
                                                <small>{{ $kurir->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('admin.kurir.show', $kurir) }}" class="action-btn btn btn-outline-info btn-sm" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.kurir.edit', $kurir) }}" class="action-btn btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.kurir.destroy', $kurir) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus kurir ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn btn btn-outline-danger btn-sm" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Mobile Cards -->
                    <div class="d-lg-none p-3">
                        @foreach($kurirs as $kurir)
                            <div class="mobile-kurir">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="fw-bold mb-0">{{ $kurir->name }}</h6>
                                        <div class="text-end">
                                            @if($kurir->transaksi_kurir_count > 0)
                                                <span class="badge bg-info text-white">{{ $kurir->transaksi_kurir_count }} tugas</span>
                                            @else
                                                <span class="badge bg-secondary">Belum ada tugas</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-8">
                                            <p class="mb-1 small text-muted">{{ $kurir->email }}</p>
                                            <p class="mb-1 fw-medium">{{ $kurir->phone }}</p>
                                            <p class="mb-1 small text-muted">{{ Str::limit($kurir->address, 50) }}</p>
                                        </div>
                                        <div class="col-4 text-end">
                                            <p class="mb-1 small text-muted">Bergabung</p>
                                            <p class="mb-0 fw-medium">{{ $kurir->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted">{{ $kurir->created_at->format('d/m/Y H:i') }}</small>
                                        <div>
                                            <a href="{{ route('admin.kurir.show', $kurir) }}" class="btn btn-outline-info btn-sm me-1">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.kurir.edit', $kurir) }}" class="btn btn-outline-warning btn-sm me-1">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.kurir.destroy', $kurir) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus kurir ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($kurirs->hasPages())
                        <div class="d-flex justify-content-center p-3">
                            {{ $kurirs->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="bi bi-people"></i>
                        <h4 class="text-muted mb-2">Belum ada kurir</h4>
                        <p class="text-muted mb-4">Tambahkan kurir pertama untuk menangani pengiriman laundry</p>
                        <a href="{{ route('admin.kurir.create') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>
                            Tambah Kurir Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection