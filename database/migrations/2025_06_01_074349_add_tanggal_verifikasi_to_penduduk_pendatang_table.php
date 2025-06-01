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
        Schema::table('penduduk_pendatang', function (Blueprint $table) {
            $table->date('tanggal_verifikasi')->nullable()->after('tanggal_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduk_pendatang', function (Blueprint $table) {
            $table->dropColumn('tanggal_verifikasi');
        });
    }
};
