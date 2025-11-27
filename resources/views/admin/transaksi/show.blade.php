@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4><i class="bi bi-receipt"></i> Detail Transaksi - {{ $transaksi->kode_invoice }}</h4>
            </div>
            <div class="card-body">
                <!-- Status dan Info Utama -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h5>{{ $transaksi->kode_invoice }}</h5>
                        <p class="text-muted mb-0">Dibuat: {{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                        @if($transaksi->tanggal_jemput)
                            <p class="text-muted mb-0">Dijemput: {{ $transaksi->tanggal_jemput->format('d/m/Y H:i') }}</p>
                        @endif
                        @if($transaksi->tanggal_selesai)
                            <p class="text-muted mb-0">Selesai: {{ $transaksi->tanggal_selesai->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="mb-2">
                            @if($transaksi->status_transaksi === 'request_jemput')
                                <span class="badge bg-warning fs-6">Menunggu Penjemputan</span>
                            @elseif($transaksi->status_transaksi === 'dijemput_kurir')
                                <span class="badge bg-info fs-6">Dijemput Kurir</span>
                            @elseif($transaksi->status_transaksi === 'proses_cuci')
                                <span class="badge bg-primary fs-6">Sedang Dicuci</span>
                            @elseif($transaksi->status_transaksi === 'siap_antar')
                                <span class="badge bg-success fs-6">Siap Diantar</span>
                            @elseif($transaksi->status_transaksi === 'selesai')
                                <span class="badge bg-dark fs-6">Selesai</span>
                            @endif
                        </div>
                        <div>
                            @if($transaksi->status_bayar === 'belum_bayar')
                                <span class="badge bg-danger fs-6">Belum Bayar</span>
                            @else
                                <span class="badge bg-success fs-6">Lunas</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Pelanggan dan Kurir -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-person"></i> Informasi Pelanggan</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Nama:</strong></td>
                                        <td>{{ $transaksi->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $transaksi->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Telepon:</strong></td>
                                        <td>{{ $transaksi->user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat:</strong></td>
                                        <td>{{ $transaksi->user->address }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-truck"></i> Informasi Kurir</h6>
                                @if($transaksi->kurir)
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td><strong>Nama:</strong></td>
                                            <td>{{ $transaksi->kurir->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Telepon:</strong></td>
                                            <td>{{ $transaksi->kurir->phone }}</td>
                                        </tr>
                                    </table>
                                @else
                                    <p class="text-muted">Belum ada kurir yang ditugaskan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat Jemput dan Catatan -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-geo-alt"></i> Alamat Penjemputan</h6>
                                <p>{{ $transaksi->alamat_jemput }}</p>
                                
                                @if($transaksi->catatan)
                                    <h6><i class="bi bi-chat-text"></i> Catatan Khusus</h6>
                                    <p>{{ $transaksi->catatan }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Paket dan Harga -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6><i class="bi bi-box"></i> Detail Paket & Harga</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Paket</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksi->detailTransaksis as $detail)
                                        <tr>
                                            <td>
                                                <strong>{{ $detail->paket->nama_paket }}</strong><br>
                                                <small class="text-muted">{{ $detail->paket->deskripsi }}</small>
                                            </td>
                                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}/{{ $detail->paket->satuan }}</td>
                                            <td>{{ $detail->jumlah }} {{ $detail->paket->satuan }}</td>
                                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="3" class="text-end">Subtotal:</th>
                                        <th>Rp {{ number_format($transaksi->detailTransaksis->sum('subtotal'), 0, ',', '.') }}</th>
                                    </tr>
                                    @if($transaksi->diskon > 0)
                                        <tr>
                                            <th colspan="3" class="text-end">Diskon 
                                                @if($transaksi->promoClaim)
                                                    ({{ $transaksi->promoClaim->kode_promo }}):
                                                @else
                                                    :
                                                @endif
                                            </th>
                                            <th class="text-danger">-Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</th>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th colspan="3" class="text-end">Total Harga:</th>
                                        <th>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Informasi Berat -->
                @if($transaksi->berat_aktual)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6><i class="bi bi-scale"></i> Informasi Penimbangan</h6>
                                <p class="mb-0">
                                    <strong>Berat Aktual:</strong> {{ $transaksi->berat_aktual }} kg<br>
                                    <strong>Harga per kg:</strong> Rp {{ number_format($transaksi->detailTransaksis->first()->harga_satuan, 0, ',', '.') }}<br>
                                    <strong>Total Kalkulasi:</strong> {{ $transaksi->berat_aktual }} kg × Rp {{ number_format($transaksi->detailTransaksis->first()->harga_satuan, 0, ',', '.') }} = Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Tombol Aksi -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.transaksi.edit', $transaksi) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Proses Transaksi
                    </a>
                    <button class="btn btn-success" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection