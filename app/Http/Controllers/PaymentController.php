<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Services\MidtransService;
use App\Services\WhatsAppService;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct()
    {
        $this->midtransService = new MidtransService();
    }

    public function webhook(Request $request)
    {
        $notification = $request->all();
        
        $paymentStatus = $this->midtransService->handleNotification((object) $notification);
        
        $transaksi = Transaksi::where('kode_invoice', $notification['order_id'])->first();
        
        if (!$transaksi) {
            return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }

        switch ($paymentStatus) {
            case 'paid':
                $transaksi->update([
                    'status_bayar' => 'sudah_bayar',
                    'paid_at' => now()
                ]);
                
                // Send confirmation via WhatsApp
                $message = "Pembayaran berhasil!\\n\\nKode Invoice: {$transaksi->kode_invoice}\\nTotal: Rp " . number_format($transaksi->total_harga, 0, ',', '.') . "\\n\\nPesanan Anda akan segera diproses. Kurir akan menghubungi untuk penjemputan.\\n\\nTerima kasih - JasaLaundry";
                
                WhatsAppService::sendNotification(
                    $transaksi->user->phone,
                    $message
                );
                break;
                
            case 'pending':
                // Keep current status
                break;
                
            case 'failed':
                $transaksi->update([
                    'status_bayar' => 'gagal_bayar'
                ]);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    public function checkStatus($kodeInvoice)
    {
        $transaksi = Transaksi::where('kode_invoice', $kodeInvoice)->first();
        
        if (!$transaksi) {
            return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }

        $result = $this->midtransService->getTransactionStatus($kodeInvoice);
        
        if ($result['success']) {
            $status = $result['status'];
            
            if ($status->transaction_status == 'settlement') {
                $transaksi->update([
                    'status_bayar' => 'sudah_bayar',
                    'paid_at' => now()
                ]);
            }
            
            return response()->json([
                'status' => 'success',
                'payment_status' => $transaksi->status_bayar,
                'transaction_status' => $status->transaction_status
            ]);
        }

        return response()->json(['status' => 'error', 'message' => $result['message']], 500);
    }

    public function demoPayment($kodeInvoice)
    {
        $transaksi = Transaksi::where('kode_invoice', $kodeInvoice)->first();
        
        if (!$transaksi) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        return view('payment.demo', compact('transaksi'));
    }

    public function confirmDemoPayment($kodeInvoice)
    {
        $transaksi = Transaksi::where('kode_invoice', $kodeInvoice)->first();
        
        if (!$transaksi) {
            return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }

        $transaksi->update([
            'status_bayar' => 'sudah_bayar',
            'paid_at' => now()
        ]);
        
        // Send confirmation via WhatsApp
        $message = "Pembayaran berhasil!\n\nKode Invoice: {$transaksi->kode_invoice}\nTotal: Rp " . number_format($transaksi->total_harga, 0, ',', '.') . "\n\nPesanan Anda akan segera diproses. Kurir akan menghubungi untuk penjemputan.\n\nTerima kasih - JasaLaundry";
        
        WhatsAppService::sendNotification(
            $transaksi->user->phone,
            $message
        );

        return response()->json(['status' => 'success', 'message' => 'Pembayaran berhasil dikonfirmasi']);
    }
}