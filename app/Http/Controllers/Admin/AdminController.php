<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ==============================
        // STATISTIK UTAMA
        // ==============================

        // Total pesanan hari ini
        $totalPesananHariIni = Transaksi::whereDate(
            'created_at',
            Carbon::today()
        )->count();

        // Pesanan baru hari ini
        $pesananBaru = Transaksi::where(
            'status_transaksi',
            'request_jemput'
        )
        ->whereDate('created_at', Carbon::today())
        ->count();

        // Pendapatan bulan ini
        $pendapatanBulanIni = Transaksi::whereMonth(
            'created_at',
            Carbon::now()->month
        )
        ->whereYear(
            'created_at',
            Carbon::now()->year
        )
        ->where(
            'status_bayar',
            'lunas'
        )
        ->sum('total_harga');


        // ==============================
        // STATUS PEKERJAAN
        // ==============================

        // Menunggu penjemputan
        $menungguPenjemputan = Transaksi::where(
            'status_transaksi',
            'request_jemput'
        )->count();

        // Dijemput kurir
        $dijemputKurir = Transaksi::where(
            'status_transaksi',
            'dijemput_kurir'
        )->count();

        // Sedang dicuci
        $prosesCuci = Transaksi::where(
            'status_transaksi',
            'proses_cuci'
        )->count();

        // Siap diantar
        $siapAntar = Transaksi::where(
            'status_transaksi',
            'siap_antar'
        )->count();

        // Selesai
        $selesai = Transaksi::where(
            'status_transaksi',
            'selesai'
        )->count();


        // ==============================
        // TRANSAKSI TERBARU
        // ==============================

        $transaksiTerbaru = Transaksi::with([
            'user',
            'detailTransaksis.paket'
        ])
        ->whereDate(
            'created_at',
            Carbon::today()
        )
        ->orderBy(
            'created_at',
            'desc'
        )
        ->limit(5)
        ->get();


        // ==============================
        // KIRIM DATA KE DASHBOARD
        // ==============================

        return view('admin.dashboard', compact(
            'totalPesananHariIni',
            'pesananBaru',
            'pendapatanBulanIni',

            'menungguPenjemputan',
            'dijemputKurir',
            'prosesCuci',
            'siapAntar',
            'selesai',

            'transaksiTerbaru'
        ));
    }
}