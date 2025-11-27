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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->timestamp('tanggal_proses_cuci')->nullable()->after('tanggal_jemput');
            $table->timestamp('tanggal_siap_antar')->nullable()->after('tanggal_proses_cuci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['tanggal_proses_cuci', 'tanggal_siap_antar']);
        });
    }
};