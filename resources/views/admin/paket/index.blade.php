@extends('layouts.app')

@section('title', 'Kelola Paket')

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

.paket-card {
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

.paket-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.paket-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #059669;
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
        font-size: 0.9rem;
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
            <h1 class="mb-2 fw-bold"><i class="bi bi-box"></i> Kelola Paket Laundry</h1>
            <p class="mb-0 opacity-90">Tambah, edit, dan kelola paket layanan laundry</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.paket.create') }}" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Tambah Paket
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @php
        $paketLaundry = $pakets->filter(function($p) {
            return !str_contains(strtolower($p->nama_paket), '(antar)');
        });
        $paketJemputAntar = $pakets->filter(function($p) {
            return str_contains(strtolower($p->nama_paket), '(antar)');
        });
        @endphp
        
        <!-- Paket Laundry -->
        <div class="paket-card mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold"><i class="bi bi-droplet-fill text-primary me-2"></i>Paket Laundry</h5>
            </div>
            <div class="card-body p-0">
                @if($paketLaundry->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Nama Paket</th>
                                    <th width="15%">Harga</th>
                                    <th width="10%">Satuan</th>
                                    <th width="10%">Status</th>
                                    <th width="25%">Deskripsi</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paketLaundry as $index => $paket)
                                    <tr>
                                        <td class="text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="paket-name">{{ $paket->nama_paket }}</div>
                                        </td>
                                        <td>
                                            <div class="paket-price">
                                                Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ $paket->satuan }}</span>
                                        </td>
                                        <td>
                                            @if($paket->is_active)
                                                <span class="status-badge bg-success text-white">Aktif</span>
                                            @else
                                                <span class="status-badge bg-secondary text-white">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($paket->deskripsi, 50) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('admin.paket.show', $paket) }}" 
                                                   class="action-btn btn btn-outline-info btn-sm" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.paket.edit', $paket) }}" 
                                                   class="action-btn btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.paket.destroy', $paket) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
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
                @else
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Belum ada paket laundry
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Paket Jemput & Antar -->
        <div class="paket-card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0 fw-bold"><i class="bi bi-truck text-primary me-2"></i>Paket Jemput & Antar</h5>
            </div>
            <div class="card-body p-0">
                @if($paketJemputAntar->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Nama Paket</th>
                                    <th width="15%">Harga</th>
                                    <th width="10%">Satuan</th>
                                    <th width="10%">Status</th>
                                    <th width="25%">Deskripsi</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paketJemputAntar as $index => $paket)
                                    <tr>
                                        <td class="text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="paket-name">{{ $paket->nama_paket }}</div>
                                        </td>
                                        <td>
                                            <div class="paket-price">
                                                Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ $paket->satuan }}</span>
                                        </td>
                                        <td>
                                            @if($paket->is_active)
                                                <span class="status-badge bg-success text-white">Aktif</span>
                                            @else
                                                <span class="status-badge bg-secondary text-white">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($paket->deskripsi, 50) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('admin.paket.show', $paket) }}" 
                                                   class="action-btn btn btn-outline-info btn-sm" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.paket.edit', $paket) }}" 
                                                   class="action-btn btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.paket.destroy', $paket) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
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
                @else
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Belum ada paket jemput & antar
                    </div>
                @endif
            </div>
        </div>
        
        @if($pakets->count() == 0)
        <div class="paket-card mt-4">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h4 class="text-muted mb-2">Belum ada paket laundry</h4>
                <p class="text-muted mb-4">Tambahkan paket laundry pertama untuk memulai layanan</p>
                <a href="{{ route('admin.paket.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Paket Pertama
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection