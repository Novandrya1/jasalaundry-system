<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_invoice')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kurir_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('berat_aktual', 8, 2)->nullable();
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->enum('status_transaksi', ['request_jemput', 'dijemput_kurir', 'proses_cuci', 'siap_antar', 'selesai'])->default('request_jemput');
            $table->enum('status_bayar', ['belum_bayar', 'lunas'])->default('belum_bayar');
            $table->text('alamat_jemput');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_jemput')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
