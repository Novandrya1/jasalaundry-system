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
        
        // Filter berdasarkan tanggal - default hari ini jika tidak ada filter
        if ($request->tanggal_mulai || $request->tanggal_selesai) {
            if ($request->tanggal_mulai) {
                $startDate = Carbon::parse($request->tanggal_mulai)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            }
            if ($request->tanggal_selesai) {
                $endDate = Carbon::parse($request->tanggal_selesai)->endOfDay();
                $query->where('created_at', '<=', $endDate);
            }
        } else {
            // Default: tampilkan transaksi hari ini saja
            $today = Carbon::today();
            $query->whereBetween('created_at', [$today->startOfDay(), $today->copy()->endOfDay()]);
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
        
        // Statistik berdasarkan filter yang sama
        $statistikQuery = Transaksi::query();
        
        // Apply same filters for statistics
        if ($request->status) {
            $statistikQuery->where('status_transaksi', $request->status);
        }
        if ($request->status_bayar) {
            $statistikQuery->where('status_bayar', $request->status_bayar);
        }
        if ($request->tanggal_mulai || $request->tanggal_selesai) {
            if ($request->tanggal_mulai) {
                $startDate = Carbon::parse($request->tanggal_mulai)->startOfDay();
                $statistikQuery->where('created_at', '>=', $startDate);
            }
            if ($request->tanggal_selesai) {
                $endDate = Carbon::parse($request->tanggal_selesai)->endOfDay();
                $statistikQuery->where('created_at', '<=', $endDate);
            }
        } else {
            $today = Carbon::today();
            $statistikQuery->whereBetween('created_at', [$today->startOfDay(), $today->copy()->endOfDay()]);
        }
        if ($request->kurir_id) {
            $statistikQuery->where('kurir_id', $request->kurir_id);
        }
        if ($request->metode_bayar) {
            $statistikQuery->where('metode_bayar', $request->metode_bayar);
        }
        
        $totalTransaksi = $statistikQuery->count();
        $totalPendapatan = (clone $statistikQuery)->where('status_bayar', 'lunas')->sum('total_harga');
        
        // Analytics data berdasarkan filter
        $pendapatanBulanIni = Transaksi::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status_bayar', 'lunas')
            ->sum('total_harga') ?? 0;
            
        // Hitung rata-rata berdasarkan periode filter
        $rataRataHarian = 0;
        if ($request->tanggal_mulai && $request->tanggal_selesai) {
            $startDate = Carbon::parse($request->tanggal_mulai);
            $endDate = Carbon::parse($request->tanggal_selesai);
            $daysDiff = $startDate->diffInDays($endDate) + 1;
            $rataRataHarian = $daysDiff > 0 ? $totalPendapatan / $daysDiff : 0;
        } else {
            $rataRataHarian = $totalPendapatan; // Hari ini
        }
        
        // Data untuk grafik berdasarkan filter
        if ($request->tanggal_mulai && $request->tanggal_selesai) {
            $startDate = Carbon::parse($request->tanggal_mulai);
            $endDate = Carbon::parse($request->tanggal_selesai);
            $daysDiff = $startDate->diffInDays($endDate);
            
            $chartLabels = [];
            $chartData = [];
            
            if ($daysDiff <= 7) {
                for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                    $chartLabels[] = $date->format('d/m');
                    
                    // Query dengan filter yang sama seperti main query
                    $chartQuery = Transaksi::whereBetween('created_at', [$date->startOfDay(), $date->copy()->endOfDay()])
                        ->where('status_bayar', 'lunas');
                    
                    if ($request->status) {
                        $chartQuery->where('status_transaksi', $request->status);
                    }
                    if ($request->kurir_id) {
                        $chartQuery->where('kurir_id', $request->kurir_id);
                    }
                    if ($request->metode_bayar) {
                        $chartQuery->where('metode_bayar', $request->metode_bayar);
                    }
                    
                    $pendapatan = $chartQuery->sum('total_harga') ?? 0;
                    $chartData[] = (float) $pendapatan;
                }
            } else {
                $weeks = ceil($daysDiff / 7);
                for ($i = 0; $i < $weeks; $i++) {
                    $weekStart = $startDate->copy()->addWeeks($i);
                    $weekEnd = $weekStart->copy()->addDays(6);
                    if ($weekEnd > $endDate) $weekEnd = $endDate;
                    
                    $chartLabels[] = $weekStart->format('d/m') . '-' . $weekEnd->format('d/m');
                    
                    // Query dengan filter yang sama seperti main query
                    $chartQuery = Transaksi::whereBetween('created_at', [$weekStart, $weekEnd->endOfDay()])
                        ->where('status_bayar', 'lunas');
                    
                    if ($request->status) {
                        $chartQuery->where('status_transaksi', $request->status);
                    }
                    if ($request->kurir_id) {
                        $chartQuery->where('kurir_id', $request->kurir_id);
                    }
                    if ($request->metode_bayar) {
                        $chartQuery->where('metode_bayar', $request->metode_bayar);
                    }
                    
                    $pendapatan = $chartQuery->sum('total_harga') ?? 0;
                    $chartData[] = (float) $pendapatan;
                }
            }
        } else {
            $chartLabels = [];
            $chartData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $chartLabels[] = $date->format('d/m');
                
                // Query dengan filter yang sama seperti main query
                $chartQuery = Transaksi::whereBetween('created_at', [$date->startOfDay(), $date->copy()->endOfDay()])
                    ->where('status_bayar', 'lunas');
                
                if ($request->status) {
                    $chartQuery->where('status_transaksi', $request->status);
                }
                if ($request->kurir_id) {
                    $chartQuery->where('kurir_id', $request->kurir_id);
                }
                if ($request->metode_bayar) {
                    $chartQuery->where('metode_bayar', $request->metode_bayar);
                }
                
                $pendapatan = $chartQuery->sum('total_harga') ?? 0;
                $chartData[] = (float) $pendapatan;
            }
        }
        
        // Data untuk grafik status transaksi berdasarkan filter
        $statusLabels = ['Menunggu', 'Dijemput', 'Proses', 'Siap Antar', 'Selesai'];
        $statusQuery = Transaksi::query();
        
        if ($request->status) {
            $statusQuery->where('status_transaksi', $request->status);
        }
        if ($request->status_bayar) {
            $statusQuery->where('status_bayar', $request->status_bayar);
        }
        if ($request->tanggal_mulai || $request->tanggal_selesai) {
            if ($request->tanggal_mulai) {
                $startDate = Carbon::parse($request->tanggal_mulai)->startOfDay();
                $statusQuery->where('created_at', '>=', $startDate);
            }
            if ($request->tanggal_selesai) {
                $endDate = Carbon::parse($request->tanggal_selesai)->endOfDay();
                $statusQuery->where('created_at', '<=', $endDate);
            }
        } else {
            $today = Carbon::today();
            $statusQuery->whereBetween('created_at', [$today->startOfDay(), $today->copy()->endOfDay()]);
        }
        if ($request->kurir_id) {
            $statusQuery->where('kurir_id', $request->kurir_id);
        }
        if ($request->metode_bayar) {
            $statusQuery->where('metode_bayar', $request->metode_bayar);
        }
        
        $statusData = [
            (clone $statusQuery)->where('status_transaksi', 'request_jemput')->count(),
            (clone $statusQuery)->where('status_transaksi', 'dijemput_kurir')->count(),
            (clone $statusQuery)->where('status_transaksi', 'proses_cuci')->count(),
            (clone $statusQuery)->where('status_transaksi', 'siap_antar')->count(),
            (clone $statusQuery)->where('status_transaksi', 'selesai')->count(),
        ];
        
        // Pastikan ada data minimal untuk grafik
        if (array_sum($statusData) === 0) {
            $statusData = [0, 0, 0, 0, 0]; // Data kosong untuk grafik
        }
        
        if (array_sum($chartData) === 0) {
            $chartData = array_fill(0, count($chartLabels), 0);
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
