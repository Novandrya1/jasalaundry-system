@extends('layouts.app')

@section('title', 'Proses Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4><i class="bi bi-gear"></i> Proses Transaksi - {{ $transaksi->kode_invoice }}</h4>
            </div>
            <div class="card-body">
                <!-- Info Pelanggan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-person"></i> Informasi Pelanggan</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Nama:</strong></td>
                                        <td>{{ $transaksi->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $transaksi->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Telepon:</strong></td>
                                        <td>{{ $transaksi->user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat Jemput:</strong></td>
                                        <td>{{ $transaksi->alamat_jemput }}</td>
                                    </tr>
                                    @if($transaksi->catatan)
                                        <tr>
                                            <td><strong>Catatan:</strong></td>
                                            <td>{{ $transaksi->catatan }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-box"></i> Detail Paket</h6>
                                @foreach($transaksi->detailTransaksis as $detail)
                                    <div class="mb-2">
                                        <strong>{{ $detail->paket->nama_paket }}</strong><br>
                                        <small class="text-muted">
                                            Harga: Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}/{{ $detail->paket->satuan }}
                                        </small>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Proses -->
                <form method="POST" action="{{ route('admin.transaksi.update', $transaksi) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="berat_aktual" class="form-label">Berat Aktual (kg)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('berat_aktual') is-invalid @enderror" 
                                           id="berat_aktual" name="berat_aktual" 
                                           value="{{ old('berat_aktual', $transaksi->berat_aktual) }}" 
                                           step="0.1" min="0" placeholder="0.0">
                                    <span class="input-group-text">kg</span>
                                    @error('berat_aktual')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Masukkan berat setelah penimbangan</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kurir_id" class="form-label">Pilih Kurir</label>
                                <select class="form-select @error('kurir_id') is-invalid @enderror" 
                                        id="kurir_id" name="kurir_id">
                                    <option value="">-- Pilih Kurir --</option>
                                    @foreach($kurirs as $kurir)
                                        <option value="{{ $kurir->id }}" 
                                                {{ old('kurir_id', $transaksi->kurir_id) == $kurir->id ? 'selected' : '' }}>
                                            {{ $kurir->name }} - {{ $kurir->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kurir_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status_transaksi" class="form-label">Status Transaksi</label>
                                <select class="form-select @error('status_transaksi') is-invalid @enderror" 
                                        id="status_transaksi" name="status_transaksi" required>
                                    <option value="request_jemput" 
                                            {{ old('status_transaksi', $transaksi->status_transaksi) == 'request_jemput' ? 'selected' : '' }}>
                                        Menunggu Penjemputan
                                    </option>
                                    <option value="dijemput_kurir" 
                                            {{ old('status_transaksi', $transaksi->status_transaksi) == 'dijemput_kurir' ? 'selected' : '' }}>
                                        Dijemput Kurir
                                    </option>
                                    <option value="proses_cuci" 
                                            {{ old('status_transaksi', $transaksi->status_transaksi) == 'proses_cuci' ? 'selected' : '' }}>
                                        Sedang Dicuci
                                    </option>
                                    <option value="siap_antar" 
                                            {{ old('status_transaksi', $transaksi->status_transaksi) == 'siap_antar' ? 'selected' : '' }}>
                                        Siap Diantar
                                    </option>
                                    <option value="selesai" 
                                            {{ old('status_transaksi', $transaksi->status_transaksi) == 'selesai' ? 'selected' : '' }}>
                                        Selesai
                                    </option>
                                </select>
                                @error('status_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status_bayar" class="form-label">Status Pembayaran</label>
                                <select class="form-select @error('status_bayar') is-invalid @enderror" 
                                        id="status_bayar" name="status_bayar" required>
                                    <option value="belum_bayar" 
                                            {{ old('status_bayar', $transaksi->status_bayar) == 'belum_bayar' ? 'selected' : '' }}>
                                        Belum Bayar
                                    </option>
                                    <option value="lunas" 
                                            {{ old('status_bayar', $transaksi->status_bayar) == 'lunas' ? 'selected' : '' }}>
                                        Lunas
                                    </option>
                                </select>
                                @error('status_bayar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Metode: 
                                    @if($transaksi->metode_bayar === 'transfer')
                                        <span class="badge bg-info">Transfer Bank</span>
                                    @else
                                        <span class="badge bg-warning">Tunai (COD)</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Kalkulasi Harga -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6><i class="bi bi-calculator"></i> Kalkulasi Harga</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Berat Saat Ini:</strong> 
                                            {{ $transaksi->berat_aktual ? $transaksi->berat_aktual . ' kg' : 'Belum ditimbang' }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Harga per kg:</strong> 
                                            Rp {{ number_format($transaksi->detailTransaksis->first()->harga_satuan, 0, ',', '.') }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Total Harga:</strong> 
                                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        @if($transaksi->metode_bayar === 'transfer')
                            <a href="{{ \App\Services\WhatsAppService::sendNotification($transaksi->user->phone, \App\Services\WhatsAppService::getPaymentMessage($transaksi)) }}" 
                               target="_blank" class="btn btn-success">
                                <i class="bi bi-whatsapp"></i> Kirim Info Pembayaran
                            </a>
                        @endif
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Update Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('berat_aktual').addEventListener('input', function() {
    const berat = parseFloat(this.value) || 0;
    const hargaPerKg = {{ $transaksi->detailTransaksis->first()->harga_satuan }};
    const total = berat * hargaPerKg;
    
    // Update tampilan kalkulasi secara real-time jika diperlukan
    console.log('Berat:', berat, 'Total:', total);
});
</script>
@endsection