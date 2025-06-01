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
        'data_tambahan',
        'status_pengajuan',
        'catatan_kepalaLingkungan',
        'nomor_surat_terbitan',
        'tanggal_pengajuan',
        'tanggal_surat_diterbitkan',
        'tanggal_surat_dicetak_pertama',
        'cetak_sebelum_tanggal',
        'maksimal_generate_pdf'
    ];

    protected $dates = [
        'tanggal_pengajuan',
        'tanggal_surat_diterbitkan',
        'tanggal_surat_dicetak_pertama',
        'cetak_sebelum_tanggal'
    ];

    protected $casts = [
        'data_tambahan' => 'array',
    ];

    public function penduduk()
    {
        return $this->belongsTo(penduduk_pendatang::class, 'id_penduduk_pendatang');
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'id_penanggungJawab_pemohon')->where('role', 'penanggungJawab');
    }

    public function kepalaLingkungan()
    {
        return $this->belongsTo(User::class, 'id_kepalaLingkungan_penyetuju')->where('role', 'kepalaLingkungan');
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

    // Scope untuk surat aktif (diajukan atau disetujui)
    public function scopeAktif($query)
    {
        return $query->whereIn('status_pengajuan', ['diajukan', 'disetujui']);
    }

    // Method untuk cek apakah masih bisa dicetak
    public function masihBisaDicetak()
    {
        if ($this->status_pengajuan !== 'disetujui') {
            return false;
        }

        // Cek batas waktu cetak
        if ($this->cetak_sebelum_tanggal && now()->gt($this->cetak_sebelum_tanggal)) {
            return false;
        }

        // Cek batas maksimal generate
        if ($this->jumlah_sudah_digenerate >= $this->maksimal_generate_pdf) {
            return false;
        }

        return true;
    }


    // Method helper untuk get data tambahan
    public function getDataTambahan($key = null)
    {
        if ($key) {
            return $this->data_tambahan[$key] ?? null;
        }
        return $this->data_tambahan ?? [];
    }

    // Method helper untuk set data tambahan
    public function setDataTambahan($key, $value)
    {
        $dataTambahan = $this->data_tambahan ?? [];
        $dataTambahan[$key] = $value;
        $this->data_tambahan = $dataTambahan;
    }
}
