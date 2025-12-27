<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    private static $apiUrl = 'https://api.whatsapp.com/send';
    private static $maxRetries = 3;
    
    public static function sendNotification($phone, $message, $retryCount = 0)
    {
        try {
            // Validasi input
            if (empty($phone) || empty($message)) {
                Log::warning('WhatsApp: Phone atau message kosong', [
                    'phone' => $phone,
                    'message' => substr($message, 0, 50) . '...'
                ]);
                return false;
            }
            
            // Bersihkan dan format nomor telepon
            $cleanPhone = self::formatPhoneNumber($phone);
            
            if (!$cleanPhone) {
                Log::error('WhatsApp: Format nomor telepon tidak valid', ['phone' => $phone]);
                return false;
            }
            
            // Encode pesan untuk URL
            $encodedMessage = urlencode($message);
            
            // Generate WhatsApp URL
            $whatsappUrl = "https://wa.me/{$cleanPhone}?text={$encodedMessage}";
            
            // Log notifikasi
            Log::info('WhatsApp notification sent', [
                'phone' => $cleanPhone,
                'message_preview' => substr($message, 0, 100) . '...',
                'url' => $whatsappUrl
            ]);
            
            return $whatsappUrl;
            
        } catch (\Exception $e) {
            Log::error('WhatsApp Service Error', [
                'error' => $e->getMessage(),
                'phone' => $phone,
                'retry_count' => $retryCount
            ]);
            
            // Retry mechanism
            if ($retryCount < self::$maxRetries) {
                return self::sendNotification($phone, $message, $retryCount + 1);
            }
            
            return false;
        }
    }
    
    private static function formatPhoneNumber($phone)
    {
        // Bersihkan nomor telepon dari karakter non-digit
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        
        // Validasi panjang nomor
        if (strlen($cleanPhone) < 10 || strlen($cleanPhone) > 15) {
            return false;
        }
        
        // Format nomor Indonesia
        if (substr($cleanPhone, 0, 1) === '0') {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        } elseif (substr($cleanPhone, 0, 2) !== '62') {
            $cleanPhone = '62' . $cleanPhone;
        }
        
        return $cleanPhone;
    }
    
    public static function sendStatusUpdate($transaksi)
    {
        try {
            $message = self::getStatusMessage($transaksi);
            
            if (!$message) {
                Log::warning('WhatsApp: Status message tidak ditemukan', [
                    'status' => $transaksi->status_transaksi,
                    'invoice' => $transaksi->kode_invoice
                ]);
                return false;
            }
            
            return self::sendNotification($transaksi->user->phone, $message);
            
        } catch (\Exception $e) {
            Log::error('WhatsApp Status Update Error', [
                'error' => $e->getMessage(),
                'invoice' => $transaksi->kode_invoice ?? 'unknown'
            ]);
            return false;
        }
    }
    
    public static function sendPaymentInfo($transaksi)
    {
        try {
            $message = self::getPaymentMessage($transaksi);
            return self::sendNotification($transaksi->user->phone, $message);
            
        } catch (\Exception $e) {
            Log::error('WhatsApp Payment Info Error', [
                'error' => $e->getMessage(),
                'invoice' => $transaksi->kode_invoice ?? 'unknown'
            ]);
            return false;
        }
    }
    
    public static function sendPromoCode($user, $promoClaim)
    {
        try {
            $message = "Selamat! Kode promo Anda telah disetujui:\n\n";
            $message .= "Kode: {$promoClaim->kode_promo}\n";
            $message .= "Promo: {$promoClaim->promo->nama_promo}\n";
            
            if ($promoClaim->promo->tipe_diskon === 'persen') {
                $message .= "Diskon: {$promoClaim->promo->diskon_persen}%\n";
            } else {
                $message .= "Diskon: Rp " . number_format($promoClaim->promo->diskon_nominal, 0, ',', '.') . "\n";
            }
            
            $message .= "\nGunakan kode ini saat memesan laundry. Terima kasih!";
            
            return self::sendNotification($user->phone, $message);
            
        } catch (\Exception $e) {
            Log::error('WhatsApp Promo Code Error', [
                'error' => $e->getMessage(),
                'user_id' => $user->id ?? 'unknown'
            ]);
            return false;
        }
    }
    
    public static function getStatusMessage($transaksi)
    {
        $messages = [
            'request_jemput' => "🧺 *JasaLaundry*\n\nHalo {$transaksi->user->name}!\n\nPesanan laundry Anda telah diterima:\n📋 Invoice: {$transaksi->kode_invoice}\n📍 Alamat: {$transaksi->alamat_jemput}\n\nKurir akan segera menghubungi Anda untuk penjemputan.\n\nTerima kasih! 🙏",
            
            'dijemput_kurir' => "🚚 *Update Pesanan*\n\n📋 Invoice: {$transaksi->kode_invoice}\n✅ Status: Dijemput Kurir\n\nPakaian Anda telah dijemput oleh:\n👤 {$transaksi->kurir->name}\n📱 {$transaksi->kurir->phone}\n\nPakaian sedang dalam perjalanan ke tempat pencucian.",
            
            'proses_cuci' => "🧼 *Update Pesanan*\n\n📋 Invoice: {$transaksi->kode_invoice}\n✅ Status: Sedang Dicuci\n\nPakaian Anda sedang dalam proses pencucian.\n⏰ Estimasi selesai: 1-2 hari kerja\n\nKami akan memberitahu Anda saat selesai!",
            
            'siap_antar' => "✨ *Pesanan Selesai!*\n\n📋 Invoice: {$transaksi->kode_invoice}\n✅ Status: Siap Antar\n\nPakaian Anda sudah selesai dicuci dan siap untuk diantar!\n\nKurir akan segera menghubungi Anda untuk pengantaran.",
            
            'selesai' => "🎉 *Pesanan Selesai!*\n\n📋 Invoice: {$transaksi->kode_invoice}\n✅ Status: Selesai Diantar\n\nTerima kasih telah menggunakan layanan JasaLaundry!\n\n⭐ Berikan rating dan review Anda untuk membantu kami berkembang.\n\nSampai jumpa di pesanan berikutnya! 🙏"
        ];
        
        return $messages[$transaksi->status_transaksi] ?? '';
    }
    
    public static function getPaymentMessage($transaksi)
    {
        $baseMessage = "💰 *Informasi Pembayaran*\n\n";
        $baseMessage .= "📋 Invoice: {$transaksi->kode_invoice}\n";
        $baseMessage .= "💵 Total: Rp " . number_format($transaksi->total_harga, 0, ',', '.') . "\n\n";
        
        if ($transaksi->metode_bayar === 'transfer') {
            $baseMessage .= "🏦 *Silakan transfer ke salah satu rekening:*\n\n";
            $baseMessage .= "🔵 *Bank BCA*\n";
            $baseMessage .= "📱 No. Rek: 1234567890\n";
            $baseMessage .= "👤 A.n: JasaLaundry\n\n";
            $baseMessage .= "🔴 *Bank Mandiri*\n";
            $baseMessage .= "📱 No. Rek: 0987654321\n";
            $baseMessage .= "👤 A.n: JasaLaundry\n\n";
            $baseMessage .= "📸 Kirim bukti transfer ke admin untuk konfirmasi pembayaran.\n\n";
            $baseMessage .= "⚠️ *Penting:* Cantumkan kode invoice saat transfer.";
        } else {
            $baseMessage .= "💵 *Pembayaran Tunai (COD)*\n\n";
            $baseMessage .= "Pembayaran akan dilakukan saat pengantaran.\n";
            $baseMessage .= "Pastikan menyiapkan uang pas ya! 😊";
        }
        
        return $baseMessage;
    }
}