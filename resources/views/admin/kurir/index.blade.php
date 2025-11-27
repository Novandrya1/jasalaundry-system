@extends('layouts.app')

@section('title', 'Kelola Kurir')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="bi bi-people"></i> Kelola Kurir</h2>
            <a href="{{ route('admin.kurir.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Kurir
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                @if($kurirs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kurir</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Alamat</th>
                                    <th>Total Tugas</th>
                                    <th>Bergabung</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kurirs as $index => $kurir)
                                    <tr>
                                        <td>{{ $kurirs->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $kurir->name }}</strong>
                                        </td>
                                        <td>{{ $kurir->email }}</td>
                                        <td>{{ $kurir->phone }}</td>
                                        <td>{{ Str::limit($kurir->address, 30) }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $kurir->transaksi_kurir_count }} tugas</span>
                                        </td>
                                        <td>{{ $kurir->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.kurir.show', $kurir) }}" 
                                                   class="btn btn-info btn-sm" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.kurir.edit', $kurir) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.kurir.destroy', $kurir) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus kurir ini?')">
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
                    @if($kurirs->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $kurirs->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-people fs-1 text-muted"></i>
                        <h5 class="text-muted mt-2">Belum ada kurir</h5>
                        <p class="text-muted">Tambahkan kurir pertama untuk menangani pengiriman</p>
                        <a href="{{ route('admin.kurir.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Kurir
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection