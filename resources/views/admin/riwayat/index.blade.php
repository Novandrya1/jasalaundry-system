@extends('layouts.app')

@section('title', 'Riwayat & Laporan')

@section('content')
<div class="row">
    <div class="col-12">
        <h2><i class="bi bi-clock-history"></i> Riwayat & Laporan</h2>
        <p class="text-muted">Lihat semua transaksi dan buat laporan</p>
        @if(!request('tanggal_mulai') && !request('tanggal_selesai'))
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Menampilkan transaksi hari ini. Gunakan filter tanggal untuk melihat riwayat hari lain.
            </div>
        @endif
    </div>
</div>

<!-- Analytics Dashboard -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4>{{ $totalTransaksi }}</h4>
                    <p class="mb-0">Total Transaksi</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-receipt fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                    <p class="mb-0">Total Pendapatan</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-currency-dollar fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4>Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h4>
                    <p class="mb-0">Bulan Ini</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-calendar-month fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4>Rp {{ number_format($rataRataHarian, 0, ',', '.') }}</h4>
                    <p class="mb-0">Rata-rata/Hari</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-graph-up fs-1"></i>
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
                <h5><i class="bi bi-bar-chart"></i> Grafik Pendapatan 7 Hari Terakhir</h5>
            </div>
            <div class="card-body">
                <canvas id="pendapatanChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-pie-chart"></i> Status Transaksi</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.riwayat.index') }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">Status Transaksi</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="request_jemput" {{ request('status') == 'request_jemput' ? 'selected' : '' }}>
                                    Menunggu Penjemputan
                                </option>
                                <option value="dijemput_kurir" {{ request('status') == 'dijemput_kurir' ? 'selected' : '' }}>
                                    Dijemput Kurir
                                </option>
                                <option value="proses_cuci" {{ request('status') == 'proses_cuci' ? 'selected' : '' }}>
                                    Sedang Dicuci
                                </option>
                                <option value="siap_antar" {{ request('status') == 'siap_antar' ? 'selected' : '' }}>
                                    Siap Diantar
                                </option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                            </select>
                        </div>
                        
                        <div class="col-md-2 mb-3">
                            <label for="status_bayar" class="form-label">Status Bayar</label>
                            <select class="form-select" id="status_bayar" name="status_bayar">
                                <option value="">Semua</option>
                                <option value="belum_bayar" {{ request('status_bayar') == 'belum_bayar' ? 'selected' : '' }}>
                                    Belum Bayar
                                </option>
                                <option value="lunas" {{ request('status_bayar') == 'lunas' ? 'selected' : '' }}>
                                    Lunas
                                </option>
                            </select>
                        </div>
                        
                        <div class="col-md-2 mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                   value="{{ request('tanggal_mulai') }}">
                        </div>
                        
                        <div class="col-md-2 mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                   value="{{ request('tanggal_selesai') }}">
                        </div>
                        
                        <div class="col-md-2 mb-3">
                            <label for="metode_bayar" class="form-label">Metode Bayar</label>
                            <select class="form-select" id="metode_bayar" name="metode_bayar">
                                <option value="">Semua Metode</option>
                                <option value="tunai" {{ request('metode_bayar') == 'tunai' ? 'selected' : '' }}>
                                    Bayar Ditempat
                                </option>
                                <option value="transfer" {{ request('metode_bayar') == 'transfer' ? 'selected' : '' }}>
                                    Transfer Bank
                                </option>
                            </select>
                        </div>
                        
                        <div class="col-md-2 mb-3">
                            <label for="kurir_id" class="form-label">Kurir</label>
                            <select class="form-select" id="kurir_id" name="kurir_id">
                                <option value="">Semua Kurir</option>
                                @foreach($kurirs as $kurir)
                                    <option value="{{ $kurir->id }}" {{ request('kurir_id') == $kurir->id ? 'selected' : '' }}>
                                        {{ $kurir->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.riwayat.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-clockwise"></i> Hari Ini
                                </a>
                                <a href="{{ route('admin.riwayat.index', ['tanggal_mulai' => date('Y-m-d', strtotime('-1 day')), 'tanggal_selesai' => date('Y-m-d', strtotime('-1 day'))]) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-calendar-minus"></i> Kemarin
                                </a>
                                <a href="{{ route('admin.riwayat.index', ['tanggal_mulai' => date('Y-m-d', strtotime('-7 days')), 'tanggal_selesai' => date('Y-m-d')]) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-calendar-week"></i> 7 Hari Terakhir
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
        <div class="card shadow">
            <div class="card-body">

                @if($transaksis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Invoice</th>
                                    <th>Pelanggan</th>
                                    <th>Paket</th>
                                    <th>Berat</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Kurir</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksis as $transaksi)
                                    <tr>
                                        <td><strong>{{ $transaksi->kode_invoice }}</strong></td>
                                        <td>{{ $transaksi->user->name }}</td>
                                        <td>
                                            @foreach($transaksi->detailTransaksis as $detail)
                                                {{ $detail->paket->nama_paket }}
                                                @if(!$loop->last)<br>@endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($transaksi->berat_aktual)
                                                {{ $transaksi->berat_aktual }} kg
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            @if($transaksi->status_transaksi === 'request_jemput')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                                <span class="badge bg-info">Dijemput</span>
                                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                <span class="badge bg-primary">Proses</span>
                                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                                <span class="badge bg-success">Siap Antar</span>
                                            @elseif($transaksi->status_transaksi === 'selesai')
                                                <span class="badge bg-dark">Selesai</span>
                                            @endif
                                            <br>
                                            @if($transaksi->status_bayar === 'lunas')
                                                <span class="badge bg-success">Lunas</span>
                                            @else
                                                <span class="badge bg-danger">Belum Bayar</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $transaksi->kurir ? $transaksi->kurir->name : '-' }}
                                        </td>
                                        <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.transaksi.show', $transaksi) }}" 
                                                   class="btn btn-info btn-sm" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.riwayat.cetak', $transaksi) }}" 
                                                   class="btn btn-success btn-sm" title="Cetak Invoice" target="_blank">
                                                    <i class="bi bi-printer"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($transaksis->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $transaksis->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <h5 class="text-muted mt-2">Tidak ada data</h5>
                        <p class="text-muted">Tidak ada transaksi yang sesuai dengan filter</p>
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

// Grafik Pendapatan 7 Hari Terakhir
const pendapatanCtx = document.getElementById('pendapatanChart').getContext('2d');
const pendapatanChart = new Chart(pendapatanCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode($chartData) !!},
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true,
            pointBackgroundColor: 'rgb(75, 192, 192)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(75, 192, 192)'
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

// Grafik Status Transaksi
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($statusLabels) !!},
        datasets: [{
            data: {!! json_encode($statusData) !!},
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
</script>
@endsection