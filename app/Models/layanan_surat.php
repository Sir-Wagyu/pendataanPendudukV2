<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class layanan_surat extends Model
{
    use HasFactory;

    protected $table = 'layanan_surat';

    protected $fillable = [
        'id_penduduk_pendatang',
        'id_penanggungJawab_pemohon',
        'id_kepalaLingkungan_penyetuju',
        'jenis_surat',
        'keperluan_surat',
        'status_pengajuan',
        'catatan_kepalaLingkungan',
        'nomor_surat_terbitan',
        'tanggal_pengajuan',
        'tanggal_surat_diterbitkan',
        'tanggal_surat_dicetak_pertama',
        'cetak_sebelum_tanggal',
        'maksimal_generate_pdf'
    ];

    public function penduduk()
    {
        return $this->belongsTo(penduduk_pendatang::class, 'id_penduduk_pendatang');
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'id_penanggungJawab_pemohon');
    }

    public function kepalaLingkungan()
    {
        return $this->belongsTo(User::class, 'id_kepalaLingkungan_penyetuju');
    }

    public static function getJenisSuratEnum()
    {
        try {
            $type = DB::select("SHOW COLUMNS FROM layanan_surat WHERE Field = 'jenis_surat'")[0]->Type;
            preg_match('/^enum\((.*)\)$/', $type, $matches);
            return str_getcsv($matches[1], ',', "'");
        } catch (\Exception $e) {
            // Fallback jika gagal mengambil dari database
            return [
                'surat_keterangan_domisili',
                'surat_pengantar_umum',
                'surat_pengantar_skck',
                'surat_keterangan_kehilangan_lokal',
                'surat_keterangan_untuk_sekolah_anak'
            ];
        }
    }

    public static function getJenisSuratOptions()
    {
        $enumValues = self::getJenisSuratEnum();
        $options = [];

        foreach ($enumValues as $value) {
            $options[$value] = self::formatJenisSuratLabel($value);
        }

        return $options;
    }

    private static function formatJenisSuratLabel($value)
    {
        $labels = [
            'surat_keterangan_domisili' => 'Surat Keterangan Domisili',
            'surat_pengantar_umum' => 'Surat Pengantar Umum',
            'surat_keterangan_kelakuan_baik' => 'Surat Keterangan Kelakuan Baik'
        ];

        return $labels[$value] ?? ucwords(str_replace('_', ' ', $value));
    }
}
