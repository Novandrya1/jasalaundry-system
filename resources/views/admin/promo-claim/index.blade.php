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
                                    <th>Email</th>
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
                                            <small class="text-muted">{{ $claim->user->phone }}</small><br>
                                            <button class="btn btn-outline-info btn-xs mt-1" 
                                                    onclick="showUserDetail({{ $claim->user->id }}, '{{ $claim->user->name }}', '{{ $claim->user->email }}', '{{ $claim->user->phone }}', '{{ $claim->user->address }}', '{{ $claim->user->created_at->format('d/m/Y') }}')" 
                                                    title="Detail Pelanggan">
                                                <i class="bi bi-person-lines-fill"></i> Detail
                                            </button>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $claim->user->email }}</small>
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