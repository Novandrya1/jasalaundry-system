<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'kurir', 'detailTransaksis.paket']);
        
        // Filter berdasarkan status
        if ($request->status) {
            $query->where('status_transaksi', $request->status);
        }
        
        // Filter berdasarkan status bayar
        if ($request->status_bayar) {
            $query->where('status_bayar', $request->status_bayar);
        }
        
        // Filter berdasarkan tanggal
        if ($request->tanggal_mulai) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->tanggal_selesai) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        // Filter berdasarkan kurir
        if ($request->kurir_id) {
            $query->where('kurir_id', $request->kurir_id);
        }
        
        // Filter berdasarkan metode bayar
        if ($request->metode_bayar) {
            $query->where('metode_bayar', $request->metode_bayar);
        }
        
        $transaksis = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Data untuk filter
        $kurirs = \App\Models\User::where('role', 'kurir')->get();
        
        // Statistik
        $totalTransaksi = $query->count();
        $totalPendapatan = $query->where('status_bayar', 'lunas')->sum('total_harga');
        
        // Analytics data
        $pendapatanBulanIni = Transaksi::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status_bayar', 'lunas')
            ->sum('total_harga') ?? 0;
            
        $totalHarian = Transaksi::where('status_bayar', 'lunas')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
            ->sum('total_harga') ?? 0;
        $rataRataHarian = $totalHarian > 0 ? $totalHarian / 30 : 0;
        
        // Data untuk grafik pendapatan 7 hari terakhir
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d/m');
            $pendapatan = Transaksi::whereDate('created_at', $date)
                ->where('status_bayar', 'lunas')
                ->sum('total_harga') ?? 0;
            $chartData[] = (float) $pendapatan;
        }
        
        // Data untuk grafik status transaksi
        $statusLabels = ['Menunggu', 'Dijemput', 'Proses', 'Siap Antar', 'Selesai'];
        $statusData = [
            Transaksi::where('status_transaksi', 'request_jemput')->count(),
            Transaksi::where('status_transaksi', 'dijemput_kurir')->count(),
            Transaksi::where('status_transaksi', 'proses_cuci')->count(),
            Transaksi::where('status_transaksi', 'siap_antar')->count(),
            Transaksi::where('status_transaksi', 'selesai')->count(),
        ];
        
        // Pastikan ada data minimal untuk grafik
        if (array_sum($statusData) === 0) {
            $statusData = [1, 0, 0, 0, 0]; // Dummy data agar grafik muncul
        }
        
        if (array_sum($chartData) === 0) {
            $chartData = [0, 0, 0, 0, 0, 0, 0]; // Dummy data agar grafik muncul
        }
        
        return view('admin.riwayat.index', compact(
            'transaksis', 'kurirs', 'totalTransaksi', 'totalPendapatan',
            'pendapatanBulanIni', 'rataRataHarian', 'chartLabels', 'chartData',
            'statusLabels', 'statusData'
        ));
    }
    
    public function cetak(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'kurir', 'detailTransaksis.paket']);
        return view('admin.riwayat.cetak', compact('transaksi'));
    }
    
    public function cetakLaporan(Request $request)
    {
        $query = Transaksi::with(['user', 'kurir', 'detailTransaksis.paket']);
        
        // Apply same filters as index
        if ($request->status) {
            $query->where('status_transaksi', $request->status);
        }
        if ($request->status_bayar) {
            $query->where('status_bayar', $request->status_bayar);
        }
        if ($request->tanggal_mulai) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_selesai) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        if ($request->kurir_id) {
            $query->where('kurir_id', $request->kurir_id);
        }
        if ($request->metode_bayar) {
            $query->where('metode_bayar', $request->metode_bayar);
        }
        
        $transaksis = $query->orderBy('created_at', 'desc')->get();
        $totalPendapatan = $transaksis->where('status_bayar', 'lunas')->sum('total_harga');
        
        return view('admin.riwayat.cetak-laporan', compact('transaksis', 'totalPendapatan', 'request'));
    }
}
