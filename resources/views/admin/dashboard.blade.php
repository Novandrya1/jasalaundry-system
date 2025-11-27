@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h2><i class="bi bi-speedometer2"></i> Dashboard Admin</h2>
        <p class="text-muted">Selamat datang, {{ auth()->user()->name }}</p>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalPesananHariIni }}</h4>
                        <p class="mb-0">Pesanan Hari Ini</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-calendar-day fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $pesananBaru }}</h4>
                        <p class="mb-0">Pesanan Baru</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-exclamation-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h4>
                        <p class="mb-0">Pendapatan Bulan Ini</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalPelanggan }}</h4>
                        <p class="mb-0">Total Pelanggan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Menu Cepat -->
<div class="row mb-4">
    <div class="col-12">
        <h4><i class="bi bi-lightning"></i> Menu Cepat</h4>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-box fs-1 text-primary"></i>
                <h5 class="mt-2">Kelola Paket</h5>
                <p class="text-muted">Tambah, edit, atau hapus paket laundry</p>
                <a href="{{ route('admin.paket.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right"></i> Buka
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-receipt fs-1 text-success"></i>
                <h5 class="mt-2">Kelola Transaksi</h5>
                <p class="text-muted">Proses pesanan dan update status</p>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-success">
                    <i class="bi bi-arrow-right"></i> Buka
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-people fs-1 text-info"></i>
                <h5 class="mt-2">Kelola Kurir</h5>
                <p class="text-muted">Tambah dan kelola data kurir</p>
                <a href="{{ route('admin.kurir.index') }}" class="btn btn-info">
                    <i class="bi bi-arrow-right"></i> Buka
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-clock-history fs-1 text-secondary"></i>
                <h5 class="mt-2">Riwayat & Laporan</h5>
                <p class="text-muted">Lihat riwayat dan cetak laporan</p>
                <a href="{{ route('admin.riwayat.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right"></i> Buka
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-check-circle fs-1 text-warning"></i>
                <h5 class="mt-2">Validasi Promo</h5>
                <p class="text-muted">Setujui atau tolak klaim promo</p>
                @php
                    $pendingClaims = \App\Models\PromoClaim::where('status', 'pending')->count();
                @endphp
                @if($pendingClaims > 0)
                    <div class="mb-2">
                        <span class="badge bg-danger fs-6">{{ $pendingClaims }} Menunggu</span>
                    </div>
                @endif
                <a href="{{ route('admin.promo-claim.index') }}" class="btn btn-warning">
                    <i class="bi bi-arrow-right"></i> Buka
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-clock-history"></i> Transaksi Terbaru</h5>
            </div>
            <div class="card-body">
                @if($transaksiTerbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Invoice</th>
                                    <th>Pelanggan</th>
                                    <th>Paket</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiTerbaru as $transaksi)
                                    <tr>
                                        <td>{{ $transaksi->kode_invoice }}</td>
                                        <td>{{ $transaksi->user->name }}</td>
                                        <td>
                                            @foreach($transaksi->detailTransaksis as $detail)
                                                {{ $detail->paket->nama_paket }}
                                                @if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($transaksi->status_transaksi === 'request_jemput')
                                                <span class="badge bg-warning">Menunggu Penjemputan</span>
                                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                                <span class="badge bg-info">Dijemput Kurir</span>
                                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                <span class="badge bg-primary">Sedang Dicuci</span>
                                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                                <span class="badge bg-success">Siap Diantar</span>
                                            @elseif($transaksi->status_transaksi === 'selesai')
                                                <span class="badge bg-dark">Selesai</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted">
                        <i class="bi bi-inbox fs-1"></i>
                        <p>Belum ada transaksi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection