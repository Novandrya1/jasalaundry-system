<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->unsignedBigInteger('promo_claim_id')->nullable()->after('metode_bayar');
            $table->decimal('diskon', 10, 2)->default(0)->after('promo_claim_id');
            
            $table->foreign('promo_claim_id')->references('id')->on('promo_claims')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['promo_claim_id']);
            $table->dropColumn(['promo_claim_id', 'diskon']);
        });
    }
};