<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoClaim;
use Illuminate\Http\Request;

class PromoClaimController extends Controller
{
    public function index()
    {
        $claims = PromoClaim::with(['user', 'promo'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.promo-claim.index', compact('claims'));
    }
    
    public function approve(PromoClaim $claim)
    {
        $claim->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);
        
        // Generate WhatsApp message
        $message = "Selamat! Promo '{$claim->promo->judul}' Anda telah disetujui.\n\nKode Promo: {$claim->kode_promo}\n\nGunakan kode ini saat memesan laundry untuk mendapat diskon {$claim->promo->diskon_text}.\n\nTerima kasih - JasaLaundry";
        
        $whatsappUrl = \App\Services\WhatsAppService::sendNotification(
            $claim->user->phone,
            $message
        );
        
        return redirect()->route('admin.promo-claim.index')
            ->with('success', 'Promo berhasil disetujui!')
            ->with('whatsapp_url', $whatsappUrl);
    }
    
    public function reject(PromoClaim $claim)
    {
        $claim->update([
            'status' => 'rejected',
        ]);
        
        // Generate WhatsApp message
        $message = "Maaf, klaim promo '{$claim->promo->judul}' Anda ditolak karena tidak memenuhi syarat dan ketentuan.\n\nSilakan coba promo lainnya.\n\nTerima kasih - JasaLaundry";
        
        $whatsappUrl = \App\Services\WhatsAppService::sendNotification(
            $claim->user->phone,
            $message
        );
        
        return redirect()->route('admin.promo-claim.index')
            ->with('success', 'Promo berhasil ditolak!')
            ->with('whatsapp_url', $whatsappUrl);
    }
    
    public function getUserTransactions($userId)
    {
        $transactions = \App\Models\Transaksi::where('user_id', $userId)
            ->select('kode_invoice', 'status_transaksi as status', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        return response()->json([
            'transactions' => $transactions,
            'total' => \App\Models\Transaksi::where('user_id', $userId)->count()
        ]);
    }
}
