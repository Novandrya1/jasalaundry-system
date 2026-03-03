@extends('layouts.app')

@section('title', 'Tambah Outlet')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4><i class="bi bi-plus-circle"></i> Tambah Outlet Baru</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.outlet.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_outlet" class="form-label">Nama Outlet</label>
                        <input type="text" class="form-control @error('nama_outlet') is-invalid @enderror" 
                               id="nama_outlet" name="nama_outlet" value="{{ old('nama_outlet') }}" required>
                        @error('nama_outlet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                   id="telepon" name="telepon" value="{{ old('telepon') }}" 
                                   placeholder="08123456789" required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email (Opsional)</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jam_buka" class="form-label">Jam Buka</label>
                            <input type="time" class="form-control @error('jam_buka') is-invalid @enderror" 
                                   id="jam_buka" name="jam_buka" value="{{ old('jam_buka', '08:00') }}" required>
                            @error('jam_buka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jam_tutup" class="form-label">Jam Tutup</label>
                            <input type="time" class="form-control @error('jam_tutup') is-invalid @enderror" 
                                   id="jam_tutup" name="jam_tutup" value="{{ old('jam_tutup', '20:00') }}" required>
                            @error('jam_tutup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="maps_url" class="form-label">Link Google Maps (Opsional)</label>
                        <input type="url" class="form-control @error('maps_url') is-invalid @enderror" 
                               id="maps_url" name="maps_url" value="{{ old('maps_url') }}"
                               placeholder="https://maps.google.com/...">
                        @error('maps_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Paste link Google Maps untuk memudahkan pelanggan menemukan lokasi</small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.outlet.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Simpan Outlet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection