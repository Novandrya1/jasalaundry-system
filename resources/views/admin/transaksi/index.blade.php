@extends('layouts.app')

@section('title', 'Kelola Transaksi')

@section('content')
<div class="row">
    <div class="col-12">
        <h2><i class="bi bi-receipt"></i> Kelola Transaksi</h2>
        <p class="text-muted">Proses dan kelola semua transaksi laundry</p>
    </div>
</div>

<!-- Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.transaksi.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="status" class="form-label">Filter Status</label>
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
                        <div class="col-md-4">
                            <label for="tanggal" class="form-label">Filter Tanggal</label>
                            <input type="date" class="form-select" id="tanggal" name="tanggal" value="{{ request('tanggal') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2 d-md-flex">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
                                    <th>Kode Invoice</th>
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
                                        <td>
                                            <strong>{{ $transaksi->kode_invoice }}</strong>
                                        </td>
                                        <td>
                                            {{ $transaksi->user->name }}<br>
                                            <small class="text-muted">{{ $transaksi->user->phone }}</small>
                                        </td>
                                        <td>
                                            @foreach($transaksi->detailTransaksis as $detail)
                                                {{ $detail->paket->nama_paket }}
                                                @if(!$loop->last)<br>@endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($transaksi->berat_aktual)
                                                <span class="badge bg-info">{{ $transaksi->berat_aktual }} kg</span>
                                            @else
                                                <span class="text-muted">Belum ditimbang</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaksi->diskon > 0)
                                                <div>
                                                    <small class="text-muted text-decoration-line-through">
                                                        Rp {{ number_format($transaksi->total_harga + $transaksi->diskon, 0, ',', '.') }}
                                                    </small>
                                                </div>
                                                <div class="text-danger small">
                                                    Diskon: -Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}
                                                </div>
                                            @endif
                                            <strong class="text-success">
                                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                            </strong>
                                            @if($transaksi->promoClaim)
                                                <br><small class="badge bg-secondary">{{ $transaksi->promoClaim->kode_promo }}</small>
                                            @endif
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
                                            <br>
                                            @if($transaksi->status_bayar === 'belum_bayar')
                                                <span class="badge bg-danger">Belum Bayar</span>
                                            @else
                                                <span class="badge bg-success">Lunas</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaksi->kurir)
                                                {{ $transaksi->kurir->name }}
                                            @else
                                                <span class="text-muted">Belum ditugaskan</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $transaksi->created_at->format('d/m/Y') }}<br>
                                            <small class="text-muted">{{ $transaksi->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.transaksi.show', $transaksi) }}" 
                                                   class="btn btn-info btn-sm" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.transaksi.edit', $transaksi) }}" 
                                                   class="btn btn-warning btn-sm" title="Proses">
                                                    <i class="bi bi-pencil"></i>
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
                        <h5 class="text-muted mt-2">Belum ada transaksi</h5>
                        <p class="text-muted">Transaksi akan muncul di sini setelah pelanggan melakukan pemesanan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection