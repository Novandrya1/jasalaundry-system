@extends('layouts.app')

@section('title', 'Kelola Outlet')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="bi bi-shop"></i> Kelola Outlet</h2>
                <p class="text-muted">Kelola lokasi outlet laundry</p>
            </div>
            <a href="{{ route('admin.outlet.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Outlet
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                @if($outlets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Outlet</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Jam Operasional</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($outlets as $outlet)
                                    <tr>
                                        <td><strong>{{ $outlet->nama_outlet }}</strong></td>
                                        <td>{{ Str::limit($outlet->alamat, 50) }}</td>
                                        <td>{{ $outlet->telepon }}</td>
                                        <td>{{ $outlet->jam_buka }} - {{ $outlet->jam_tutup }}</td>
                                        <td>
                                            @if($outlet->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.outlet.edit', $outlet) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.outlet.destroy', $outlet) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Hapus outlet ini?')" title="Hapus">
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

                    @if($outlets->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $outlets->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-shop fs-1 text-muted"></i>
                        <h5 class="text-muted mt-2">Belum ada outlet</h5>
                        <p class="text-muted">Tambahkan outlet pertama Anda</p>
                        <a href="{{ route('admin.outlet.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Outlet
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection