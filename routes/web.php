<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\KurirController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Pelanggan Routes
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('dashboard');
    Route::get('/order', [PelangganController::class, 'showOrderForm'])->name('order');
    Route::post('/order', [PelangganController::class, 'storeOrder'])->name('order.store');
    Route::get('/riwayat', [PelangganController::class, 'riwayat'])->name('riwayat');
    Route::get('/transaksi/{transaksi}', [PelangganController::class, 'show'])->name('transaksi.show');
    Route::post('/promo/klaim', [PelangganController::class, 'klaimPromo'])->name('promo.klaim');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('paket', PaketController::class);
    Route::resource('transaksi', \App\Http\Controllers\Admin\TransaksiController::class);
    Route::resource('kurir', \App\Http\Controllers\Admin\KurirController::class);
    Route::resource('promo', \App\Http\Controllers\Admin\PromoController::class);
    Route::get('/promo-claim', [\App\Http\Controllers\Admin\PromoClaimController::class, 'index'])->name('promo-claim.index');
    Route::patch('/promo-claim/{claim}/approve', [\App\Http\Controllers\Admin\PromoClaimController::class, 'approve'])->name('promo-claim.approve');
    Route::patch('/promo-claim/{claim}/reject', [\App\Http\Controllers\Admin\PromoClaimController::class, 'reject'])->name('promo-claim.reject');
    Route::get('/user/{userId}/transactions', [\App\Http\Controllers\Admin\PromoClaimController::class, 'getUserTransactions'])->name('user.transactions');
    Route::get('/riwayat', [\App\Http\Controllers\Admin\RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{transaksi}/cetak', [\App\Http\Controllers\Admin\RiwayatController::class, 'cetak'])->name('riwayat.cetak');
    Route::get('/riwayat/cetak-laporan', [\App\Http\Controllers\Admin\RiwayatController::class, 'cetakLaporan'])->name('riwayat.cetak-laporan');
    Route::get('/riwayat/export', [\App\Http\Controllers\Admin\RiwayatController::class, 'export'])->name('riwayat.export');
});

// Kurir Routes
Route::middleware(['auth', 'role:kurir'])->prefix('kurir')->name('kurir.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\KurirController::class, 'dashboard'])->name('dashboard');
    Route::get('/tugas', [\App\Http\Controllers\KurirController::class, 'tugas'])->name('tugas');
    Route::get('/transaksi/{transaksi}', [\App\Http\Controllers\KurirController::class, 'show'])->name('transaksi.show');
    Route::patch('/transaksi/{transaksi}/status', [\App\Http\Controllers\KurirController::class, 'updateStatus'])->name('transaksi.status');
});


