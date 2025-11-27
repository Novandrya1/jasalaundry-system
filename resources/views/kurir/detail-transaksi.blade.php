@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="bi bi-clipboard-check"></i> Detail Tugas</h2>
            <a href="{{ route('kurir.tugas') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-8">
        <div class="card shadow mobile-card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Pelanggan</h5>
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
                    <div class="col-12 col-md-6 mb-3">
                        <strong>Nama Pelanggan:</strong><br>
                        {{ $transaksi->user->name }}
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <strong>Telepon:</strong><br>
                        <a href="tel:{{ $transaksi->user->phone }}" class="text-decoration-none">
                            <i class="bi bi-telephone"></i> {{ $transaksi->user->phone }}
                        </a>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Alamat Penjemputan/Pengantaran:</strong><br>
                        {{ $transaksi->alamat_jemput }}
                        <br>
                        <a href="https://maps.google.com/?q={{ urlencode($transaksi->alamat_jemput) }}" 
                           target="_blank" class="btn btn-outline-info btn-sm mt-2">
                            <i class="bi bi-geo-alt"></i> Buka di Maps
                        </a>
                    </div>
                    @if($transaksi->catatan)
                        <div class="col-12 mb-3">
                            <strong>Catatan Khusus:</strong><br>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> {{ $transaksi->catatan }}
                            </div>
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
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 mt-3 mt-lg-0">
        <div class="card shadow mobile-card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Status Tugas</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item completed">
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
                <h5 class="mb-0"><i class="bi bi-tools"></i> Aksi Kurir</h5>
            </div>
            <div class="card-body">
                @if($transaksi->status_transaksi === 'siap_antar')
                    <form method="POST" action="{{ route('kurir.transaksi.status', $transaksi) }}" class="mb-3">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status_transaksi" value="selesai">
                        <button type="submit" class="btn btn-success w-100" 
                                onclick="return confirm('Konfirmasi pengantaran selesai?')">
                            <i class="bi bi-check-circle"></i> Selesai Antar
                        </button>
                    </form>
                @elseif($transaksi->status_transaksi === 'selesai')
                    <div class="alert alert-success text-center">
                        <i class="bi bi-check-circle"></i> Pengantaran Selesai
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle"></i> Menunggu proses dari admin
                    </div>
                @endif
                
                @php
                    $cleanPhone = preg_replace('/[^0-9]/', '', $transaksi->user->phone);
                    if (substr($cleanPhone, 0, 1) === '0') {
                        $cleanPhone = '62' . substr($cleanPhone, 1);
                    }
                    $message = "Halo {$transaksi->user->name}, saya kurir dari JasaLaundry untuk pesanan {$transaksi->kode_invoice}. ";
                    if($transaksi->status_transaksi === 'dijemput_kurir') {
                        $message .= "Saya akan datang untuk menjemput laundry Anda di {$transaksi->alamat_jemput}";
                    } elseif($transaksi->status_transaksi === 'siap_antar') {
                        $message .= "Laundry Anda sudah selesai, saya akan datang untuk mengantarkan ke {$transaksi->alamat_jemput}";
                    } else {
                        $message .= "Untuk update pesanan laundry Anda";
                    }
                @endphp
                
                <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($message) }}" 
                   target="_blank" class="btn btn-success w-100">
                    <i class="bi bi-whatsapp"></i> WhatsApp Pelanggan
                </a>
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