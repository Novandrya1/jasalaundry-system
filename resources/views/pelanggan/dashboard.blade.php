@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="row">
    <div class="col-12">
        <h2><i class="bi bi-house"></i> Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="text-muted">Pilih paket laundry yang Anda inginkan</p>
    </div>
</div>

<!-- Promo Carousel -->
@if($promos && $promos->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-inner">
                @foreach($promos as $index => $promo)
                    @php
                        $gradients = [
                            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)'
                        ];
                        $gradient = $gradients[$index % count($gradients)];
                    @endphp
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="card position-relative" style="background: {{ $gradient }}; border: none; border-radius: 15px; overflow: hidden;">
                            <div class="card-body text-white p-3 p-md-4" style="min-height: 120px;">
                                <div class="row h-100">
                                    <div class="col-9 col-sm-9">
                                        <h3 class="mb-1 mb-md-2 h5 h-md-4 h-lg-3"><i class="bi bi-gift"></i> {{ $promo->judul }}</h3>
                                        <p class="mb-1 mb-md-2 small d-none d-sm-block">{{ $promo->deskripsi }}</p>
                                        <div class="mb-1 mb-md-2">
                                            <span class="badge bg-white text-dark px-2 py-1 small">
                                                <i class="bi bi-percent"></i> Diskon {{ $promo->diskon_text }}
                                            </span>
                                        </div>
                                        <small class="opacity-75 d-block">
                                            <i class="bi bi-calendar"></i> <span class="d-none d-sm-inline">Berlaku sampai</span> {{ $promo->tanggal_selesai->format('d M Y') }}
                                        </small>
                                    </div>
                                    <div class="col-3 col-sm-3 d-flex align-items-center justify-content-center">
                                        <button class="btn btn-light shadow btn-sm" onclick="klaimPromo({{ $promo->id }})" 
                                                style="font-weight: 600; font-size: 0.75rem;">
                                            <i class="bi bi-hand-thumbs-up"></i> <span class="d-none d-md-inline">Klaim</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('pelanggan.order') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Pesan Laundry Sekarang
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h4><i class="bi bi-box"></i> Paket Laundry Tersedia</h4>
    </div>
</div>

<div class="row">
    @forelse($pakets as $paket)
        <div class="col-6 col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm mobile-card">
                <div class="card-body">
                    <h5 class="card-title text-primary h6 h-md-5">
                        <i class="bi bi-box"></i> {{ $paket->nama_paket }}
                    </h5>
                    <p class="card-text small d-none d-md-block">{{ $paket->deskripsi }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h6 h-md-5 text-success mb-0">
                            Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}
                        </span>
                        <small class="text-muted">per {{ $paket->satuan }}</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('pelanggan.order') }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-cart-plus"></i> <span class="d-none d-sm-inline">Pilih Paket</span><span class="d-sm-none">Pilih</span>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Belum ada paket laundry tersedia.
            </div>
        </div>
    @endforelse
</div>

<!-- Informasi Layanan -->
<div class="row mt-5">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="text-primary"><i class="bi bi-info-circle"></i> Cara Pemesanan</h5>
                <ol class="mb-0">
                    <li>Klik "Pesan Laundry Sekarang"</li>
                    <li>Pilih paket dan metode pembayaran</li>
                    <li>Isi alamat penjemputan</li>
                    <li>Konfirmasi pesanan</li>
                    <li>Tunggu kurir menjemput</li>
                </ol>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="text-success"><i class="bi bi-clock"></i> Jam Operasional</h5>
                <ul class="list-unstyled mb-0">
                    <li><strong>Senin - Jumat:</strong> 08:00 - 20:00</li>
                    <li><strong>Sabtu:</strong> 08:00 - 18:00</li>
                    <li><strong>Minggu:</strong> 09:00 - 17:00</li>
                    <li class="mt-2"><small class="text-muted">Penjemputan & pengantaran sesuai jadwal</small></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-warning">
            <div class="card-body">
                <h5 class="text-warning"><i class="bi bi-exclamation-triangle"></i> Barang yang Tidak Diterima</h5>
                <ul class="mb-0">
                    <li>Pakaian dalam (celana dalam, bra)</li>
                    <li>Barang kulit dan suede</li>
                    <li>Pakaian dengan noda cat/oli berat</li>
                    <li>Barang berharga (perhiasan, uang)</li>
                    <li>Pakaian rusak/sobek parah</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card border-info">
            <div class="card-body">
                <h5 class="text-info"><i class="bi bi-shield-check"></i> Jaminan Layanan</h5>
                <ul class="mb-0">
                    <li>Garansi hilang/rusak 100%</li>
                    <li>Deterjen berkualitas premium</li>
                    <li>Proses cuci higienis & aman</li>
                    <li>Packing rapi & wangi</li>
                    <li>Layanan pelanggan 24/7</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Tentang JasaLaundry -->
<div class="row">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h4><i class="bi bi-droplet-half"></i> Tentang JasaLaundry</h4>
                <p class="mb-0">JasaLaundry adalah layanan laundry antar-jemput terpercaya dengan pengalaman lebih dari 5 tahun. Kami menggunakan teknologi modern dan deterjen berkualitas untuk memberikan hasil terbaik. Dengan tim kurir profesional dan sistem tracking real-time, kepuasan pelanggan adalah prioritas utama kami.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function klaimPromo(promoId) {
    if (confirm('Yakin ingin mengklaim promo ini? Anda akan mendapat kode promo setelah disetujui admin.')) {
        fetch('/klaim-promo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ promo_id: promoId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Promo berhasil diklaim! Admin akan memvalidasi dan mengirim kode promo via WhatsApp.');
                location.reload();
            } else {
                alert(data.message || 'Gagal mengklaim promo.');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    }
}
</script>
@endsection