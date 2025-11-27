@extends('layouts.app')

@section('title', 'Tugas Kurir')

@section('content')
<div class="row">
    <div class="col-12">
        <h2><i class="bi bi-list-task"></i> Tugas Saya</h2>
        <p class="text-muted">Kelola semua tugas pengiriman Anda</p>
    </div>
</div>

<!-- Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('kurir.tugas') }}">
                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <label for="status" class="form-label">Filter Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="dijemput_kurir" {{ request('status') == 'dijemput_kurir' ? 'selected' : '' }}>
                                    Tugas Baru
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
                            <div class="d-grid gap-2 d-md-flex">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                                <a href="{{ route('kurir.tugas') }}" class="btn btn-secondary">
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

<!-- Daftar Tugas -->
<div class="row">
    <div class="col-12">
        @if($transaksis->count() > 0)
            @foreach($transaksis as $transaksi)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0 h6 h-md-5">{{ $transaksi->kode_invoice }}</h5>
                                    @if($transaksi->status_transaksi === 'dijemput_kurir')
                                        <span class="badge bg-warning">Tugas Baru</span>
                                    @elseif($transaksi->status_transaksi === 'proses_cuci')
                                        <span class="badge bg-primary">Sedang Dicuci</span>
                                    @elseif($transaksi->status_transaksi === 'siap_antar')
                                        <span class="badge bg-success">Siap Diantar</span>
                                    @elseif($transaksi->status_transaksi === 'selesai')
                                        <span class="badge bg-dark">Selesai</span>
                                    @endif
                                </div>
                                
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="mb-2">
                                            <strong><i class="bi bi-person"></i> {{ $transaksi->user->name }}</strong><br>
                                            <small class="text-muted"><i class="bi bi-telephone"></i> {{ $transaksi->user->phone }}</small>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <strong><i class="bi bi-geo-alt"></i> Alamat:</strong><br>
                                            <span class="small">{{ $transaksi->alamat_jemput }}</span>
                                        </div>
                                        
                                        @if($transaksi->catatan)
                                            <div class="mb-2">
                                                <strong><i class="bi bi-chat-text"></i> Catatan:</strong><br>
                                                <span class="text-muted small">{{ $transaksi->catatan }}</span>
                                            </div>
                                        @endif
                                        
                                        <div class="mb-2">
                                            <strong><i class="bi bi-box"></i> Paket:</strong>
                                            @foreach($transaksi->detailTransaksis as $detail)
                                                <span class="badge bg-info">{{ $detail->paket->nama_paket }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-4">
                                        <div class="text-start text-md-end">
                                            <div class="mb-2">
                                                <small class="text-muted">Dibuat: {{ $transaksi->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            
                                            @if($transaksi->berat_aktual)
                                                <div class="mb-2">
                                                    <strong>Berat: {{ $transaksi->berat_aktual }} kg</strong><br>
                                                    <strong class="text-success">Total: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
                                                </div>
                                            @endif
                                            
                                            <!-- Tombol Aksi -->
                                            <div class="mt-3">
                                                @if($transaksi->status_transaksi === 'dijemput_kurir')
                                                    <small class="d-block text-muted mb-2">Status: Sudah dijemput, menunggu proses cuci</small>
                                                @elseif($transaksi->status_transaksi === 'proses_cuci')
                                                    <small class="d-block text-muted mb-2">Status: Sedang dicuci</small>
                                                @elseif($transaksi->status_transaksi === 'siap_antar')
                                                    <form method="POST" action="{{ route('kurir.transaksi.status', $transaksi) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status_transaksi" value="selesai">
                                                        <button type="submit" class="btn btn-success btn-sm w-100" 
                                                                onclick="return confirm('Konfirmasi pengantaran selesai?')">
                                                            <i class="bi bi-check-circle"></i> Selesai Antar
                                                        </button>
                                                    </form>
                                                @elseif($transaksi->status_transaksi === 'selesai')
                                                    <span class="badge bg-success">✓ Pengantaran Selesai</span>
                                                @endif
                                                
                                                <!-- Tombol WhatsApp -->
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
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <a href="{{ route('kurir.transaksi.show', $transaksi) }}" class="btn btn-outline-primary btn-sm w-100">
                                                            <i class="bi bi-eye"></i> <span class="d-none d-lg-inline">Detail</span>
                                                        </a>
                                                    </div>
                                                    <div class="col-4">
                                                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($message) }}" 
                                                           target="_blank" class="btn btn-outline-success btn-sm w-100">
                                                            <i class="bi bi-whatsapp"></i> <span class="d-none d-lg-inline">WA</span>
                                                        </a>
                                                    </div>
                                                    <div class="col-4">
                                                        <a href="https://maps.google.com/?q={{ urlencode($transaksi->alamat_jemput) }}" 
                                                           target="_blank" class="btn btn-outline-info btn-sm w-100">
                                                            <i class="bi bi-geo-alt"></i> <span class="d-none d-lg-inline">Maps</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Pagination -->
            @if($transaksis->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $transaksis->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <h5 class="text-muted mt-2">Belum ada tugas</h5>
                    <p class="text-muted">Tugas akan muncul di sini setelah admin menugaskan Anda</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection