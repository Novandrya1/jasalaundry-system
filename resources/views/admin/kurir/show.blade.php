@extends('layouts.app')

@section('title', 'Detail Kurir')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4><i class="bi bi-person"></i> Detail Kurir - {{ $kurir->name }}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-person-badge"></i> Informasi Kurir</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Nama:</strong></td>
                                        <td>{{ $kurir->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $kurir->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Telepon:</strong></td>
                                        <td>{{ $kurir->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat:</strong></td>
                                        <td>{{ $kurir->address }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bergabung:</strong></td>
                                        <td>{{ $kurir->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-bar-chart"></i> Statistik Tugas</h6>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h4 class="text-primary">{{ $kurir->transaksiKurir->count() }}</h4>
                                        <small>Total Tugas</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="text-success">{{ $kurir->transaksiKurir->where('status_transaksi', 'selesai')->count() }}</h4>
                                        <small>Selesai</small>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="text-warning">{{ $kurir->transaksiKurir->whereNotIn('status_transaksi', ['selesai'])->count() }}</h4>
                                        <small>Aktif</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Tugas -->
                <div class="row">
                    <div class="col-12">
                        <h6><i class="bi bi-clock-history"></i> Riwayat Tugas Terbaru</h6>
                        @if($kurir->transaksiKurir->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Pelanggan</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kurir->transaksiKurir as $transaksi)
                                            <tr>
                                                <td>{{ $transaksi->kode_invoice }}</td>
                                                <td>{{ $transaksi->user->name }}</td>
                                                <td>
                                                    @if($transaksi->status_transaksi === 'dijemput_kurir')
                                                        <span class="badge bg-info">Dijemput</span>
                                                    @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                        <span class="badge bg-primary">Proses</span>
                                                    @elseif($transaksi->status_transaksi === 'siap_antar')
                                                        <span class="badge bg-success">Siap Antar</span>
                                                    @elseif($transaksi->status_transaksi === 'selesai')
                                                        <span class="badge bg-dark">Selesai</span>
                                                    @endif
                                                </td>
                                                <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                                <td>{{ $transaksi->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="text-muted mt-2">Belum ada tugas yang ditugaskan</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('admin.kurir.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.kurir.edit', $kurir) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Kurir
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection