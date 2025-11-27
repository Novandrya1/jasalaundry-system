<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'kurir', 'detailTransaksis.paket', 'promoClaim.promo']);
        
        // Filter berdasarkan status
        if ($request->status) {
            $query->where('status_transaksi', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }
        
        $transaksis = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'kurir', 'detailTransaksis.paket', 'promoClaim.promo']);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'kurir', 'detailTransaksis.paket', 'promoClaim.promo']);
        $kurirs = User::where('role', 'kurir')->get();
        
        return view('admin.transaksi.edit', compact('transaksi', 'kurirs'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'berat_aktual' => 'nullable|numeric|min:0',
            'status_transaksi' => 'required|in:request_jemput,dijemput_kurir,proses_cuci,siap_antar,selesai',
            'status_bayar' => 'required|in:belum_bayar,lunas',
            'kurir_id' => 'nullable|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            // Update data transaksi
            $oldStatus = $transaksi->status_transaksi;
            
            $transaksi->update([
                'berat_aktual' => $request->berat_aktual,
                'status_transaksi' => $request->status_transaksi,
                'status_bayar' => $request->status_bayar,
                'kurir_id' => $request->kurir_id,
                'tanggal_jemput' => $request->status_transaksi === 'dijemput_kurir' ? now() : $transaksi->tanggal_jemput,
                'tanggal_selesai' => $request->status_transaksi === 'selesai' ? now() : $transaksi->tanggal_selesai,
            ]);

            // Hitung ulang total harga jika berat aktual diubah
            if ($request->berat_aktual) {
                foreach ($transaksi->detailTransaksis as $detail) {
                    $detail->update([
                        'jumlah' => $request->berat_aktual,
                        'subtotal' => $request->berat_aktual * $detail->harga_satuan,
                    ]);
                }
                $transaksi->hitungTotalHarga();
            }

            DB::commit();
            
            // Kirim notifikasi WhatsApp jika status berubah
            if ($oldStatus !== $request->status_transaksi) {
                $whatsappUrl = \App\Services\WhatsAppService::sendNotification(
                    $transaksi->user->phone,
                    \App\Services\WhatsAppService::getStatusMessage($transaksi)
                );
                
                return redirect()->route('admin.transaksi.index')
                    ->with('success', 'Transaksi berhasil diperbarui.')
                    ->with('whatsapp_url', $whatsappUrl);
            }
            
            return redirect()->route('admin.transaksi.index')
                ->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi.');
        }
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
