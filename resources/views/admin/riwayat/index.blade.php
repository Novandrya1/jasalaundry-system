@extends('layouts.app')

@section('title', 'Riwayat & Laporan')

@section('content')
<style>
.page-header {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    border-radius: 20px;
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
}

.filter-card {
    border: none;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}

.riwayat-card {
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

.mobile-riwayat {
    border: none;
    border-radius: 12px;
    margin-bottom: 1rem;
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.mobile-riwayat:hover {
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
            <h1 class="mb-2 fw-bold"><i class="bi bi-clock-history"></i> Riwayat & Laporan</h1>
            <p class="mb-0 opacity-90">Lihat semua transaksi dan buat laporan lengkap</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <span class="badge bg-light text-dark fs-6">
                Total: {{ $totalTransaksi }} Transaksi
            </span>
        </div>
    </div>
</div>

@if(!request('tanggal_mulai') && !request('tanggal_selesai'))
    <div class="alert alert-info alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none;">
        <i class="bi bi-info-circle"></i> 
        <strong>Info:</strong> Menampilkan transaksi hari ini ({{ date('d/m/Y') }}). 
        Gunakan filter tanggal atau tombol shortcut di bawah untuk melihat riwayat periode lain.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Analytics Dashboard -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-primary" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-primary fw-bold mb-1">{{ $totalTransaksi }}</h4>
                    <p class="mb-0 text-muted">Total Transaksi</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-receipt fs-1 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-success" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-success fw-bold mb-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                    <p class="mb-0 text-muted">Total Pendapatan</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-currency-dollar fs-1 text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-info" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-info fw-bold mb-1">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h4>
                    <p class="mb-0 text-muted">Bulan Ini</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-calendar-month fs-1 text-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-warning" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-warning fw-bold mb-1">Rp {{ number_format($rataRataHarian, 0, ',', '.') }}</h4>
                    <p class="mb-0 text-muted">
                        @if(request('tanggal_mulai') && request('tanggal_selesai'))
                            Rata-rata/Hari
                        @else
                            Hari Ini
                        @endif
                    </p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-graph-up fs-1 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Analytics -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-bar-chart"></i> Grafik Pendapatan 
                @if(request('tanggal_mulai') && request('tanggal_selesai'))
                    ({{ date('d/m/Y', strtotime(request('tanggal_mulai'))) }} - {{ date('d/m/Y', strtotime(request('tanggal_selesai'))) }})
                @else
                    (7 Hari Terakhir)
                @endif
                </h5>
            </div>
            <div class="card-body">
                <canvas id="pendapatanChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-pie-chart"></i> Status Transaksi 
                @if(request('tanggal_mulai') || request('tanggal_selesai') || request('status') || request('status_bayar') || request('kurir_id') || request('metode_bayar'))
                    (Filtered)
                @else
                    (Hari Ini)
                @endif
                </h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="filter-card">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('admin.riwayat.index') }}">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-3">
                    <label for="status" class="form-label fw-medium">Status Transaksi</label>
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
                
                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="status_bayar" class="form-label fw-medium">Status Bayar</label>
                    <select class="form-select" id="status_bayar" name="status_bayar">
                        <option value="">Semua</option>
                        <option value="belum_bayar" {{ request('status_bayar') == 'belum_bayar' ? 'selected' : '' }}>
                            💳 Belum Bayar
                        </option>
                        <option value="lunas" {{ request('status_bayar') == 'lunas' ? 'selected' : '' }}>
                            💰 Lunas
                        </option>
                    </select>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="tanggal_mulai" class="form-label fw-medium">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                           value="{{ request('tanggal_mulai') }}">
                </div>
                
                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="tanggal_selesai" class="form-label fw-medium">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                           value="{{ request('tanggal_selesai') }}">
                </div>
                
                <div class="col-lg-2 col-md-6 mb-3">
                    <label for="metode_bayar" class="form-label fw-medium">Metode Bayar</label>
                    <select class="form-select" id="metode_bayar" name="metode_bayar">
                        <option value="">Semua Metode</option>
                        <option value="tunai" {{ request('metode_bayar') == 'tunai' ? 'selected' : '' }}>
                            💵 Bayar Ditempat
                        </option>
                        <option value="transfer" {{ request('metode_bayar') == 'transfer' ? 'selected' : '' }}>
                            🏦 Transfer Bank
                        </option>
                    </select>
                </div>
                
                <div class="col-lg-1 col-md-6 mb-3">
                    <label for="kurir_id" class="form-label fw-medium">Kurir</label>
                    <select class="form-select" id="kurir_id" name="kurir_id">
                        <option value="">Semua</option>
                        @foreach($kurirs as $kurir)
                            <option value="{{ $kurir->id }}" {{ request('kurir_id') == $kurir->id ? 'selected' : '' }}>
                                {{ $kurir->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-12 mb-3">
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.riwayat.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Hari Ini
                        </a>
                        <a href="{{ route('admin.riwayat.index', ['tanggal_mulai' => date('Y-m-d', strtotime('-1 day')), 'tanggal_selesai' => date('Y-m-d', strtotime('-1 day'))]) }}" class="btn btn-outline-primary">
                            <i class="bi bi-calendar-minus"></i> Kemarin
                        </a>
                        <a href="{{ route('admin.riwayat.index', ['tanggal_mulai' => date('Y-m-01'), 'tanggal_selesai' => date('Y-m-d')]) }}" class="btn btn-outline-primary">
                            <i class="bi bi-calendar-month"></i> Bulan Ini
                        </a>
                        <button type="button" class="btn btn-success" onclick="cetakLaporan()">
                            <i class="bi bi-printer"></i> Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function cetakLaporan() {
    const params = new URLSearchParams();
    
    const status = document.getElementById('status').value;
    const statusBayar = document.getElementById('status_bayar').value;
    const tanggalMulai = document.getElementById('tanggal_mulai').value;
    const tanggalSelesai = document.getElementById('tanggal_selesai').value;
    const metodeBayar = document.getElementById('metode_bayar').value;
    const kurirId = document.getElementById('kurir_id').value;
    
    if (status) params.append('status', status);
    if (statusBayar) params.append('status_bayar', statusBayar);
    if (tanggalMulai) params.append('tanggal_mulai', tanggalMulai);
    if (tanggalSelesai) params.append('tanggal_selesai', tanggalSelesai);
    if (metodeBayar) params.append('metode_bayar', metodeBayar);
    if (kurirId) params.append('kurir_id', kurirId);
    
    const url = '{{ route("admin.riwayat.cetak-laporan") }}?' + params.toString();
    window.open(url, '_blank');
}
</script>

<!-- Daftar Transaksi -->
<div class="row">
    <div class="col-12">
        <div class="riwayat-card">
            <div class="card-body p-0">
                @if($transaksis->count() > 0)
                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th width="12%">Invoice</th>
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
                                            <small class="text-muted">{{ $transaksi->user->phone ?? $transaksi->user->email }}</small>
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
                                                <a href="{{ route('admin.riwayat.cetak', $transaksi) }}" class="action-btn btn btn-outline-success btn-sm" title="Cetak" target="_blank">
                                                    <i class="bi bi-printer"></i>
                                                </a>
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
                            <div class="mobile-riwayat">
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
                                            <a href="{{ route('admin.riwayat.cetak', $transaksi) }}" class="btn btn-outline-success btn-sm" target="_blank">
                                                <i class="bi bi-printer"></i>
                                            </a>
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
                        <i class="bi bi-calendar-x"></i>
                        <h4 class="text-muted mb-2">Tidak ada transaksi</h4>
                        <p class="text-muted mb-4">
                            @if(!request('tanggal_mulai') && !request('tanggal_selesai'))
                                Belum ada transaksi untuk hari ini ({{ date('d/m/Y') }})
                            @else
                                Tidak ada transaksi pada periode yang dipilih
                            @endif
                        </p>
                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <a href="{{ route('admin.riwayat.index', ['tanggal_mulai' => date('Y-m-d', strtotime('-1 day')), 'tanggal_selesai' => date('Y-m-d', strtotime('-1 day'))]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-calendar-minus"></i> Lihat Kemarin
                            </a>
                            <a href="{{ route('admin.riwayat.index', ['tanggal_mulai' => date('Y-m-01'), 'tanggal_selesai' => date('Y-m-d')]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-calendar-month"></i> Lihat Bulan Ini
                            </a>
                            <a href="{{ route('admin.riwayat.index', ['tanggal_mulai' => date('Y-m-d', strtotime('-7 days')), 'tanggal_selesai' => date('Y-m-d')]) }}" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-calendar-week"></i> 7 Hari Terakhir
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
console.log('Chart Labels:', {!! json_encode($chartLabels) !!});
console.log('Chart Data:', {!! json_encode($chartData) !!});
console.log('Status Labels:', {!! json_encode($statusLabels) !!});
console.log('Status Data:', {!! json_encode($statusData) !!});

// Grafik Pendapatan
const pendapatanCtx = document.getElementById('pendapatanChart').getContext('2d');
const chartData = {!! json_encode($chartData) !!};
const hasChartData = chartData.some(value => value > 0);

const pendapatanChart = new Chart(pendapatanCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: chartData,
            borderColor: hasChartData ? 'rgb(75, 192, 192)' : '#dee2e6',
            backgroundColor: hasChartData ? 'rgba(75, 192, 192, 0.2)' : 'rgba(222, 226, 230, 0.2)',
            tension: 0.1,
            fill: true,
            pointBackgroundColor: hasChartData ? 'rgb(75, 192, 192)' : '#dee2e6',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: hasChartData ? 'rgb(75, 192, 192)' : '#dee2e6'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            },
            legend: {
                display: true
            }
        }
    }
});

if (!hasChartData) {
    // Overlay text untuk grafik kosong
    const canvas = pendapatanCtx.canvas;
    const rect = canvas.getBoundingClientRect();
    const overlay = document.createElement('div');
    overlay.style.position = 'absolute';
    overlay.style.top = '50%';
    overlay.style.left = '50%';
    overlay.style.transform = 'translate(-50%, -50%)';
    overlay.style.color = '#6c757d';
    overlay.style.fontSize = '14px';
    overlay.style.pointerEvents = 'none';
    overlay.textContent = 'Tidak ada data pendapatan';
    canvas.parentElement.style.position = 'relative';
    canvas.parentElement.appendChild(overlay);
}

// Grafik Status Transaksi
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusData = {!! json_encode($statusData) !!};
const hasStatusData = statusData.some(value => value > 0);

if (hasStatusData) {
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusLabels) !!},
            datasets: [{
                data: statusData,
                backgroundColor: [
                    '#ffc107',
                    '#17a2b8',
                    '#007bff',
                    '#28a745',
                    '#343a40'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' transaksi';
                        }
                    }
                }
            }
        }
    });
} else {
    // Tampilkan pesan tidak ada data
    statusCtx.font = '16px Arial';
    statusCtx.fillStyle = '#6c757d';
    statusCtx.textAlign = 'center';
    statusCtx.fillText('Tidak ada data', statusCtx.canvas.width / 2, statusCtx.canvas.height / 2);
}
</script>
@endsection