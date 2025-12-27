@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<style>
.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.stat-card {
    border: none;
    border-radius: 16px;
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--card-color);
}

.stat-card.primary::before { background: linear-gradient(90deg, #667eea, #764ba2); }
.stat-card.danger::before { background: linear-gradient(90deg, #f093fb, #f5576c); }
.stat-card.info::before { background: linear-gradient(90deg, #4facfe, #00f2fe); }
.stat-card.success::before { background: linear-gradient(90deg, #43e97b, #38f9d7); }

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.menu-card {
    border: none;
    border-radius: 16px;
    transition: all 0.3s ease;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.menu-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.menu-icon {
    width: 70px;
    height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin: 0 auto 1rem;
}

.transaction-card {
    border: none;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
}

.table-modern td {
    border: none;
    padding: 1rem;
    border-bottom: 1px solid #f1f5f9;
}

.table-modern tr:hover {
    background: #f8fafc;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.empty-state {
    padding: 3rem 2rem;
    text-align: center;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .dashboard-header {
        padding: 1.5rem;
    }
    .stat-number {
        font-size: 2rem;
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    .menu-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
}
</style>

<!-- Header Dashboard -->
<div class="dashboard-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2 fw-bold">Dashboard Admin</h1>
            <p class="mb-0 opacity-90">Selamat datang kembali, Semangat bekerja <strong>{{ auth()->user()->name }}</strong> 👋</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="d-flex align-items-center justify-content-md-end">
                <i class="bi bi-calendar-day me-2"></i>
                <span>{{ now()->format('d F Y') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card primary">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-calendar-day"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-number text-primary">{{ $totalPesananHariIni }}</div>
                        <p class="mb-0 text-muted fw-medium">Pesanan Hari Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card danger">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger me-3">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-number text-danger">{{ $pesananBaru }}</div>
                        <p class="mb-0 text-muted fw-medium">Pesanan Baru</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card info">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="text-info fw-bold fs-6">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                        <p class="mb-0 text-muted fw-medium">Pendapatan Bulan Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card success">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="stat-number text-success">{{ $totalPelanggan }}</div>
                        <p class="mb-0 text-muted fw-medium">Total Pelanggan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Menu Cepat -->
<div class="row mb-4">
    <div class="col-12 mb-3">
        <h4 class="fw-bold">Menu Cepat</h4>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="menu-card h-100">
            <div class="card-body text-center p-4">
                <div class="menu-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-box"></i>
                </div>
                <h6 class="fw-bold mb-2">Kelola Paket</h6>
                <p class="text-muted small mb-3">Tambah, edit, atau hapus paket laundry</p>
                <a href="{{ route('admin.paket.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-right me-1"></i>Kelola Paket
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="menu-card h-100">
            <div class="card-body text-center p-4">
                <div class="menu-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-receipt"></i>
                </div>
                <h6 class="fw-bold mb-2">Kelola Transaksi</h6>
                <p class="text-muted small mb-3">Proses pesanan dan update status</p>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-right me-1"></i>Kelola Transaksi
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="menu-card h-100">
            <div class="card-body text-center p-4">
                <div class="menu-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-people"></i>
                </div>
                <h6 class="fw-bold mb-2">Kelola Kurir</h6>
                <p class="text-muted small mb-3">Tambah dan kelola data kurir</p>
                <a href="{{ route('admin.kurir.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-right me-1"></i>Kelola Kurir
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="menu-card h-100">
            <div class="card-body text-center p-4">
                <div class="menu-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h6 class="fw-bold mb-2">Riwayat & Laporan</h6>
                <p class="text-muted small mb-3">Lihat riwayat dan cetak laporan</p>
                <a href="{{ route('admin.riwayat.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-right me-1"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="menu-card h-100">
            <div class="card-body text-center p-4">
                <div class="menu-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-gift"></i>
                </div>
                <h6 class="fw-bold mb-2">Kelola Promo</h6>
                <p class="text-muted small mb-3">Buat dan kelola promo diskon</p>
                <a href="{{ route('admin.promo.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-right me-1"></i>Kelola Promo
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="menu-card h-100">
            <div class="card-body text-center p-4">
                <div class="menu-icon bg-secondary bg-opacity-10 text-secondary position-relative">
                    <i class="bi bi-check-circle"></i>
                    @php
                        $pendingClaims = \App\Models\PromoClaim::where('status', 'pending')->count();
                    @endphp
                    @if($pendingClaims > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            {{ $pendingClaims }}
                        </span>
                    @endif
                </div>
                <h6 class="fw-bold mb-2">Validasi Promo</h6>
                <p class="text-muted small mb-3">Setujui atau tolak klaim promo</p>
                <a href="{{ route('admin.promo-claim.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-right me-1"></i>Validasi Promo
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="transaction-card">
            <div class="card-header border-0 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Transaksi Terbaru</h5>
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye me-1"></i>Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($transaksiTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Kode Invoice</th>
                                    <th>Pelanggan</th>
                                    <th>Paket</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiTerbaru as $transaksi)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-primary">{{ $transaksi->kode_invoice }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    <div class="d-flex align-items-center justify-content-center" 
                                                         style="width: 35px; height: 35px; background: #f1f5f9; border-radius: 8px;">
                                                        <i class="bi bi-person text-primary"></i>
                                                    </div>
                                                </div>
                                                <span class="fw-medium">{{ $transaksi->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @foreach($transaksi->detailTransaksis as $detail)
                                                <span class="badge bg-light text-dark border me-1">{{ $detail->paket->nama_paket }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($transaksi->status_transaksi === 'request_jemput')
                                                <span class="status-badge bg-warning text-dark">Menunggu Penjemputan</span>
                                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                                <span class="status-badge bg-info text-white">Dijemput Kurir</span>
                                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                <span class="status-badge bg-primary text-white">Sedang Dicuci</span>
                                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                                <span class="status-badge bg-success text-white">Siap Diantar</span>
                                            @elseif($transaksi->status_transaksi === 'selesai')
                                                <span class="status-badge bg-dark text-white">Selesai</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="text-muted">{{ $transaksi->created_at->format('d/m/Y') }}</span><br>
                                                <small class="text-muted">{{ $transaksi->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('admin.transaksi.edit', $transaksi) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Edit Transaksi">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                @if($transaksi->status_transaksi !== 'selesai')
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-success dropdown-toggle" 
                                                                data-bs-toggle="dropdown" title="Update Status">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @if($transaksi->status_transaksi === 'request_jemput')
                                                                <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $transaksi->id }}, 'dijemput_kurir')">Dijemput Kurir</a></li>
                                                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                                                <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $transaksi->id }}, 'proses_cuci')">Proses Cuci</a></li>
                                                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                                <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $transaksi->id }}, 'siap_antar')">Siap Antar</a></li>
                                                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                                                <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $transaksi->id }}, 'selesai')">Selesai</a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h5 class="text-muted mb-2">Belum ada transaksi</h5>
                        <p class="text-muted">Transaksi akan muncul di sini setelah pelanggan melakukan pemesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Form tersembunyi untuk update status -->
<form id="updateStatusForm" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status_transaksi" id="newStatus">
</form>

<script>
function updateStatus(transaksiId, newStatus) {
    const statusNames = {
        'dijemput_kurir': 'Dijemput Kurir',
        'proses_cuci': 'Proses Cuci', 
        'siap_antar': 'Siap Antar',
        'selesai': 'Selesai'
    };
    
    if (confirm(`Apakah Anda yakin ingin mengubah status menjadi "${statusNames[newStatus]}"?`)) {
        const form = document.getElementById('updateStatusForm');
        const statusInput = document.getElementById('newStatus');
        
        form.action = `/admin/transaksi/${transaksiId}`;
        statusInput.value = newStatus;
        
        // Tambahkan input tersembunyi untuk status_bayar dan berat_aktual
        const statusBayarInput = document.createElement('input');
        statusBayarInput.type = 'hidden';
        statusBayarInput.name = 'status_bayar';
        statusBayarInput.value = 'belum_bayar';
        form.appendChild(statusBayarInput);
        
        const beratInput = document.createElement('input');
        beratInput.type = 'hidden';
        beratInput.name = 'berat_aktual';
        beratInput.value = '';
        form.appendChild(beratInput);
        
        form.submit();
    }
}
</script>
@endsection