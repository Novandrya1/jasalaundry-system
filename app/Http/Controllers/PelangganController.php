<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\PromoClaim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PelangganController extends Controller
{
    public function dashboard()
    {
        $pakets = Paket::active()->get();
        $promos = \App\Models\Promo::active()->latest()->limit(3)->get();
        return view('pelanggan.dashboard', compact('pakets', 'promos'));
    }

    public function showOrderForm()
    {
        $pakets = Paket::active()->get();
        return view('pelanggan.order', compact('pakets'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'alamat_jemput' => 'required|string',
            'catatan' => 'nullable|string',
            'metode_bayar' => 'required|in:tunai,transfer',
            'kode_promo' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $promoClaimId = null;
            $diskonAmount = 0;
            
            // Validasi kode promo jika ada
            if ($request->kode_promo) {
                $promoClaim = PromoClaim::where('kode_promo', $request->kode_promo)
                    ->where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->where('is_used', false)
                    ->first();
                    
                if (!$promoClaim) {
                    return back()->withErrors(['kode_promo' => 'Kode promo tidak valid atau sudah digunakan.']);
                }
                
                $promoClaimId = $promoClaim->id;
                $promo = $promoClaim->promo;
                
                // Hitung diskon berdasarkan tipe
                if ($promo->tipe_diskon === 'nominal') {
                    $diskonAmount = $promo->diskon_nominal;
                } else {
                    // Untuk diskon persen, hitung berdasarkan subtotal paket
                    $paket = Paket::find($request->paket_id);
                    $subtotal = $paket->harga_per_kg; // Default 1 kg
                    $diskonAmount = ($subtotal * $promo->diskon_persen) / 100;
                }
            }

            // Buat transaksi
            $transaksi = Transaksi::create([
                'kode_invoice' => Transaksi::generateKodeInvoice(),
                'user_id' => Auth::id(),
                'alamat_jemput' => $request->alamat_jemput,
                'catatan' => $request->catatan,
                'status_transaksi' => 'request_jemput',
                'status_bayar' => 'belum_bayar',
                'metode_bayar' => $request->metode_bayar,
                'promo_claim_id' => $promoClaimId,
                'diskon' => $diskonAmount,
            ]);

            // Buat detail transaksi
            $paket = Paket::find($request->paket_id);
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'paket_id' => $paket->id,
                'jumlah' => 1, // Default 1, akan diupdate admin setelah penimbangan
                'harga_satuan' => $paket->harga_per_kg,
                'subtotal' => $paket->harga_per_kg,
            ]);

            $transaksi->hitungTotalHarga();
            
            // Tandai promo sebagai digunakan
            if ($promoClaimId) {
                PromoClaim::find($promoClaimId)->update(['is_used' => true]);
            }

            DB::commit();
            
            return redirect()->route('pelanggan.riwayat')
                ->with('success', 'Pesanan berhasil dibuat! Kode Invoice: ' . $transaksi->kode_invoice);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating order: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
        }
    }

    public function riwayat()
    {
        $transaksis = Transaksi::with(['detailTransaksis.paket', 'kurir'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pelanggan.riwayat', compact('transaksis'));
    }

    public function show(Transaksi $transaksi)
    {
        // Pastikan transaksi milik user yang login
        if ($transaksi->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }
        
        $transaksi->load(['user', 'kurir', 'detailTransaksis.paket', 'promoClaim.promo']);
        return view('pelanggan.detail-transaksi', compact('transaksi'));
    }

    public function klaimPromo(Request $request)
    {
        $request->validate([
            'promo_id' => 'required|exists:promos,id',
        ]);

        $promo = \App\Models\Promo::find($request->promo_id);
        
        // Cek apakah user sudah pernah klaim promo ini
        $existingClaim = \App\Models\PromoClaim::where('user_id', Auth::id())
            ->where('promo_id', $promo->id)
            ->first();
            
        if ($existingClaim) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah pernah mengklaim promo ini.'
            ]);
        }

        // Buat klaim promo baru
        $claim = \App\Models\PromoClaim::create([
            'user_id' => Auth::id(),
            'promo_id' => $promo->id,
            'kode_promo' => \App\Models\PromoClaim::generateKodePromo(),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Promo berhasil diklaim! Menunggu persetujuan admin.'
        ]);
    }
}
