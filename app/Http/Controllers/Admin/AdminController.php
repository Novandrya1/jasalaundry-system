<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Paket;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPesananHariIni = Transaksi::whereDate('created_at', Carbon::today())->count();
        $pesananBaru = Transaksi::where('status_transaksi', 'request_jemput')
            ->whereDate('created_at', Carbon::today())
            ->count();
        $pendapatanBulanIni = Transaksi::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status_bayar', 'lunas')
            ->sum('total_harga');
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        
        $transaksiTerbaru = Transaksi::with(['user', 'detailTransaksis.paket'])
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPesananHariIni',
            'pesananBaru', 
            'pendapatanBulanIni',
            'totalPelanggan',
            'transaksiTerbaru'
        ));
    }
}
