<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE layanan_surat MODIFY COLUMN status_pengajuan ENUM('diajukan', 'disetujui', 'ditolak', 'dibatalkan', 'selesai') NOT NULL DEFAULT 'diajukan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE layanan_surat MODIFY COLUMN status_pengajuan ENUM('diajukan', 'disetujui', 'ditolak', 'dibatalkan') NOT NULL DEFAULT 'diajukan'");
    }
};
