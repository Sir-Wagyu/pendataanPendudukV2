<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penduduk_pendatang extends Model
{
    protected $table = 'penduduk_pendatang';
    protected $fillable = [
        'id_penanggungJawab',
        'id_kepalaLingkungan',
        'status_akun',
        'alasan_penolakan',
        'foto_ktp',
        'foto_selfie_ktp',
        'nik',
        'nama_lengkap',
        'telepon',
        'status_perkawinan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'golongan_darah',
        'agama',
        'provinsi_asal',
        'kabupaten_asal',
        'kecamatan_asal',
        'kelurahan_asal',
        'rw_asal',
        'rt_asal',
        'alamat_asal',
        'alamat_sekarang',
        'latitude',
        'longitude',
        'tujuan',
        'tanggal_masuk',
        'tanggal_keluar'
    ];

}
