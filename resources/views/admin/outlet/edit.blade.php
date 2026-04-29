@extends('layouts.app')

@section('title', 'Edit Outlet')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-warning text-white">
                <h4><i class="bi bi-pencil"></i> Edit Outlet</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.outlet.update', $outlet) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_outlet" class="form-label">Nama Outlet</label>
                        <input type="text" class="form-control @error('nama_outlet') is-invalid @enderror" 
                               id="nama_outlet" name="nama_outlet" value="{{ old('nama_outlet', $outlet->nama_outlet) }}" required>
                        @error('nama_outlet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" required>{{ old('alamat', $outlet->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                               id="telepon" name="telepon" value="{{ old('telepon', $outlet->telepon) }}" required>
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   value="1" {{ old('is_active', $outlet->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Outlet Aktif
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.outlet.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Update Outlet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection