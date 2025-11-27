<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class KurirController extends Controller
{
    public function dashboard()
    {
        $kurirId = Auth::id();
        
        $tugasBaru = Transaksi::where('kurir_id', $kurirId)
            ->where('status_transaksi', 'dijemput_kurir')
            ->count();
            
        $tugasProses = Transaksi::where('kurir_id', $kurirId)
            ->whereIn('status_transaksi', ['proses_cuci', 'siap_antar'])
            ->count();
            
        $tugasSelesai = Transaksi::where('kurir_id', $kurirId)
            ->where('status_transaksi', 'selesai')
            ->count();
            
        $transaksiTerbaru = Transaksi::with(['user', 'detailTransaksis.paket'])
            ->where('kurir_id', $kurirId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        return view('kurir.dashboard', compact(
            'tugasBaru', 'tugasProses', 'tugasSelesai', 'transaksiTerbaru'
        ));
    }
    
    public function tugas(Request $request)
    {
        $query = Transaksi::with(['user', 'detailTransaksis.paket'])
            ->where('kurir_id', Auth::id());
            
        if ($request->status) {
            $query->where('status_transaksi', $request->status);
        }
        
        $transaksis = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('kurir.tugas', compact('transaksis'));
    }
    
    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        if ($transaksi->kurir_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }
        
        $request->validate([
            'status_transaksi' => 'required|in:dijemput_kurir,siap_antar,selesai',
        ]);
        
        $transaksi->update([
            'status_transaksi' => $request->status_transaksi,
            'tanggal_selesai' => $request->status_transaksi === 'selesai' ? now() : null,
        ]);
        
        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
