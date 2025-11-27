@extends('layouts.app')

@section('title', 'Detail Paket')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h4><i class="bi bi-eye"></i> Detail Paket Laundry</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-primary">{{ $paket->nama_paket }}</h5>
                        <p class="text-muted mb-3">{{ $paket->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="mb-2">
                            @if($paket->is_active)
                                <span class="badge bg-success fs-6">Paket Aktif</span>
                            @else
                                <span class="badge bg-secondary fs-6">Paket Nonaktif</span>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <i class="bi bi-currency-dollar fs-1 text-success"></i>
                                <h4 class="text-success mt-2">Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}</h4>
                                <p class="text-muted mb-0">per {{ $paket->satuan }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-info-circle"></i> Informasi Paket</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Satuan:</strong></td>
                                        <td>
                                            <span class="badge bg-info">{{ strtoupper($paket->satuan) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            @if($paket->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dibuat:</strong></td>
                                        <td>{{ $paket->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diperbarui:</strong></td>
                                        <td>{{ $paket->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.paket.edit', $paket) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Paket
                    </a>
                    <form action="{{ route('admin.paket.destroy', $paket) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus Paket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection