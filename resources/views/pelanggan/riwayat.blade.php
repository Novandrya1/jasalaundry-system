@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="row">
    <div class="col-12">
        <h2><i class="bi bi-clock-history"></i> Riwayat Pesanan Saya</h2>
        <p class="text-muted">Lihat semua pesanan laundry Anda</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @forelse($transaksis as $transaksi)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <i class="bi bi-receipt"></i> {{ $transaksi->kode_invoice }}
                            </h5>
                            <p class="card-text">
                                <strong>Tanggal:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}<br>
                                <strong>Alamat Jemput:</strong> {{ $transaksi->alamat_jemput }}<br>
                                @if($transaksi->catatan)
                                    <strong>Catatan:</strong> {{ $transaksi->catatan }}<br>
                                @endif
                                <strong>Paket:</strong> 
                                @foreach($transaksi->detailTransaksis as $detail)
                                    {{ $detail->paket->nama_paket }}
                                    @if(!$loop->last), @endif
                                @endforeach
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="mb-2">
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
                            </div>
                            <div class="mb-2">
                                @if($transaksi->status_bayar === 'belum_bayar')
                                    <span class="badge bg-danger">Belum Bayar</span>
                                @else
                                    <span class="badge bg-success">Lunas</span>
                                @endif
                            </div>
                            <div>
                                @if($transaksi->berat_aktual)
                                    <strong>Berat:</strong> {{ $transaksi->berat_aktual }} kg<br>
                                @endif
                                <strong class="text-success">Total: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                    
                    @if($transaksi->kurir)
                        <div class="row mt-2">
                            <div class="col-12">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i> Kurir: {{ $transaksi->kurir->name }}
                                </small>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('pelanggan.transaksi.show', $transaksi) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Anda belum memiliki riwayat pesanan.
                <br>
                <a href="{{ route('pelanggan.order') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Pesan Sekarang
                </a>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($transaksis->hasPages())
            <div class="d-flex justify-content-center">
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection