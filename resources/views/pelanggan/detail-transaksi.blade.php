@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="bi bi-receipt"></i> Detail Transaksi</h2>
            <a href="{{ route('pelanggan.riwayat') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-8">
        <div class="card shadow mobile-card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <strong>Kode Invoice:</strong><br>
                        <span class="text-primary">{{ $transaksi->kode_invoice }}</span>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <strong>Tanggal Pesanan:</strong><br>
                        {{ $transaksi->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Alamat Penjemputan:</strong><br>
                        {{ $transaksi->alamat_jemput }}
                    </div>
                    @if($transaksi->catatan)
                        <div class="col-12 mb-3">
                            <strong>Catatan:</strong><br>
                            {{ $transaksi->catatan }}
                        </div>
                    @endif
                    <div class="col-12 col-md-6 mb-3">
                        <strong>Metode Pembayaran:</strong><br>
                        @if($transaksi->metode_bayar === 'tunai')
                            <span class="badge bg-info">Tunai (COD)</span>
                        @elseif($transaksi->metode_bayar === 'qris')
                            <span class="badge bg-success">QRIS</span>
                        @else
                            <span class="badge bg-warning">Transfer Bank</span>
                        @endif
                    </div>
                    @if($transaksi->kurir)
                        <div class="col-12 col-md-6 mb-3">
                            <strong>Kurir:</strong><br>
                            {{ $transaksi->kurir->name }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card shadow mt-3 mobile-card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-box"></i> Detail Paket</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Paket</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->detailTransaksis as $detail)
                                <tr>
                                    <td>{{ $detail->paket->nama_paket }}</td>
                                    <td>{{ $detail->jumlah }} {{ $detail->paket->satuan }}</td>
                                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @if($transaksi->diskon > 0)
                                <tr>
                                    <td colspan="3"><strong>Subtotal:</strong></td>
                                    <td><strong>Rp {{ number_format($transaksi->total_harga + $transaksi->diskon, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr class="text-danger">
                                    <td colspan="3"><strong>Diskon:</strong></td>
                                    <td><strong>-Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</strong></td>
                                </tr>
                            @endif
                            <tr class="table-success">
                                <td colspan="3"><strong>Total:</strong></td>
                                <td><strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                @if($transaksi->promoClaim)
                    <div class="alert alert-info mt-2">
                        <i class="bi bi-gift"></i> <strong>Promo Digunakan:</strong> {{ $transaksi->promoClaim->kode_promo }}
                        <br><small>{{ $transaksi->promoClaim->promo->judul }}</small>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 mt-3 mt-lg-0">
        <div class="card shadow mobile-card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Status Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item {{ $transaksi->status_transaksi === 'request_jemput' ? 'active' : ($transaksi->created_at ? 'completed' : '') }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Pesanan Dibuat</h6>
                            <small>{{ $transaksi->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $transaksi->status_transaksi === 'dijemput_kurir' ? 'active' : (in_array($transaksi->status_transaksi, ['proses_cuci', 'siap_antar', 'selesai']) ? 'completed' : '') }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Dijemput Kurir</h6>
                            @if($transaksi->tanggal_jemput)
                                <small>{{ $transaksi->tanggal_jemput->format('d/m/Y H:i') }}</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $transaksi->status_transaksi === 'proses_cuci' ? 'active' : (in_array($transaksi->status_transaksi, ['siap_antar', 'selesai']) ? 'completed' : '') }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Proses Cuci</h6>
                            @if($transaksi->tanggal_proses_cuci)
                                <small>{{ $transaksi->tanggal_proses_cuci->format('d/m/Y H:i') }}</small><br>
                            @endif
                            @if($transaksi->berat_aktual)
                                @php
                                    $paket = $transaksi->detailTransaksis->first()->paket;
                                    $labelText = $paket->satuan === 'kg' ? 'Berat' : 'Jumlah';
                                @endphp
                                <small>{{ $labelText }}: {{ $transaksi->berat_aktual }} {{ $paket->satuan }}</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $transaksi->status_transaksi === 'siap_antar' ? 'active' : ($transaksi->status_transaksi === 'selesai' ? 'completed' : '') }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Siap Diantar</h6>
                            @if($transaksi->tanggal_siap_antar)
                                <small>{{ $transaksi->tanggal_siap_antar->format('d/m/Y H:i') }}</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="timeline-item {{ $transaksi->status_transaksi === 'selesai' ? 'completed' : '' }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h6>Selesai</h6>
                            @if($transaksi->tanggal_selesai)
                                <small>{{ $transaksi->tanggal_selesai->format('d/m/Y H:i') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3 mobile-card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-credit-card"></i> Status Pembayaran</h5>
            </div>
            <div class="card-body text-center">
                @if($transaksi->status_bayar === 'belum_bayar')
                    <span class="badge bg-danger fs-6 mb-2">Belum Bayar</span>
                    @if($transaksi->metode_bayar === 'qris' && $transaksi->payment_url)
                        <div class="alert alert-info">
                            <small>Link pembayaran QRIS telah dikirim via WhatsApp</small>
                            <br>
                            <a href="{{ $transaksi->payment_url }}" target="_blank" class="btn btn-success btn-sm mt-2">
                                <i class="bi bi-qr-code"></i> Bayar Sekarang
                            </a>
                        </div>
                    @elseif($transaksi->metode_bayar === 'transfer')
                        <div class="alert alert-warning">
                            <small>Silakan transfer ke rekening yang telah diberikan dan kirim bukti transfer ke admin.</small>
                        </div>
                    @endif
                @else
                    <span class="badge bg-success fs-6 mb-2">Lunas</span>
                    @if($transaksi->paid_at)
                        <br><small class="text-muted">Dibayar: {{ $transaksi->paid_at->format('d/m/Y H:i') }}</small>
                    @endif
                @endif
                
                <div class="mt-2">
                    <strong class="text-success fs-5">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #dee2e6;
    border: 2px solid #fff;
}

.timeline-item.active .timeline-marker {
    background: #ffc107;
}

.timeline-item.completed .timeline-marker {
    background: #28a745;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-size: 0.9rem;
}

.timeline-content small {
    color: #6c757d;
}
</style>
@endsection