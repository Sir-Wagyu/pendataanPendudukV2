<?php
// filepath: c:\laragon\www\pendataanPendudukV2\app\Http\Controllers\cetak_surat.php

namespace App\Http\Controllers;

use App\Models\layanan_surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;

class cetak_surat extends Controller
{
    public function downloadSurat($id)
    {
        try {
            $surat = layanan_surat::join('penduduk_pendatang', 'layanan_surat.id_penduduk_pendatang', '=', 'penduduk_pendatang.id')
                ->join('users as pj', 'layanan_surat.id_penanggungJawab_pemohon', '=', 'pj.id')
                ->leftJoin('users as kl', 'layanan_surat.id_kepalaLingkungan_penyetuju', '=', 'kl.id')
                ->where('layanan_surat.id', $id)
                ->whereIn('layanan_surat.status_pengajuan', ['disetujui', 'selesai'])
                ->select(
                    'layanan_surat.*',
                    'penduduk_pendatang.nama_lengkap',
                    'penduduk_pendatang.nik',
                    'penduduk_pendatang.alamat_asal',
                    'penduduk_pendatang.alamat_sekarang',
                    'penduduk_pendatang.telepon as telepon_penduduk',
                    'penduduk_pendatang.jenis_kelamin',
                    'penduduk_pendatang.tempat_lahir',
                    'penduduk_pendatang.tanggal_lahir',
                    'penduduk_pendatang.agama',
                    'penduduk_pendatang.status_perkawinan',
                    'penduduk_pendatang.tanggal_masuk',
                    'pj.name as nama_penanggung_jawab',
                    'kl.name as nama_kepala_lingkungan'
                )
                ->first();

            if (!$surat) {
                abort(404, 'Surat tidak ditemukan atau belum disetujui');
            }

            $templateName = $this->getTemplateName($surat->jenis_surat);
            $judul_surat = $this->getJudulSurat($surat->jenis_surat);

            $data = [
                'surat' => $surat,
                'tanggal_cetak' => now()->locale('id')->translatedFormat('d F Y'),
                'hari_cetak' => now()->locale('id')->translatedFormat('l'),
                'judul_surat' => $judul_surat,
                'bagian_isi' => $this->getBagianIsi(surat: $surat),
                'nomor_surat' => $this->generateNomorSurat($surat),
            ];

            // Render HTML dari view
            $html = view("pdf-templates.surat-template", $data)->render();

            // Generate PDF dengan Browsershot
            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(3, 4, 3, 3)
                ->showBackground()
                ->waitUntilNetworkIdle()
                ->pdf();

            // Update counter
            $surat_model = layanan_surat::find($surat->id);
            if ($surat_model) {
                if (Auth::user()->role == 'penanggungJawab') {
                    $surat_model->increment('jumlah_sudah_digenerate');

                    if (!$surat_model->tanggal_surat_dicetak_pertama) {
                        $surat_model->update(['tanggal_surat_dicetak_pertama' => now()]);
                    }
                }

                // Update status menjadi selesai jika status masih disetujui
                if ($surat_model->status_pengajuan == 'disetujui') {
                    $surat_model->update([
                        'status_pengajuan' => 'selesai',
                        'tanggal_selesai' => now() // Optional: tambah field ini jika diperlukan
                    ]);

                    Log::info("Surat ID {$id} status diupdate menjadi selesai setelah dicetak oleh user " . Auth::id());
                }
            }

            if ($surat_model->status_pengajuan == 'disetujui') {
                $surat_model->update(['status_pengajuan' => 'selesai']);
            }

            $fileName = $this->generateFileName($surat);

            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        } catch (\Exception $e) {
            Log::error('Error downloading PDF: ' . $e->getMessage());
            abort(500, 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    public function previewSurat($id)
    {
        try {
            $surat = layanan_surat::join('penduduk_pendatang', 'layanan_surat.id_penduduk_pendatang', '=', 'penduduk_pendatang.id')
                ->join('users as pj', 'layanan_surat.id_penanggungJawab_pemohon', '=', 'pj.id')
                ->leftJoin('users as kl', 'layanan_surat.id_kepalaLingkungan_penyetuju', '=', 'kl.id')
                ->where('layanan_surat.id', $id)
                ->where('layanan_surat.status_pengajuan', 'disetujui')
                ->select(
                    'layanan_surat.*',
                    'penduduk_pendatang.nama_lengkap',
                    'penduduk_pendatang.nik',
                    'penduduk_pendatang.alamat_asal',
                    'penduduk_pendatang.alamat_sekarang',
                    'penduduk_pendatang.telepon as telepon_penduduk',
                    'penduduk_pendatang.jenis_kelamin',
                    'penduduk_pendatang.tempat_lahir',
                    'penduduk_pendatang.tanggal_lahir',
                    'penduduk_pendatang.agama',
                    'penduduk_pendatang.status_perkawinan',
                    'penduduk_pendatang.tanggal_masuk',
                    'pj.name as nama_penanggung_jawab',
                    'kl.name as nama_kepala_lingkungan'
                )
                ->first();

            if (!$surat) {
                abort(404, 'Surat tidak ditemukan atau belum disetujui');
            }

            $templateName = $this->getTemplateName($surat->jenis_surat);
            $judul_surat = $this->getJudulSurat($surat->jenis_surat);

            $data = [
                'surat' => $surat,
                'tanggal_cetak' => now()->locale('id')->translatedFormat('d F Y'),
                'hari_cetak' => now()->locale('id')->translatedFormat('l'),
                'judul_surat' => $judul_surat,
                'bagian_isi' => $this->getBagianIsi($surat),
            ];

            $html = view("pdf-templates.surat-template", $data)->render();

            // Generate PDF untuk stream
            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(20, 20, 20, 20)
                ->showBackground()
                ->waitUntilNetworkIdle()
                ->pdf();

            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="preview-surat.pdf"');
        } catch (\Exception $e) {
            Log::error('Error previewing PDF: ' . $e->getMessage());
            abort(500, 'Gagal preview PDF: ' . $e->getMessage());
        }
    }


    private function getTemplateName($jenisSurat)
    {
        if ($jenisSurat == 'surat_keterangan_domisili') {
            return 'Surat Keterangan Domisili';
        } elseif ($jenisSurat == 'surat_pengantar_umum') {
            return 'Surat Pengantar Umum';
        } elseif ($jenisSurat == 'surat_keterangan_kehilangan_lokal') {
            return 'Surat Keterangan Kehilangan Lokal';
        } elseif ($jenisSurat == 'surat_keterangan_untuk_sekolah_anak') {
            return 'Surat Keterangan Untuk Sekolah Anak';
        } elseif ($jenisSurat == 'surat_pengantar_skck') {
            return 'Surat Pengantar SKCK';
        }

        return $templates[$jenisSurat] ?? 'surat-default';
    }

    private function getJudulSurat($jenisSurat)
    {
        if ($jenisSurat == 'surat_keterangan_domisili') {
            return 'Surat Keterangan Domisili';
        } elseif ($jenisSurat == 'surat_pengantar_umum') {
            return 'Surat Pengantar Umum';
        } elseif ($jenisSurat == 'surat_keterangan_kehilangan_lokal') {
            return 'Surat Keterangan Kehilangan Lokal';
        } elseif ($jenisSurat == 'surat_keterangan_untuk_sekolah_anak') {
            return 'Surat Keterangan Untuk Sekolah Anak';
        } elseif ($jenisSurat == 'surat_pengantar_skck') {
            return 'Surat Pengantar SKCK';
        }
    }

    private function generateFileName($surat)
    {
        $jenisSurat = str_replace('_', '-', $surat->jenis_surat);
        $namaPenduduk = str_replace(' ', '-', strtolower($surat->nama_lengkap));
        $tanggal = now()->format('Y-m-d');

        return "{$jenisSurat}-{$namaPenduduk}-{$tanggal}.pdf";
    }

    public function generateNomorSurat($surat)
    {
        $tahun = date('Y');

        $jumlahSuratTahunIni = layanan_surat::whereYear('updated_at', $tahun)
            ->where('status_pengajuan', 'disetujui')
            ->count();

        $nomorUrut = str_pad($jumlahSuratTahunIni + 1, 3, '0', STR_PAD_LEFT);

        $jenisSuratMap = [
            'surat_keterangan_domisili' => 'SKD',
            'surat_pengantar_umum' => 'SPU',
            'surat_keterangan_kehilangan_lokal' => 'SKHL',
            'surat_keterangan_untuk_sekolah_anak' => 'SKSA',
        ];

        $jenisSuratKey = strtolower(trim($surat->jenis_surat));
        $kodeJenisSurat = $jenisSuratMap[$jenisSuratKey] ?? 'XXX';

        $kodeLingkungan = 'BKR';

        $bulanRomawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];
        $bulan = (int)date('n');
        $bulanRom = $bulanRomawi[$bulan];

        $nomorSurat = "{$nomorUrut}/{$kodeJenisSurat}/{$kodeLingkungan}/{$bulanRom}/{$tahun}";

        return $nomorSurat;
    }

    private function getBagianIsi($surat)
    {
        $tanggalMasuk = '';
        if ($surat->tanggal_masuk) {
            $tanggalMasuk = \Carbon\Carbon::parse($surat->tanggal_masuk)->locale('id')->translatedFormat('d F Y');
        }

        $dataTambahan = $surat->data_tambahan ?? [];

        if ($surat->jenis_surat == 'surat_keterangan_domisili') {
            return '<p class="mb-4">Berdasarkan data dan sepengetahuan kami, nama tersebut di atas adalah benar penduduk pendatang dan berdomisili sementara di wilayah Lingkungan Balai Kencana Resort sejak tanggal ' . $tanggalMasuk . '.</p>
    <p>Surat keterangan ini diberikan untuk keperluan: <strong>' . ($surat->keperluan_surat ?? '') . '</strong>.</p>';
        } elseif ($surat->jenis_surat == 'surat_pengantar_umum') {
            return '
            <p class="mb-4">Berdasarkan data dan sepengetahuan kami, nama tersebut di atas adalah benar penduduk pendatang dan berdomisili sementara di wilayah Lingkungan Balai Kencana Resort sejak tanggal ' . $tanggalMasuk . '.</p>
            <p>Surat pengantar ini kami berikan kepada yang bersangkutan untuk keperluan: <strong>' . ($surat->keperluan_surat ?? '') . '</strong>.</p>
            <p>Mohon kepada pihak yang berkepentingan agar dapat memberikan bantuan dan fasilitas seperlunya.</p>';
        } elseif ($surat->jenis_surat == 'surat_pengantar_skck') {
            return '
            <p class="mb-4">Berdasarkan data dan sepengetahuan kami, nama tersebut di atas adalah benar penduduk pendatang, berdomisili sementara di wilayah Lingkungan Balai Kencana Resort, dan selama berada di lingkungan kami berkelakuan baik serta tidak pernah tersangkut perkara pidana atau pelanggaran hukum lainnya berdasarkan catatan kami di tingkat lingkungan.</p>
            <p>Surat pengantar ini kami berikan kepada yang bersangkutan sebagai salah satu syarat untuk mengurus Surat Keterangan Catatan Kepolisian (SKCK) di Kepolisian.</p>
            <p>Keperluan: <strong>Untuk mengurus SKCK</strong>.</p>';
        } elseif ($surat->jenis_surat == 'surat_keterangan_kehilangan_lokal') {
            return '
            <p class="mb-4">Berdasarkan laporan dan keterangan dari nama tersebut di atas, yang mana adalah benar penduduk pendatang dan berdomisili sementara di wilayah Lingkungan Balai Kencana Resort, dengan ini menerangkan bahwa yang bersangkutan telah melaporkan kehilangan:</p>
            <ul class="list-disc list-inside mb-4 ml-1">
                <li>Barang/Dokumen yang hilang : <strong>' . ($dataTambahan['barang_hilang'] ?? '') . '</strong></li>
                <li>Perkiraan Waktu Kehilangan : ' . ($dataTambahan['waktu_kehilangan'] ?? '') . '</li>
                <li>Perkiraan Tempat Kehilangan : ' . ($dataTambahan['lokasi_kehilangan'] ?? '') . '</li>
            </ul>
            <p>Surat keterangan kehilangan ini dibuat untuk keperluan: <strong>' . ($surat->keperluan_surat ?? '') . '</strong>.</p>
            <p class="text-sm italic">Catatan: Surat keterangan ini bukan merupakan pengganti laporan resmi dari pihak Kepolisian.</p>';
        } elseif ($surat->jenis_surat == 'surat_keterangan_untuk_sekolah_anak') {
            return '
            <p class="mb-4">Berdasarkan data dan sepengetahuan kami, nama tersebut di atas adalah benar penduduk pendatang dan berdomisili sementara di wilayah Lingkungan Balai Kencana Resort bersama dengan anaknya (atau sebagai wali dari anak):</p>
            <table class="mb-4 ml-1 table-data">
                <tr>
                <td>Nama Anak</td>
                <td>:</td>
                <td class="font-semibold">' . ($dataTambahan['nama_anak'] ?? '') . '</td>
                </tr>
                <tr>
                <td>Tempat/Tgl Lahir Anak</td>
                <td>:</td>
                <td>' . ($dataTambahan['tempat_lahir_anak'] ?? '') . ', ' . ($dataTambahan['tanggal_lahir_anak'] ?? '') . '</td>
                </tr>
            </table>
            <p>Surat keterangan ini kami berikan untuk keperluan: <strong>' . ($dataTambahan['nama_sekolah'] ?? '') . '</strong>.</p>';
        } else {
            return '<p>Adalah benar warga yang berdomisili di wilayah Lingkungan Balai Kencana Resort.</p>
                <p><strong>Keperluan:</strong> ' . ($surat->keperluan_surat ?? '') . '</p>';
        }
    }
}
