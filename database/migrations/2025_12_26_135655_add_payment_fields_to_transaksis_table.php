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
            $table->string('snap_token')->nullable()->after('metode_bayar');
            $table->string('payment_url')->nullable()->after('snap_token');
            $table->timestamp('paid_at')->nullable()->after('payment_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'payment_url', 'paid_at']);
        });
    }
};
