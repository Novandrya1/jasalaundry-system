@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<style>
    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header */
    .dashboard-header {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1.5rem 1.75rem;
        margin-bottom: 1.5rem;
    }

    .dashboard-header h1 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: .25rem;
    }

    .dashboard-header p {
        color: #6b7280;
        margin: 0;
    }

    .dashboard-date {
        color: #6b7280;
        font-size: .9rem;
    }

    /* Statistik */
    .stat-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1.25rem;
        height: 100%;
        transition: .2s ease;
    }

    .stat-card:hover {
        border-color: #cbd5e1;
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .stat-label {
        color: #6b7280;
        font-size: .85rem;
        margin-bottom: .25rem;
    }

    .stat-number {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1f2937;
    }

    /* Section */
    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    /* Status pekerjaan */
    .status-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem;
        height: 100%;
    }

    .status-card:hover {
        border-color: #cbd5e1;
    }

    .status-icon {
        width: 40px;
        height: 40px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .status-number {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1f2937;
        line-height: 1;
    }

    .status-label {
        font-size: .8rem;
        color: #6b7280;
        margin-top: .25rem;
    }

    /* Transaksi */
    .transaction-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
    }

    .transaction-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-modern {
        margin-bottom: 0;
    }

    .table-modern th {
        background: #f8fafc;
        color: #6b7280;
        font-size: .8rem;
        font-weight: 600;
        border: none;
        padding: .85rem 1rem;
    }

    .table-modern td {
        padding: .9rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: .9rem;
    }

    .table-modern tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover {
        background: #f8fafc;
    }

    .invoice-code {
        font-weight: 600;
        color: #2563eb;
    }

    .customer-name {
        font-weight: 500;
        color: #374151;
    }

    .status-badge {
        display: inline-block;
        padding: .35rem .65rem;
        border-radius: 6px;
        font-size: .75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: .75rem;
    }

    /* Mobile */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.25rem;
        }

        .dashboard-header h1 {
            font-size: 1.4rem;
        }

        .dashboard-date {
            margin-top: .75rem;
        }

        .table-modern {
            min-width: 700px;
        }
    }
</style>


<div class="dashboard-wrapper">

    {{-- =========================
         HEADER
    ========================== --}}
    <div class="dashboard-header">
        <div class="row align-items-center">

            <div class="col-md-8">
                <h1>Dashboard Admin</h1>
                <p>
                    Selamat datang, <strong>{{ auth()->user()->name }}</strong>.
                    Berikut ringkasan aktivitas laundry.
                </p>
            </div>

            <div class="col-md-4 text-md-end">
                <div class="dashboard-date">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ now()->format('d F Y') }}
                </div>
            </div>

        </div>
    </div>


    {{-- =========================
         STATISTIK UTAMA
    ========================== --}}
    <div class="row g-3 mb-4">

        {{-- Pesanan Hari Ini --}}
        <div class="col-lg-4 col-md-6">
            <div class="stat-card">

                <div class="d-flex align-items-center">

                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-receipt"></i>
                    </div>

                    <div>
                        <div class="stat-label">
                            Pesanan Hari Ini
                        </div>

                        <div class="stat-number">
                            {{ $totalPesananHariIni }}
                        </div>
                    </div>

                </div>

            </div>
        </div>


        {{-- Pesanan Baru --}}
        <div class="col-lg-4 col-md-6">
            <div class="stat-card">

                <div class="d-flex align-items-center">

                    <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-bell"></i>
                    </div>

                    <div>
                        <div class="stat-label">
                            Pesanan Baru
                        </div>

                        <div class="stat-number">
                            {{ $pesananBaru }}
                        </div>
                    </div>

                </div>

            </div>
        </div>


        {{-- Pendapatan --}}
        <div class="col-lg-4 col-md-6">
            <div class="stat-card">

                <div class="d-flex align-items-center">

                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <div>
                        <div class="stat-label">
                            Pendapatan Bulan Ini
                        </div>

                        <div class="stat-number">
                            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>


    {{-- =========================
         STATUS PEKERJAAN
    ========================== --}}
    <div class="mb-4">

        <div class="section-title">
            Status Pekerjaan
        </div>

        <div class="row g-3">

            {{-- Menunggu Penjemputan --}}
            <div class="col-xl col-lg-4 col-md-6">
                <div class="status-card">

                    <div class="d-flex align-items-center">

                        <div class="status-icon bg-warning bg-opacity-10 text-warning me-3">
                            <i class="bi bi-clock"></i>
                        </div>

                        <div>
                            <div class="status-number">
                                {{ $menungguPenjemputan }}
                            </div>

                            <div class="status-label">
                                Menunggu Penjemputan
                            </div>
                        </div>

                    </div>

                </div>
            </div>


            {{-- Dijemput Kurir --}}
            <div class="col-xl col-lg-4 col-md-6">
                <div class="status-card">

                    <div class="d-flex align-items-center">

                        <div class="status-icon bg-info bg-opacity-10 text-info me-3">
                            <i class="bi bi-truck"></i>
                        </div>

                        <div>
                            <div class="status-number">
                                {{ $dijemputKurir }}
                            </div>

                            <div class="status-label">
                                Dijemput Kurir
                            </div>
                        </div>

                    </div>

                </div>
            </div>


            {{-- Proses Cuci --}}
            <div class="col-xl col-lg-4 col-md-6">
                <div class="status-card">

                    <div class="d-flex align-items-center">

                        <div class="status-icon bg-primary bg-opacity-10 text-primary me-3">
                            <i class="bi bi-droplet"></i>
                        </div>

                        <div>
                            <div class="status-number">
                                {{ $prosesCuci }}
                            </div>

                            <div class="status-label">
                                Sedang Dicuci
                            </div>
                        </div>

                    </div>

                </div>
            </div>


            {{-- Siap Antar --}}
            <div class="col-xl col-lg-4 col-md-6">
                <div class="status-card">

                    <div class="d-flex align-items-center">

                        <div class="status-icon bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <div>
                            <div class="status-number">
                                {{ $siapAntar }}
                            </div>

                            <div class="status-label">
                                Siap Diantar
                            </div>
                        </div>

                    </div>

                </div>
            </div>


            {{-- Selesai --}}
            <div class="col-xl col-lg-4 col-md-6">
                <div class="status-card">

                    <div class="d-flex align-items-center">

                        <div class="status-icon bg-dark bg-opacity-10 text-dark me-3">
                            <i class="bi bi-check-circle"></i>
                        </div>

                        <div>
                            <div class="status-number">
                                {{ $selesai }}
                            </div>

                            <div class="status-label">
                                Selesai
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>


    {{-- =========================
         TRANSAKSI TERBARU
    ========================== --}}
    <div class="transaction-card">

        <div class="transaction-header">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <div class="section-title mb-0">
                        Transaksi Terbaru
                    </div>

                    <small class="text-muted">
                        Pesanan yang perlu dipantau
                    </small>
                </div>

                <a href="{{ route('admin.transaksi.index') }}"
                   class="btn btn-sm btn-outline-primary">

                    <i class="bi bi-list me-1"></i>
                    Lihat Semua

                </a>

            </div>

        </div>


        <div class="card-body p-0">

            @if($transaksiTerbaru->count() > 0)

                <div class="table-responsive">

                    <table class="table table-modern">

                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Pelanggan</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($transaksiTerbaru as $transaksi)

                                <tr>

                                    {{-- Invoice --}}
                                    <td>
                                        <span class="invoice-code">
                                            {{ $transaksi->kode_invoice }}
                                        </span>
                                    </td>


                                    {{-- Pelanggan --}}
                                    <td>
                                        <span class="customer-name">
                                            {{ $transaksi->user->name }}
                                        </span>
                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @if($transaksi->status_transaksi === 'request_jemput')

                                            <span class="status-badge bg-warning text-dark">
                                                Menunggu Penjemputan
                                            </span>

                                        @elseif($transaksi->status_transaksi === 'dijemput_kurir')

                                            <span class="status-badge bg-info text-white">
                                                Dijemput Kurir
                                            </span>

                                        @elseif($transaksi->status_transaksi === 'proses_cuci')

                                            <span class="status-badge bg-primary text-white">
                                                Sedang Dicuci
                                            </span>

                                        @elseif($transaksi->status_transaksi === 'siap_antar')

                                            <span class="status-badge bg-success text-white">
                                                Siap Diantar
                                            </span>

                                        @elseif($transaksi->status_transaksi === 'selesai')

                                            <span class="status-badge bg-dark text-white">
                                                Selesai
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Total --}}
                                    <td>
                                        <strong class="text-success">
                                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                        </strong>
                                    </td>


                                    {{-- Tanggal --}}
                                    <td>
                                        <span class="text-muted">
                                            {{ $transaksi->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </td>


                                    {{-- Aksi --}}
                                    <td class="text-center">

                                        <div class="d-flex gap-1 justify-content-center">

                                            <a href="{{ route('admin.transaksi.edit', $transaksi) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit Transaksi">

                                                <i class="bi bi-pencil"></i>

                                            </a>


                                            @if($transaksi->status_transaksi !== 'selesai')

                                                <div class="btn-group">

                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-success dropdown-toggle"
                                                            data-bs-toggle="dropdown"
                                                            title="Update Status">

                                                        <i class="bi bi-arrow-repeat"></i>

                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end">

                                                        @if($transaksi->status_transaksi === 'request_jemput')

                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="#"
                                                                   onclick="updateStatus({{ $transaksi->id }}, 'dijemput_kurir')">

                                                                    <i class="bi bi-truck me-2"></i>
                                                                    Dijemput Kurir

                                                                </a>
                                                            </li>

                                                        @elseif($transaksi->status_transaksi === 'dijemput_kurir')

                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="#"
                                                                   onclick="updateStatus({{ $transaksi->id }}, 'proses_cuci')">

                                                                    <i class="bi bi-droplet me-2"></i>
                                                                    Proses Cuci

                                                                </a>
                                                            </li>

                                                        @elseif($transaksi->status_transaksi === 'proses_cuci')

                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="#"
                                                                   onclick="updateStatus({{ $transaksi->id }}, 'siap_antar')">

                                                                    <i class="bi bi-box-seam me-2"></i>
                                                                    Siap Antar

                                                                </a>
                                                            </li>

                                                        @elseif($transaksi->status_transaksi === 'siap_antar')

                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="#"
                                                                   onclick="updateStatus({{ $transaksi->id }}, 'selesai')">

                                                                    <i class="bi bi-check-circle me-2"></i>
                                                                    Selesai

                                                                </a>
                                                            </li>

                                                        @endif

                                                    </ul>

                                                </div>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty-state">

                    <i class="bi bi-inbox"></i>

                    <h5 class="mb-1">
                        Belum ada transaksi
                    </h5>

                    <p class="mb-0">
                        Transaksi pelanggan akan muncul di sini.

                    </p>

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =========================
     FORM UPDATE STATUS
========================== --}}
<form id="updateStatusForm"
      method="POST"
      style="display: none;">

    @csrf
    @method('PATCH')

    <input type="hidden"
           name="status_transaksi"
           id="newStatus">

</form>


<script>
function updateStatus(transaksiId, newStatus) {

    const statusNames = {
        'dijemput_kurir': 'Dijemput Kurir',
        'proses_cuci': 'Proses Cuci',
        'siap_antar': 'Siap Antar',
        'selesai': 'Selesai'
    };

    if (confirm(
        `Apakah Anda yakin ingin mengubah status menjadi "${statusNames[newStatus]}"?`
    )) {

        const form = document.getElementById('updateStatusForm');
        const statusInput = document.getElementById('newStatus');

        form.action = `/admin/transaksi/${transaksiId}`;

        statusInput.value = newStatus;

        form.submit();
    }
}
</script>

@endsection