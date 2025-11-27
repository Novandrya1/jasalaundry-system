@extends('layouts.app')

@section('title', 'Tambah Paket')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4><i class="bi bi-plus-circle"></i> Tambah Paket Laundry</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.paket.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_paket" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" 
                               id="nama_paket" name="nama_paket" value="{{ old('nama_paket') }}" 
                               placeholder="Contoh: Cuci Kering, Cuci Setrika" required>
                        @error('nama_paket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga_per_kg" class="form-label">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('harga_per_kg') is-invalid @enderror" 
                                           id="harga_per_kg" name="harga_per_kg" value="{{ old('harga_per_kg') }}" 
                                           placeholder="5000" min="0" step="100" required>
                                    @error('harga_per_kg')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <select class="form-select @error('satuan') is-invalid @enderror" 
                                        id="satuan" name="satuan" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                    <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                </select>
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3" 
                                  placeholder="Jelaskan detail layanan paket ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Paket Aktif (dapat dipilih pelanggan)
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan Paket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection