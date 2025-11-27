@extends('layouts.app')

@section('title', 'Pesan Laundry')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4><i class="bi bi-plus-circle"></i> Pesan Laundry</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pelanggan.order.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="paket_id" class="form-label">Pilih Paket Laundry</label>
                        <select class="form-select @error('paket_id') is-invalid @enderror" 
                                id="paket_id" name="paket_id" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach($pakets as $paket)
                                <option value="{{ $paket->id }}" {{ old('paket_id') == $paket->id ? 'selected' : '' }}>
                                    {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}/{{ $paket->satuan }}
                                </option>
                            @endforeach
                        </select>
                        @error('paket_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat_jemput" class="form-label">Alamat Penjemputan</label>
                        <textarea class="form-control @error('alamat_jemput') is-invalid @enderror" 
                                  id="alamat_jemput" name="alamat_jemput" rows="3" 
                                  placeholder="Masukkan alamat lengkap untuk penjemputan" required>{{ old('alamat_jemput', auth()->user()->address) }}</textarea>
                        @error('alamat_jemput')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan Khusus (Opsional)</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                  id="catatan" name="catatan" rows="2" 
                                  placeholder="Contoh: Jemput setelah jam 2 siang, pakaian anak terpisah, dll.">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kode_promo" class="form-label">Kode Promo (Opsional)</label>
                        <input type="text" class="form-control @error('kode_promo') is-invalid @enderror" 
                               id="kode_promo" name="kode_promo" value="{{ old('kode_promo') }}"
                               placeholder="Masukkan kode promo jika ada">
                        @error('kode_promo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Dapatkan kode promo dari carousel promo di dashboard</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metode_bayar" id="tunai" value="tunai" {{ old('metode_bayar', 'tunai') == 'tunai' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="tunai">
                                        <i class="bi bi-cash"></i> Bayar Tunai (COD)
                                    </label>
                                </div>
                                <small class="text-muted">Bayar saat pengantaran</small>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metode_bayar" id="transfer" value="transfer" {{ old('metode_bayar') == 'transfer' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="transfer">
                                        <i class="bi bi-bank"></i> Transfer Bank
                                    </label>
                                </div>
                                <small class="text-muted">Transfer setelah konfirmasi harga</small>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="bi bi-info-circle"></i> Informasi Penting:</h6>
                        <ul class="mb-0">
                            <li>Harga akan dihitung berdasarkan berat aktual setelah penimbangan</li>
                            <li>Kurir akan menghubungi Anda sebelum penjemputan</li>
                            <li>Pastikan alamat penjemputan sudah benar</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Konfirmasi Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection