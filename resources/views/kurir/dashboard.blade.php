@extends('layouts.app')

@section('title', 'Dashboard Kurir')

@section('content')
<div class="row">
    <div class="col-12">
        <h2><i class="bi bi-truck"></i> Dashboard Kurir</h2>
        <p class="text-muted">Selamat datang, {{ auth()->user()->name }}</p>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="mb-0">{{ $tugasBaru }}</h3>
                    <p class="mb-0">Tugas Baru</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-exclamation-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="mb-0">{{ $tugasProses }}</h3>
                    <p class="mb-0">Dalam Proses</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-clock fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h3 class="mb-0">{{ $tugasSelesai }}</h3>
                    <p class="mb-0">Selesai</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-check-circle fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Menu Cepat -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5><i class="bi bi-lightning"></i> Menu Cepat</h5>
                <div class="row">
                    <div class="col-6 col-md-3 mb-2">
                        <a href="{{ route('kurir.tugas') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-list-task d-block fs-4"></i>
                            <small>Semua Tugas</small>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-2">
                        <a href="{{ route('kurir.tugas', ['status' => 'dijemput_kurir']) }}" class="btn btn-outline-warning w-100">
                            <i class="bi bi-truck d-block fs-4"></i>
                            <small>Tugas Baru</small>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-2">
                        <a href="{{ route('kurir.tugas', ['status' => 'siap_antar']) }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-box-arrow-up d-block fs-4"></i>
                            <small>Siap Antar</small>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 mb-2">
                        <a href="{{ route('kurir.tugas', ['status' => 'selesai']) }}" class="btn btn-outline-dark w-100">
                            <i class="bi bi-check-all d-block fs-4"></i>
                            <small>Selesai</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tugas Terbaru -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Tugas Terbaru</h5>
                <a href="{{ route('kurir.tugas') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($transaksiTerbaru->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($transaksiTerbaru as $transaksi)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $transaksi->kode_invoice }}</h6>
                                        <p class="mb-1"><strong>{{ $transaksi->user->name }}</strong></p>
                                        <small class="text-muted">{{ Str::limit($transaksi->alamat_jemput, 50) }}</small>
                                    </div>
                                    <div class="text-end">
                                        @if($transaksi->status_transaksi === 'dijemput_kurir')
                                            <span class="badge bg-warning">Baru</span>
                                        @elseif($transaksi->status_transaksi === 'siap_antar')
                                            <span class="badge bg-success">Siap Antar</span>
                                        @elseif($transaksi->status_transaksi === 'selesai')
                                            <span class="badge bg-dark">Selesai</span>
                                        @endif
                                        <br><small class="text-muted">{{ $transaksi->created_at->format('d/m H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada tugas yang ditugaskan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection