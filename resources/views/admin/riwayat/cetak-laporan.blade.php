<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi - JasaLaundry</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; background-color: #f9f9f9; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN TRANSAKSI</h2>
        <h3>JasaLaundry</h3>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="info">
        <h4>Filter Laporan:</h4>
        <ul>
            @if($request->status)
                <li>Status: {{ ucfirst(str_replace('_', ' ', $request->status)) }}</li>
            @endif
            @if($request->status_bayar)
                <li>Status Bayar: {{ $request->status_bayar == 'lunas' ? 'Lunas' : 'Belum Bayar' }}</li>
            @endif
            @if($request->metode_bayar)
                <li>Metode Bayar: {{ $request->metode_bayar == 'tunai' ? 'Bayar Ditempat' : 'Transfer Bank' }}</li>
            @endif
            @if($request->tanggal_mulai)
                <li>Tanggal Mulai: {{ $request->tanggal_mulai }}</li>
            @endif
            @if($request->tanggal_selesai)
                <li>Tanggal Selesai: {{ $request->tanggal_selesai }}</li>
            @endif
        </ul>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Pelanggan</th>
                <th>Paket</th>
                <th>Berat</th>
                <th>Metode Bayar</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $transaksi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaksi->kode_invoice }}</td>
                    <td>{{ $transaksi->user->name }}</td>
                    <td>
                        @foreach($transaksi->detailTransaksis as $detail)
                            {{ $detail->paket->nama_paket }}
                            @if(!$loop->last)<br>@endif
                        @endforeach
                    </td>
                    <td>{{ $transaksi->berat_aktual ? $transaksi->berat_aktual . ' kg' : '-' }}</td>
                    <td>{{ $transaksi->metode_bayar == 'tunai' ? 'Bayar Ditempat' : 'Transfer Bank' }}</td>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->status_bayar == 'lunas' ? 'Lunas' : 'Belum Bayar' }}</td>
                    <td>{{ $transaksi->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="6"><strong>Total Pendapatan (Lunas)</strong></td>
                <td><strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px;">
            Cetak Laporan
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 5px; margin-left: 10px;">
            Tutup
        </button>
    </div>
</body>
</html>