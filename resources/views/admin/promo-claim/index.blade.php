@extends('layouts.app')

@section('title', 'Validasi Promo')

@section('content')
<style>
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.claim-card {
    border: none;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.table-modern {
    border-collapse: separate;
    border-spacing: 0;
}

.table-modern th {
    background: #f8fafc;
    border: none;
    padding: 1rem;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

.table-modern td {
    border: none;
    padding: 1rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.table-modern tr:hover {
    background: #f8fafc;
}

.customer-info {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.promo-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 0.75rem;
}

.action-btn {
    border-radius: 8px;
    padding: 0.4rem 0.6rem;
    margin: 0 0.1rem;
}

.promo-code {
    background: #f1f5f9;
    color: #374151;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-family: 'Courier New', monospace;
    font-weight: 600;
}

.empty-state {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    .table-responsive {
        font-size: 0.85rem;
    }
    .action-btn {
        padding: 0.3rem 0.5rem;
        font-size: 0.8rem;
    }
}
</style>

<!-- Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2 fw-bold"><i class="bi bi-check-circle"></i> Validasi Klaim Promo</h1>
            <p class="mb-0 opacity-90">Setujui atau tolak klaim promo dari pelanggan</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            @php
                $pendingCount = $claims->where('status', 'pending')->count();
            @endphp
            @if($pendingCount > 0)
                <span class="badge bg-warning text-dark fs-6">
                    {{ $pendingCount }} Menunggu Validasi
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="claim-card">
            <div class="card-body p-0">
                @if($claims->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th width="12%">Tanggal</th>
                                    <th width="18%">Pelanggan</th>
                                    <th width="15%">Promo</th>
                                    <th width="10%">Diskon</th>
                                    <th width="12%">Kode Promo</th>
                                    <th width="15%">Status</th>
                                    <th width="18%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($claims as $claim)
                                    <tr>
                                        <td>
                                            <div class="text-muted small">
                                                <i class="bi bi-calendar me-1"></i>
                                                {{ $claim->created_at->format('d/m/Y') }}<br>
                                                <small>{{ $claim->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="customer-info">{{ $claim->user->name }}</div>
                                            <small class="text-muted d-block">{{ $claim->user->phone }}</small>
                                            <button class="btn btn-outline-info btn-sm mt-1" 
                                                    onclick="showUserDetail({{ $claim->user->id }}, '{{ $claim->user->name }}', '{{ $claim->user->email }}', '{{ $claim->user->phone }}', '{{ addslashes($claim->user->address) }}', '{{ $claim->user->created_at->format('d/m/Y') }}')" 
                                                    title="Detail Pelanggan">
                                                <i class="bi bi-person-lines-fill"></i> Detail
                                            </button>
                                        </td>
                                        <td>
                                            <div class="promo-title">{{ $claim->promo->judul }}</div>
                                            <small class="text-muted">{{ Str::limit($claim->promo->deskripsi, 30) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success text-white">{{ $claim->promo->diskon_text }}</span>
                                        </td>
                                        <td>
                                            <span class="promo-code">{{ $claim->kode_promo }}</span>
                                        </td>
                                        <td>
                                            @if($claim->status === 'pending')
                                                <span class="status-badge bg-warning text-dark">Menunggu Validasi</span>
                                            @elseif($claim->status === 'approved')
                                                <span class="status-badge bg-success text-white">Disetujui</span>
                                                @if($claim->approved_at)
                                                    <br><small class="text-muted">{{ $claim->approved_at->format('d/m H:i') }}</small>
                                                @endif
                                            @elseif($claim->status === 'rejected')
                                                <span class="status-badge bg-danger text-white">Ditolak</span>
                                            @elseif($claim->status === 'used')
                                                <span class="status-badge bg-dark text-white">Sudah Digunakan</span>
                                                @if($claim->used_at)
                                                    <br><small class="text-muted">{{ $claim->used_at->format('d/m H:i') }}</small>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($claim->status === 'pending')
                                                <div class="d-flex gap-1 justify-content-center">
                                                    <form action="{{ route('admin.promo-claim.approve', $claim) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="action-btn btn btn-success btn-sm" 
                                                                onclick="return confirm('Setujui klaim promo ini?')" title="Setujui">
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.promo-claim.reject', $claim) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="action-btn btn btn-danger btn-sm" 
                                                                onclick="return confirm('Tolak klaim promo ini?')" title="Tolak">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($claim->status === 'approved')
                                                <a href="{{ \App\Services\WhatsAppService::sendNotification($claim->user->phone, 'Kode Promo Anda: ' . $claim->kode_promo . '. Gunakan saat memesan laundry untuk mendapat diskon ' . $claim->promo->diskon_text . '. - JasaLaundry') }}" 
                                                   target="_blank" class="action-btn btn btn-outline-success btn-sm" title="Kirim Ulang Kode">
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
                        <div class="d-flex justify-content-center p-3">
                            {{ $claims->links() }}
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <h4 class="text-muted mb-2">Belum ada klaim promo</h4>
                        <p class="text-muted mb-4">Klaim promo dari pelanggan akan muncul di sini untuk divalidasi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pelanggan -->
<div class="modal fade" id="userDetailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-circle"></i> Detail Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Nama:</strong>
                    </div>
                    <div class="col-md-8" id="userName"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-md-8" id="userEmail"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>No. HP:</strong>
                    </div>
                    <div class="col-md-8" id="userPhone"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Alamat:</strong>
                    </div>
                    <div class="col-md-8" id="userAddress"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Terdaftar:</strong>
                    </div>
                    <div class="col-md-8" id="userRegistered"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Riwayat Transaksi:</strong>
                    </div>
                    <div class="col-md-8" id="userTransactions">
                        <div class="spinner-border spinner-border-sm" role="status"></div>
                        Loading...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showUserDetail(userId, name, email, phone, address, registered) {
    // Set basic info
    document.getElementById('userName').textContent = name;
    document.getElementById('userEmail').textContent = email;
    document.getElementById('userPhone').textContent = phone;
    document.getElementById('userAddress').textContent = address || 'Belum diisi';
    document.getElementById('userRegistered').textContent = registered;
    
    // Reset transactions
    document.getElementById('userTransactions').innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div> Loading...';
    
    // Show modal
    new bootstrap.Modal(document.getElementById('userDetailModal')).show();
    
    // Load transaction history
    fetch(`/admin/user/${userId}/transactions`)
        .then(response => response.json())
        .then(data => {
            let html = '';
            if (data.transactions && data.transactions.length > 0) {
                html = `<small class="text-success">Total: ${data.total} transaksi</small><br>`;
                data.transactions.slice(0, 3).forEach(t => {
                    html += `<small class="text-muted">• ${t.kode_invoice} - ${t.status}</small><br>`;
                });
                if (data.transactions.length > 3) {
                    html += `<small class="text-info">... dan ${data.transactions.length - 3} lainnya</small>`;
                }
            } else {
                html = '<small class="text-muted">Belum ada transaksi</small>';
            }
            document.getElementById('userTransactions').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('userTransactions').innerHTML = '<small class="text-danger">Gagal memuat data</small>';
        });
}
</script>
@endsection