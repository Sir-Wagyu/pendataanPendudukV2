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
        Schema::create('layanan_surat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penduduk_pendatang');
            $table->unsignedBigInteger('id_penanggungJawab_pemohon');
            $table->unsignedBigInteger('id_kepalaLingkungan_penyetuju')->nullable();

            $table->enum('jenis_surat', [
                'surat_keterangan_domisili',
                'surat_pengantar_umum',
                'surat_pengantar_skck',
                'surat_keterangan_kehilangan_lokal',
                'surat_keterangan_untuk_sekolah_anak'
            ]);
            $table->text('keperluan_surat')->nullable();
            $table->enum('status_pengajuan', [
                'diajukan',
                'disetujui',
                'ditolak',
                'dibatalkan',
            ])->default('diajukan');
            $table->text('catatan_kepalaLingkungan')->nullable();

            $table->string('nomor_surat_terbitan')->nullable()->unique();
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_surat_diterbitkan')->nullable();
            $table->date('tanggal_surat_dicetak_pertama')->nullable();

            $table->foreign('id_penduduk_pendatang')->references('id')->on('penduduk_pendatang')->onDelete('cascade');
            $table->foreign('id_penanggungJawab_pemohon')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kepalaLingkungan_penyetuju')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_surat');
    }
};
