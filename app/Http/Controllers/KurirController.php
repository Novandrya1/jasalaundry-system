<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KurirController extends Controller
{
    public function dashboard()
    {
        $kurirId = Auth::id();
        $today = Carbon::today();
        
        // Tugas baru hari ini (status dijemput_kurir)
        $tugasBaru = Transaksi::where('kurir_id', $kurirId)
            ->where('status_transaksi', 'dijemput_kurir')
            ->whereDate('created_at', $today)
            ->count();
            
        // Tugas dalam proses (proses_cuci dan siap_antar)
        $tugasProses = Transaksi::where('kurir_id', $kurirId)
            ->whereIn('status_transaksi', ['proses_cuci', 'siap_antar'])
            ->count();
            
        // Tugas selesai hari ini
        $tugasSelesai = Transaksi::where('kurir_id', $kurirId)
            ->where('status_transaksi', 'selesai')
            ->whereDate('updated_at', $today)
            ->count();
            
        // Total semua tugas kurir
        $totalTugas = Transaksi::where('kurir_id', $kurirId)->count();
            
        // Transaksi hari ini (semua status) - untuk ditampilkan di "Tugas Hari Ini"
        $transaksiTerbaru = Transaksi::with(['user', 'detailTransaksis.paket'])
            ->where('kurir_id', $kurirId)
            ->where(function($query) use ($today) {
                $query->whereDate('created_at', $today)
                      ->orWhere(function($q) use ($today) {
                          $q->whereIn('status_transaksi', ['siap_antar', 'dijemput_kurir'])
                            ->whereDate('updated_at', $today);
                      });
            })
            ->orderByRaw("CASE 
                WHEN status_transaksi = 'dijemput_kurir' THEN 1
                WHEN status_transaksi = 'siap_antar' THEN 2
                WHEN status_transaksi = 'proses_cuci' THEN 3
                WHEN status_transaksi = 'selesai' THEN 4
                ELSE 5
            END")
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
            
        return view('kurir.dashboard', compact(
            'tugasBaru', 'tugasProses', 'tugasSelesai', 'totalTugas', 'transaksiTerbaru'
        ));
    }
    
    public function tugas(Request $request)
    {
        $query = Transaksi::with(['user', 'detailTransaksis.paket'])
            ->where('kurir_id', Auth::id());
            
        if ($request->status) {
            $query->where('status_transaksi', $request->status);
        }
        
        $transaksis = $query->orderByRaw("CASE 
            WHEN status_transaksi = 'dijemput_kurir' THEN 1
            WHEN status_transaksi = 'siap_antar' THEN 2
            WHEN status_transaksi = 'proses_cuci' THEN 3
            WHEN status_transaksi = 'selesai' THEN 4
            ELSE 5
        END")
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        return view('kurir.tugas', compact('transaksis'));
    }
    
    public function show(Transaksi $transaksi)
    {
        // Pastikan transaksi ditugaskan ke kurir yang login
        if ($transaksi->kurir_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }
        
        $transaksi->load(['user', 'kurir', 'detailTransaksis.paket', 'promoClaim.promo']);
        return view('kurir.detail-transaksi', compact('transaksi'));
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
