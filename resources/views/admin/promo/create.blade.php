@extends('layouts.app')

@section('title', 'Tambah Promo')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4><i class="bi bi-plus-circle"></i> Tambah Promo Baru</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.promo.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Promo</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" name="judul" value="{{ old('judul') }}" 
                               placeholder="Contoh: Diskon 20% Pelanggan Baru" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Promo</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4" 
                                  placeholder="Jelaskan detail promo, syarat dan ketentuan..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tipe_diskon" class="form-label">Tipe Diskon</label>
                                <select class="form-select @error('tipe_diskon') is-invalid @enderror" 
                                        id="tipe_diskon" name="tipe_diskon" required>
                                    <option value="persen" {{ old('tipe_diskon') == 'persen' ? 'selected' : '' }}>Persentase (%)</option>
                                    <option value="nominal" {{ old('tipe_diskon') == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                                </select>
                                @error('tipe_diskon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="diskon_persen" class="form-label">Diskon Persen (%)</label>
                                <input type="number" class="form-control @error('diskon_persen') is-invalid @enderror" 
                                       id="diskon_persen" name="diskon_persen" value="{{ old('diskon_persen', 0) }}" 
                                       min="0" max="100" step="0.01">
                                @error('diskon_persen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="diskon_nominal" class="form-label">Diskon Nominal (Rp)</label>
                                <input type="number" class="form-control @error('diskon_nominal') is-invalid @enderror" 
                                       id="diskon_nominal" name="diskon_nominal" value="{{ old('diskon_nominal', 0) }}" 
                                       min="0" step="100">
                                @error('diskon_nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                       id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                       id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Promo Aktif (tampil di dashboard pelanggan)
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.promo.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan Promo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipeDiskon = document.getElementById('tipe_diskon');
    const diskonPersen = document.getElementById('diskon_persen');
    const diskonNominal = document.getElementById('diskon_nominal');
    
    function toggleDiskonFields() {
        if (tipeDiskon.value === 'persen') {
            diskonPersen.disabled = false;
            diskonNominal.disabled = true;
            diskonNominal.value = 0;
        } else {
            diskonPersen.disabled = true;
            diskonPersen.value = 0;
            diskonNominal.disabled = false;
        }
    }
    
    // Initial setup
    toggleDiskonFields();
    
    // Listen for changes
    tipeDiskon.addEventListener('change', toggleDiskonFields);
});
</script>
@endsection