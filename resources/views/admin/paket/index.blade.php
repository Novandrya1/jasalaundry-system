@extends('layouts.app')

@section('title', 'Kelola Paket')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="bi bi-box"></i> Kelola Paket Laundry</h2>
            <a href="{{ route('admin.paket.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Paket
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                @if($pakets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Paket</th>
                                    <th>Harga</th>
                                    <th>Satuan</th>
                                    <th>Status</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pakets as $index => $paket)
                                    <tr>
                                        <td>{{ $pakets->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $paket->nama_paket }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-success fw-bold">
                                                Rp {{ number_format($paket->harga_per_kg, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $paket->satuan }}</span>
                                        </td>
                                        <td>
                                            @if($paket->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ Str::limit($paket->deskripsi, 50) }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.paket.show', $paket) }}" 
                                                   class="btn btn-info btn-sm" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.paket.edit', $paket) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.paket.destroy', $paket) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($pakets->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pakets->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <h5 class="text-muted mt-2">Belum ada paket laundry</h5>
                        <p class="text-muted">Tambahkan paket laundry pertama Anda</p>
                        <a href="{{ route('admin.paket.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Paket
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection