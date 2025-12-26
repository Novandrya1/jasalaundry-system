<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - JasaLaundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .payment-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }
        .qr-code {
            width: 200px;
            height: 200px;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            border-radius: 10px;
        }
        .demo-badge {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="payment-card">
        <div class="text-center p-4 bg-primary text-white">
            <h4><i class="bi bi-qr-code"></i> Pembayaran QRIS</h4>
            <span class="demo-badge">DEMO MODE</span>
        </div>
        
        <div class="p-4">
            <div class="text-center mb-4">
                <h5>{{ $transaksi->kode_invoice }}</h5>
                <p class="text-muted mb-0">{{ $transaksi->user->name }}</p>
            </div>
            
            <div class="qr-code mb-4">
                <div class="text-center">
                    <i class="bi bi-qr-code" style="font-size: 4rem; color: #6c757d;"></i>
                    <br>
                    <small class="text-muted">QR Code Demo</small>
                </div>
            </div>
            
            <div class="text-center mb-4">
                <h3 class="text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h3>
                <p class="text-muted">Scan QR Code dengan aplikasi pembayaran Anda</p>
            </div>
            
            <div class="alert alert-info">
                <small>
                    <i class="bi bi-info-circle"></i>
                    Ini adalah mode demo. Klik tombol di bawah untuk simulasi pembayaran berhasil.
                </small>
            </div>
            
            <div class="d-grid gap-2">
                <button class="btn btn-success" onclick="confirmPayment()">
                    <i class="bi bi-check-circle"></i> Simulasi Bayar Berhasil
                </button>
                <a href="{{ route('pelanggan.riwayat') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmPayment() {
            const btn = event.target;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            
            fetch('{{ route("payment.demo.confirm", $transaksi->kode_invoice) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Pembayaran berhasil! Anda akan diarahkan ke halaman riwayat.');
                    window.location.href = '{{ route("pelanggan.riwayat") }}';
                } else {
                    alert('Terjadi kesalahan: ' + data.message);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-check-circle"></i> Simulasi Bayar Berhasil';
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan jaringan');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-check-circle"></i> Simulasi Bayar Berhasil';
            });
        }
    </script>
</body>
</html>