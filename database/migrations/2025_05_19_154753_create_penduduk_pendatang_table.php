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
        Schema::create('penduduk_pendatang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penanggungJawab');
            $table->unsignedBigInteger('id_kepalaLingkungan');
            $table->enum('status_akun', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->text('alasan_penolakan')->nullable();
            $table->string('foto_ktp');
            $table->string('foto_selfie_ktp');
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->string('telepon');
            $table->enum('status_perkawinan', ['belum_kawin', 'kawin', 'cerai']);
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('golongan_darah')->nullable();
            $table->string('agama');
            $table->string('provinsi_asal');
            $table->string('kabupaten_asal');
            $table->string('kecamatan_asal');
            $table->string('kelurahan_asal');
            $table->string('rw_asal');
            $table->string('rt_asal');
            $table->string('alamat_asal');
            $table->string('alamat_sekarang');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('tujuan');
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();

            $table->foreign('id_penanggungJawab')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kepalaLingkungan')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk_pendatang');
    }
};
