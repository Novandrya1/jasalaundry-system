<?php

namespace App\Services;

class WhatsAppService
{
    public static function sendNotification($phone, $message)
    {
        // Bersihkan nomor telepon
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        
        // Jika nomor dimulai dengan 0, ganti dengan 62
        if (substr($cleanPhone, 0, 1) === '0') {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }
        
        // Encode pesan untuk URL
        $encodedMessage = urlencode($message);
        
        // Generate WhatsApp URL
        $whatsappUrl = "https://wa.me/{$cleanPhone}?text={$encodedMessage}";
        
        return $whatsappUrl;
    }
    
    public static function getStatusMessage($transaksi)
    {
        $messages = [
            'request_jemput' => "Halo {$transaksi->user->name}! Pesanan laundry Anda dengan invoice {$transaksi->kode_invoice} telah diterima. Kurir akan segera menghubungi Anda untuk penjemputan.",
            
            'dijemput_kurir' => "Pesanan {$transaksi->kode_invoice} telah dijemput oleh kurir kami. Pakaian Anda sedang dalam perjalanan ke tempat pencucian.",
            
            'proses_cuci' => "Pesanan {$transaksi->kode_invoice} sedang dalam proses pencucian. Estimasi selesai 1-2 hari kerja.",
            
            'siap_antar' => "Pesanan {$transaksi->kode_invoice} sudah selesai dicuci dan siap untuk diantar! Kurir akan segera menghubungi Anda.",
            
            'selesai' => "Pesanan {$transaksi->kode_invoice} telah selesai diantar. Terima kasih telah menggunakan layanan JasaLaundry!"
        ];
        
        return $messages[$transaksi->status_transaksi] ?? '';
    }
    
    public static function getPaymentMessage($transaksi)
    {
        if ($transaksi->metode_bayar === 'transfer') {
            return "Invoice: {$transaksi->kode_invoice}\nTotal: Rp " . number_format($transaksi->total_harga, 0, ',', '.') . "\n\nSilakan transfer ke:\nBCA: 1234567890\nBRI: 0987654321\nMandiri: 1122334455\n\nKirim bukti transfer ke admin untuk konfirmasi pembayaran.";
        }
        
        return "Invoice: {$transaksi->kode_invoice}\nTotal: Rp " . number_format($transaksi->total_harga, 0, ',', '.') . "\n\nPembayaran tunai akan dibayar saat pengantaran.";
    }
}