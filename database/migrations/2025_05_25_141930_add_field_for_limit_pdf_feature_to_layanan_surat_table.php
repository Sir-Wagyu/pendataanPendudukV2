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
        Schema::table('layanan_surat', function (Blueprint $table) {
            $table->date('cetak_sebelum_tanggal')->nullable()->after('tanggal_surat_diterbitkan');
            $table->integer('maksimal_generate_pdf')->nullable()->default(10)->after('cetak_sebelum_tanggal');
            $table->integer('jumlah_sudah_digenerate')->default(0)->after('maksimal_generate_pdf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layanan_surat', function (Blueprint $table) {
            $table->dropColumn('cetak_sebelum_tanggal');
            $table->dropColumn('maksimal_generate_pdf');
            $table->dropColumn('jumlah_sudah_digenerate');
        });
    }
};
