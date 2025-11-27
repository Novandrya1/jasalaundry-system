@extends('layouts.app')

@section('title', 'Validasi Promo')

@section('content')
<div class="row">
    <div class="col-12">
        <h2><i class="bi bi-check-circle"></i> Validasi Klaim Promo</h2>
        <p class="text-muted">Setujui atau tolak klaim promo dari pelanggan</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                @if($claims->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Promo</th>
                                    <th>Diskon</th>
                                    <th>Kode Promo</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($claims as $claim)
                                    <tr>
                                        <td>{{ $claim->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <strong>{{ $claim->user->name }}</strong><br>
                                            <small class="text-muted">{{ $claim->user->phone }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $claim->promo->judul }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($claim->promo->deskripsi, 40) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $claim->promo->diskon_text }}</span>
                                        </td>
                                        <td>
                                            <code>{{ $claim->kode_promo }}</code>
                                        </td>
                                        <td>
                                            @if($claim->status === 'pending')
                                                <span class="badge bg-warning">Menunggu Validasi</span>
                                            @elseif($claim->status === 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                                @if($claim->approved_at)
                                                    <br><small class="text-muted">{{ $claim->approved_at->format('d/m/Y H:i') }}</small>
                                                @endif
                                            @elseif($claim->status === 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif($claim->status === 'used')
                                                <span class="badge bg-dark">Sudah Digunakan</span>
                                                @if($claim->used_at)
                                                    <br><small class="text-muted">{{ $claim->used_at->format('d/m/Y H:i') }}</small>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($claim->status === 'pending')
                                                <div class="btn-group" role="group">
                                                    <form action="{{ route('admin.promo-claim.approve', $claim) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm" 
                                                                onclick="return confirm('Setujui klaim promo ini?')" title="Setujui">
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.promo-claim.reject', $claim) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('Tolak klaim promo ini?')" title="Tolak">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($claim->status === 'approved')
                                                <a href="{{ \App\Services\WhatsAppService::sendNotification($claim->user->phone, 'Kode Promo Anda: ' . $claim->kode_promo . '. Gunakan saat memesan laundry untuk mendapat diskon ' . $claim->promo->diskon_text . '. - JasaLaundry') }}" 
                                                   target="_blank" class="btn btn-outline-success btn-sm" title="Kirim Ulang Kode">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($claims->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $claims->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <h5 class="text-muted mt-2">Belum ada klaim promo</h5>
                        <p class="text-muted">Klaim promo dari pelanggan akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection