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
        Schema::table('promos', function (Blueprint $table) {
            $table->decimal('diskon_persen', 5, 2)->default(0)->after('deskripsi');
            $table->decimal('diskon_nominal', 10, 2)->default(0)->after('diskon_persen');
            $table->enum('tipe_diskon', ['persen', 'nominal'])->default('persen')->after('diskon_nominal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropColumn(['diskon_persen', 'diskon_nominal', 'tipe_diskon']);
        });
    }
};
