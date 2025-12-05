@extends('layouts.app')

@section('title', 'Dashboard Kurir')

@section('content')
<div class="row fade-in-up">
    <div class="col-12">
        <h1 class="page-title">Dashboard Kurir</h1>
        <p class="welcome-text">Selamat datang, {{ auth()->user()->name }}! Kelola tugas pengantaran Anda dengan efisien.</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4 fade-in-up stagger-1">
    <div class="col-md-3 mb-3">
        <div class="card border-warning" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-warning fw-bold mb-1">{{ $tugasBaru }}</h4>
                    <p class="mb-0 text-muted">Tugas Baru</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-exclamation-circle fs-1 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-primary" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-primary fw-bold mb-1">{{ $tugasProses }}</h4>
                    <p class="mb-0 text-muted">Dalam Proses</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-clock fs-1 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-success" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-success fw-bold mb-1">{{ $tugasSelesai }}</h4>
                    <p class="mb-0 text-muted">Selesai Hari Ini</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-info" style="border-width: 2px !important;">
            <div class="card-body d-flex align-items-center">
                <div class="flex-grow-1">
                    <h4 class="text-info fw-bold mb-1">{{ $totalTugas }}</h4>
                    <p class="mb-0 text-muted">Total Tugas</p>
                </div>
                <div class="ms-3">
                    <i class="bi bi-list-task fs-1 text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4 fade-in-up stagger-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 section-title"><i class="bi bi-lightning"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('kurir.tugas') }}" class="btn btn-primary w-100 menu-card">
                            <i class="bi bi-list-task fs-4 d-block mb-2"></i>
                            <strong>Semua Tugas</strong>
                            <small class="d-block text-white-50">Lihat semua tugas</small>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('kurir.tugas', ['status' => 'dijemput_kurir']) }}" class="btn btn-outline-warning w-100 menu-card">
                            <i class="bi bi-truck fs-4 d-block mb-2"></i>
                            <strong>Tugas Baru</strong>
                            <small class="d-block text-muted">Penjemputan baru</small>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('kurir.tugas', ['status' => 'siap_antar']) }}" class="btn btn-outline-success w-100 menu-card">
                            <i class="bi bi-box-arrow-up fs-4 d-block mb-2"></i>
                            <strong>Siap Antar</strong>
                            <small class="d-block text-muted">Pengantaran</small>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('kurir.tugas', ['status' => 'selesai']) }}" class="btn btn-outline-dark w-100 menu-card">
                            <i class="bi bi-check-all fs-4 d-block mb-2"></i>
                            <strong>Selesai</strong>
                            <small class="d-block text-muted">Tugas selesai</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tugas Terbaru -->
<div class="row fade-in-up stagger-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 section-title"><i class="bi bi-clock-history"></i> Tugas Terbaru</h5>
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