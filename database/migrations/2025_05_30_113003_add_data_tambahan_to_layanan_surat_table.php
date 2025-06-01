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
            $table->json('data_tambahan')->nullable()->after('keperluan_surat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layanan_surat', function (Blueprint $table) {
            $table->dropColumn('data_tambahan');
        });
    }
};
