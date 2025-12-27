@extends('layouts.app')

@section('title', 'Kelola Promo')

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

.promo-card {
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

.promo-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.discount-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.85rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
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

.period-text {
    font-size: 0.85rem;
    color: #6b7280;
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
            <h1 class="mb-2 fw-bold"><i class="bi bi-gift"></i> Kelola Promo</h1>
            <p class="mb-0 opacity-90">Buat dan kelola promo menarik untuk pelanggan</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.promo.create') }}" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Tambah Promo
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="promo-card">
            <div class="card-body p-0">
                @if($promos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Judul Promo</th>
                                    <th width="15%">Diskon</th>
                                    <th width="25%">Deskripsi</th>
                                    <th width="20%">Periode</th>
                                    <th width="10%">Status</th>
                                    <th width="5%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promos as $index => $promo)
                                    <tr>
                                        <td class="text-muted">{{ $promos->firstItem() + $index }}</td>
                                        <td>
                                            <div class="promo-title">{{ $promo->judul }}</div>
                                        </td>
                                        <td>
                                            <span class="discount-badge">{{ $promo->diskon_text }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($promo->deskripsi, 40) }}</span>
                                        </td>
                                        <td>
                                            <div class="period-text">
                                                <i class="bi bi-calendar me-1"></i>
                                                {{ $promo->tanggal_mulai->format('d/m/Y') }}<br>
                                                <small>s/d {{ $promo->tanggal_selesai->format('d/m/Y') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($promo->is_active && $promo->tanggal_mulai <= now() && $promo->tanggal_selesai >= now())
                                                <span class="status-badge bg-success text-white">Aktif</span>
                                            @elseif($promo->tanggal_selesai < now())
                                                <span class="status-badge bg-secondary text-white">Berakhir</span>
                                            @elseif($promo->tanggal_mulai > now())
                                                <span class="status-badge bg-warning text-dark">Akan Datang</span>
                                            @else
                                                <span class="status-badge bg-danger text-white">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('admin.promo.edit', $promo) }}" 
                                                   class="action-btn btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.promo.destroy', $promo) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus promo ini?')">
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

                    @if($promos->hasPages())
                        <div class="d-flex justify-content-center p-3">
                            {{ $promos->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="bi bi-gift"></i>
                        <h4 class="text-muted mb-2">Belum ada promo</h4>
                        <p class="text-muted mb-4">Tambahkan promo menarik untuk meningkatkan penjualan</p>
                        <a href="{{ route('admin.promo.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Buat Promo Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection