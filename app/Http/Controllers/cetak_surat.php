<?php

namespace App\Http\Controllers;

use App\Models\layanan_surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;

class cetak_surat extends Controller
{
    public function downloadSurat($id)
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
                    'penduduk_pendatang.telepon as telepon_penduduk',
                    'penduduk_pendatang.jenis_kelamin',
                    'penduduk_pendatang.tempat_lahir',
                    'penduduk_pendatang.tanggal_lahir',
                    'penduduk_pendatang.agama',
                    'penduduk_pendatang.status_perkawinan',
                    'pj.name as nama_penanggung_jawab',
                    'kl.name as nama_kepala_lingkungan'
                )
                ->first();


            // Generate PDF
            $templateName = $this->getTemplateName($surat->jenis_surat);

            $data = [
                'surat' => $surat,
                'tanggal_cetak' => now()->locale('id')->translatedFormat('d F Y'),
                'hari_cetak' => now()->locale('id')->translatedFormat('l'),
            ];

            $html = view("pdf-templates.{$templateName}", $data)->render();

            $options = new Options();
            $options->set('defaultFont', 'DejaVu Sans');
            $options->set('isRemoteEnabled', true);
            $options->set('isHtml5ParserEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Update counter dan tanggal cetak
            $surat_model = layanan_surat::find($surat->id);
            if ($surat_model) {
                if (Auth::user()->role == 'penanggungJawab') {
                    $surat_model->increment('jumlah_sudah_digenerate');

                    if (!$surat_model->tanggal_surat_dicetak_pertama) {
                        $surat_model->update(['tanggal_surat_dicetak_pertama' => now()]);
                    }
                }
            }

            $fileName = $this->generateFileName($surat);

            return response()->streamDownload(
                fn() => print($dompdf->output()),
                $fileName,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
                ]
            );
        } catch (\Exception $e) {
            Log::error('Error downloading PDF: ' . $e->getMessage());
            abort(500, 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    private function getTemplateName($jenisSurat)
    {
        $templates = [
            'surat_keterangan_domisili' => 'surat-keterangan-domisili',
            'surat_pengantar_umum' => 'surat-pengantar-umum',
            'surat_keterangan_hilang_lokal' => 'surat-keterangan-hilang-lokal',
            'surat_keterangan_untuk_sekolah_anak' => 'surat-keterangan-sekolah-anak',
        ];

        return $templates[$jenisSurat] ?? 'surat-default';
    }

    private function generateFileName($surat)
    {
        $jenisSurat = str_replace('_', '-', $surat->jenis_surat);
        $namaPenduduk = str_replace(' ', '-', strtolower($surat->nama_lengkap));
        $tanggal = now()->format('Y-m-d');

        return "{$jenisSurat}-{$namaPenduduk}-{$tanggal}.pdf";
    }
}
