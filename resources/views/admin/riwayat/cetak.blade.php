<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $transaksi->kode_invoice }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .company-name { font-size: 24px; font-weight: bold; color: #0d6efd; }
        .invoice-info { margin-bottom: 20px; }
        .customer-info { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f8f9fa; font-weight: bold; }
        .total-row { background-color: #e9ecef; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .status-success { background-color: #d4edda; color: #155724; }
        .status-warning { background-color: #fff3cd; color: #856404; }
        .status-danger { background-color: #f8d7da; color: #721c24; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-name">JasaLaundry</div>
        <p>Layanan Laundry Antar-Jemput Terpercaya</p>
        <p>Telepon: (021) 1234-5678 | Email: info@jasalaundry.com</p>
    </div>

    <!-- Invoice Info -->
    <div class="invoice-info">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <strong>INVOICE: {{ $transaksi->kode_invoice }}</strong><br>
                    Tanggal: {{ $transaksi->created_at->format('d/m/Y H:i') }}<br>
                    @if($transaksi->tanggal_selesai)
                        Selesai: {{ $transaksi->tanggal_selesai->format('d/m/Y H:i') }}
                    @endif
                </td>
                <td style="text-align: right;">
                    Status: 
                    @if($transaksi->status_transaksi === 'selesai')
                        <span class="status-badge status-success">SELESAI</span>
                    @elseif($transaksi->status_transaksi === 'siap_antar')
                        <span class="status-badge status-warning">SIAP ANTAR</span>
                    @else
                        <span class="status-badge status-warning">PROSES</span>
                    @endif
                    <br><br>
                    Pembayaran: 
                    @if($transaksi->status_bayar === 'lunas')
                        <span class="status-badge status-success">LUNAS</span>
                    @else
                        <span class="status-badge status-danger">BELUM BAYAR</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Customer Info -->
    <div class="customer-info">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <strong>PELANGGAN:</strong><br>
                    {{ $transaksi->user->name }}<br>
                    {{ $transaksi->user->email }}<br>
                    {{ $transaksi->user->phone }}<br>
                    {{ $transaksi->user->address }}
                </td>
                <td style="vertical-align: top;">
                    <strong>ALAMAT PENJEMPUTAN:</strong><br>
                    {{ $transaksi->alamat_jemput }}
                    
                    @if($transaksi->catatan)
                        <br><br><strong>CATATAN:</strong><br>
                        {{ $transaksi->catatan }}
                    @endif
                    
                    @if($transaksi->kurir)
                        <br><br><strong>KURIR:</strong><br>
                        {{ $transaksi->kurir->name }}<br>
                        {{ $transaksi->kurir->phone }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Detail Paket -->
    <table class="table">
        <thead>
            <tr>
                <th>Paket Laundry</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksis as $detail)
                <tr>
                    <td>
                        <strong>{{ $detail->paket->nama_paket }}</strong><br>
                        <small>{{ $detail->paket->deskripsi }}</small>
                    </td>
                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}/{{ $detail->paket->satuan }}</td>
                    <td>{{ $detail->jumlah }} {{ $detail->paket->satuan }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" style="text-align: right;"><strong>TOTAL HARGA:</strong></td>
                <td><strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <!-- Informasi Tambahan -->
    @if($transaksi->berat_aktual)
        <div style="background-color: #e9ecef; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
            <strong>INFORMASI PENIMBANGAN:</strong><br>
            Berat Aktual: {{ $transaksi->berat_aktual }} kg<br>
            Kalkulasi: {{ $transaksi->berat_aktual }} kg × Rp {{ number_format($transaksi->detailTransaksis->first()->harga_satuan, 0, ',', '.') }} = Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>Terima kasih telah menggunakan layanan JasaLaundry!</strong></p>
        <p>Invoice ini dicetak pada {{ now()->format('d/m/Y H:i') }}</p>
        <p>Untuk pertanyaan, hubungi customer service kami di (021) 1234-5678</p>
    </div>

    <!-- Print Button -->
    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #0d6efd; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Cetak Invoice
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Tutup
        </button>
    </div>
</body>
</html>