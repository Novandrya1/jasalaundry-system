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
            $table->enum('metode_bayar', ['tunai', 'transfer'])->default('tunai')->after('status_bayar');
            $table->string('bukti_transfer')->nullable()->after('metode_bayar');
            $table->text('bank_info')->nullable()->after('bukti_transfer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['metode_bayar', 'bukti_transfer', 'bank_info']);
        });
    }
};
