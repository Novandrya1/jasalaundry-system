@extends('layouts.app')

@section('title', 'Kelola Promo')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="bi bi-gift"></i> Kelola Promo</h2>
            <a href="{{ route('admin.promo.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Promo
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                @if($promos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Judul Promo</th>
                                    <th>Diskon</th>
                                    <th>Deskripsi</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promos as $index => $promo)
                                    <tr>
                                        <td>{{ $promos->firstItem() + $index }}</td>
                                        <td><strong>{{ $promo->judul }}</strong></td>
                                        <td>
                                            <span class="badge bg-success">{{ $promo->diskon_text }}</span>
                                        </td>
                                        <td>{{ Str::limit($promo->deskripsi, 40) }}</td>
                                        <td>
                                            {{ $promo->tanggal_mulai->format('d/m/Y') }} - 
                                            {{ $promo->tanggal_selesai->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            @if($promo->is_active && $promo->tanggal_mulai <= now() && $promo->tanggal_selesai >= now())
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($promo->tanggal_selesai < now())
                                                <span class="badge bg-secondary">Berakhir</span>
                                            @elseif($promo->tanggal_mulai > now())
                                                <span class="badge bg-warning">Akan Datang</span>
                                            @else
                                                <span class="badge bg-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.promo.edit', $promo) }}" 
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.promo.destroy', $promo) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus promo ini?')">
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

                    @if($promos->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $promos->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-gift fs-1 text-muted"></i>
                        <h5 class="text-muted mt-2">Belum ada promo</h5>
                        <p class="text-muted">Tambahkan promo menarik untuk pelanggan</p>
                        <a href="{{ route('admin.promo.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Promo
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection