<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\penduduk_pendatang;

class ExportController extends Controller
{
    // Export CSV dengan format yang lebih bagus
    public function exportCsv(Request $request)
    {
        $search = $request->get('search', '');
        $filterStatus = $request->get('filterStatus', '');
        $filterJenisKelamin = $request->get('filterJenisKelamin', '');

        // Query data dengan filter
        $query = penduduk_pendatang::with(['user', 'kepalaLingkungan']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhere('alamat_sekarang', 'like', '%' . $search . '%');
            });
        }

        if (!empty($filterStatus)) {
            $query->where('status_akun', $filterStatus);
        }

        if (!empty($filterJenisKelamin)) {
            $query->where('jenis_kelamin', $filterJenisKelamin);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $filename = 'Laporan_Penduduk_Pendatang_' . date('d-m-Y_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($data, $search, $filterStatus, $filterJenisKelamin) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8 support in Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header informasi laporan
            fputcsv($file, ['LAPORAN DATA PENDUDUK PENDATANG']);
            fputcsv($file, ['Desa Sidorejo, Kecamatan Kaliwungu, Kabupaten Kudus']);
            fputcsv($file, ['Tanggal Export: ' . date('d F Y, H:i:s')]);

            // Filter info
            $filterInfo = [];
            if (!empty($search)) $filterInfo[] = 'Pencarian: ' . $search;
            if (!empty($filterStatus)) $filterInfo[] = 'Status: ' . $this->getStatusReadable($filterStatus);
            if (!empty($filterJenisKelamin)) $filterInfo[] = 'Jenis Kelamin: ' . ucfirst($filterJenisKelamin);

            if (!empty($filterInfo)) {
                fputcsv($file, ['Filter: ' . implode(', ', $filterInfo)]);
            }

            fputcsv($file, ['Total Data: ' . $data->count() . ' penduduk']);
            fputcsv($file, []); // Empty row

            // Header kolom
            fputcsv($file, [
                'No',
                'NIK',
                'Nama Lengkap',
                'Jenis Kelamin',
                'Tempat, Tanggal Lahir',
                'Agama',
                'Status Perkawinan',
                'Pekerjaan',
                'No. Telepon',
                'Email',
                'Alamat Asal',
                'Alamat Sekarang',
                'Tanggal Masuk',
                'Tujuan Kedatangan',
                'Status Verifikasi',
                'Kepala Lingkungan',
                'Tanggal Registrasi'
            ]);

            // Data rows
            foreach ($data as $index => $item) {
                $statusReadable = $this->getStatusReadable($item->status_akun);
                $tempatTanggalLahir = ($item->tempat_lahir ?? '') . ', ' . ($item->tanggal_lahir ? date('d-m-Y', strtotime($item->tanggal_lahir)) : '');

                fputcsv($file, [
                    $index + 1,
                    $item->nik ?? '-',
                    $item->nama_lengkap ?? '-',
                    ucfirst($item->jenis_kelamin ?? '-'),
                    $tempatTanggalLahir,
                    $item->agama ?? '-',
                    $this->getStatusPerkawinanReadable($item->status_perkawinan),
                    $item->pekerjaan ?? '-',
                    $item->telepon ?? '-',
                    $item->email ?? '-',
                    $item->alamat_asal ?? '-',
                    $item->alamat_sekarang ?? '-',
                    $item->tanggal_masuk ? date('d-m-Y', strtotime($item->tanggal_masuk)) : '-',
                    $item->tujuan ?? '-',
                    $statusReadable,
                    $item->kepalaLingkungan->name ?? '-',
                    $item->created_at ? $item->created_at->format('d-m-Y H:i:s') : '-'
                ]);
            }

            // Footer
            fputcsv($file, []);
            fputcsv($file, ['--- Akhir Laporan ---']);
            fputcsv($file, ['Dicetak oleh: Sistem Pendataan Penduduk Pendatang']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export Excel dengan styling yang bagus
    public function exportExcel(Request $request)
    {
        $search = $request->get('search', '');
        $filterStatus = $request->get('filterStatus', '');
        $filterJenisKelamin = $request->get('filterJenisKelamin', '');

        // Query data dengan filter yang sama
        $query = penduduk_pendatang::with(['user', 'kepalaLingkungan']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhere('alamat_sekarang', 'like', '%' . $search . '%');
            });
        }

        if (!empty($filterStatus)) {
            $query->where('status_akun', $filterStatus);
        }

        if (!empty($filterJenisKelamin)) {
            $query->where('jenis_kelamin', $filterJenisKelamin);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $filename = 'Laporan_Penduduk_Pendatang_' . date('d-m-Y_H-i-s') . '.xls';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($data, $search, $filterStatus, $filterJenisKelamin) {
            echo '<!DOCTYPE html>';
            echo '<html>';
            echo '<head>';
            echo '<meta charset="UTF-8">';
            echo '<style>';
            echo 'body { font-family: Arial, sans-serif; margin: 20px; }';
            echo '.header { text-align: center; margin-bottom: 20px; }';
            echo '.header h1 { color: #2c5282; margin: 5px 0; font-size: 18px; }';
            echo '.header p { color: #4a5568; margin: 2px 0; font-size: 12px; }';
            echo '.info-box { background-color: #f7fafc; border: 1px solid #e2e8f0; padding: 10px; margin: 10px 0; border-radius: 5px; }';
            echo '.info-box p { margin: 3px 0; font-size: 11px; }';
            echo 'table { border-collapse: collapse; width: 100%; margin-top: 20px; }';
            echo 'th { background-color: #4299e1; color: white; font-weight: bold; padding: 8px; text-align: center; border: 1px solid #2b6cb0; font-size: 11px; }';
            echo 'td { padding: 6px 8px; border: 1px solid #e2e8f0; font-size: 10px; }';
            echo 'tr:nth-child(even) { background-color: #f8f9fa; }';
            echo 'tr:hover { background-color: #e3f2fd; }';
            echo '.status-diterima { background-color: #c6f6d5; color: #22543d; text-align: center; font-weight: bold; }';
            echo '.status-pending { background-color: #fed7d7; color: #c53030; text-align: center; font-weight: bold; }';
            echo '.status-ditolak { background-color: #fed7d7; color: #c53030; text-align: center; font-weight: bold; }';
            echo '.status-ulangi { background-color: #fbd38d; color: #c05621; text-align: center; font-weight: bold; }';
            echo '.footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }';
            echo '.number { text-align: center; }';
            echo '.text-center { text-align: center; }';
            echo '</style>';
            echo '</head>';
            echo '<body>';

            // Header
            echo '<div class="header">';
            echo '<h1>LAPORAN DATA PENDUDUK PENDATANG</h1>';
            echo '<p>Desa Sidorejo, Kecamatan Kaliwungu, Kabupaten Kudus</p>';
            echo '<p>Tanggal Export: ' . date('d F Y, H:i:s') . '</p>';
            echo '</div>';

            // Info Box
            echo '<div class="info-box">';
            echo '<p><strong>Total Data:</strong> ' . $data->count() . ' penduduk</p>';

            $filterInfo = [];
            if (!empty($search)) $filterInfo[] = '<strong>Pencarian:</strong> ' . htmlspecialchars($search);
            if (!empty($filterStatus)) $filterInfo[] = '<strong>Status:</strong> ' . $this->getStatusReadable($filterStatus);
            if (!empty($filterJenisKelamin)) $filterInfo[] = '<strong>Jenis Kelamin:</strong> ' . ucfirst($filterJenisKelamin);

            if (!empty($filterInfo)) {
                echo '<p>' . implode(' | ', $filterInfo) . '</p>';
            }
            echo '</div>';

            // Table
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th rowspan="2">No</th>';
            echo '<th colspan="6">Data Pribadi</th>';
            echo '<th colspan="3">Kontak</th>';
            echo '<th colspan="4">Alamat & Kedatangan</th>';
            echo '<th colspan="2">Status & Penanggung Jawab</th>';
            echo '</tr>';
            echo '<tr>';
            echo '<th>NIK</th>';
            echo '<th>Nama Lengkap</th>';
            echo '<th>L/P</th>';
            echo '<th>TTL</th>';
            echo '<th>Agama</th>';
            echo '<th>Status Nikah</th>';
            echo '<th>Telepon</th>';
            echo '<th>Email</th>';
            echo '<th>Pekerjaan</th>';
            echo '<th>Alamat Asal</th>';
            echo '<th>Alamat Sekarang</th>';
            echo '<th>Tgl Masuk</th>';
            echo '<th>Tujuan</th>';
            echo '<th>Status</th>';
            echo '<th>Kepala Lingkungan</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Data rows
            foreach ($data as $index => $item) {
                $statusReadable = $this->getStatusReadable($item->status_akun);
                $statusClass = match ($item->status_akun) {
                    'diterima' => 'status-diterima',
                    'pending' => 'status-pending',
                    'ditolak' => 'status-ditolak',
                    'ulangi' => 'status-ulangi',
                    default => ''
                };

                $tempatTanggalLahir = ($item->tempat_lahir ?? '') . ', ' . ($item->tanggal_lahir ? date('d-m-Y', strtotime($item->tanggal_lahir)) : '');

                echo '<tr>';
                echo '<td class="number">' . ($index + 1) . '</td>';
                echo '<td>' . htmlspecialchars($item->nik ?? '-') . '</td>';
                echo '<td><strong>' . htmlspecialchars($item->nama_lengkap ?? '-') . '</strong></td>';
                echo '<td class="text-center">' . htmlspecialchars(substr($item->jenis_kelamin ?? '-', 0, 1)) . '</td>';
                echo '<td>' . htmlspecialchars($tempatTanggalLahir) . '</td>';
                echo '<td>' . htmlspecialchars($item->agama ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($this->getStatusPerkawinanReadable($item->status_perkawinan)) . '</td>';
                echo '<td>' . htmlspecialchars($item->telepon ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->email ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->pekerjaan ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->alamat_asal ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->alamat_sekarang ?? '-') . '</td>';
                echo '<td class="text-center">' . ($item->tanggal_masuk ? date('d-m-Y', strtotime($item->tanggal_masuk)) : '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->tujuan ?? '-') . '</td>';
                echo '<td class="' . $statusClass . '">' . htmlspecialchars($statusReadable) . '</td>';
                echo '<td>' . htmlspecialchars($item->kepalaLingkungan->name ?? '-') . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            // Footer
            echo '<div class="footer">';
            echo '<p>--- Akhir Laporan ---</p>';
            echo '<p>Dicetak oleh: Sistem Pendataan Penduduk Pendatang</p>';
            echo '<p>Waktu Cetak: ' . date('d F Y, H:i:s') . '</p>';
            echo '</div>';

            echo '</body>';
            echo '</html>';
        };

        return response()->stream($callback, 200, $headers);
    }

    // Helper methods
    private function getStatusReadable($status)
    {
        return match ($status) {
            'pending' => 'Menunggu Verifikasi',
            'diterima' => 'Terverifikasi',
            'ditolak' => 'Ditolak',
            'ulangi' => 'Ulangi Verifikasi',
            default => $status ?? '-'
        };
    }

    private function getStatusPerkawinanReadable($status)
    {
        return match ($status) {
            'kawin' => 'Kawin',
            'belum_kawin' => 'Belum Kawin',
            'cerai' => 'Cerai',
            default => $status ?? '-'
        };
    }

    // Method untuk export ringkasan/summary
    public function exportSummary(Request $request)
    {
        $data = penduduk_pendatang::with(['kepalaLingkungan'])
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status_akun = "diterima" THEN 1 ELSE 0 END) as terverifikasi,
                SUM(CASE WHEN status_akun = "pending" THEN 1 ELSE 0 END) as menunggu,
                SUM(CASE WHEN status_akun = "ditolak" THEN 1 ELSE 0 END) as ditolak,
                SUM(CASE WHEN jenis_kelamin = "laki-laki" THEN 1 ELSE 0 END) as laki_laki,
                SUM(CASE WHEN jenis_kelamin = "perempuan" THEN 1 ELSE 0 END) as perempuan
            ')
            ->first();

        $filename = 'Ringkasan_Penduduk_' . date('d-m-Y_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['RINGKASAN DATA PENDUDUK PENDATANG']);
            fputcsv($file, ['Tanggal: ' . date('d F Y')]);
            fputcsv($file, []);
            fputcsv($file, ['Kategori', 'Jumlah']);
            fputcsv($file, ['Total Penduduk', $data->total]);
            fputcsv($file, ['Terverifikasi', $data->terverifikasi]);
            fputcsv($file, ['Menunggu Verifikasi', $data->menunggu]);
            fputcsv($file, ['Ditolak', $data->ditolak]);
            fputcsv($file, []);
            fputcsv($file, ['Berdasarkan Jenis Kelamin']);
            fputcsv($file, ['Laki-laki', $data->laki_laki]);
            fputcsv($file, ['Perempuan', $data->perempuan]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportSuratCsv(Request $request)
    {
        $search = $request->get('search', '');
        $filterStatus = $request->get('filterStatus', '');
        $filterJenisSurat = $request->get('filterJenisSurat', '');

        $query = \App\Models\layanan_surat::with(['penduduk', 'penanggungJawab', 'kepalaLingkungan']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', '%' . $search . '%')
                    ->orWhere('jenis_surat', 'like', '%' . $search . '%')
                    ->orWhereHas('penduduk', function ($subQ) use ($search) {
                        $subQ->where('nama_lengkap', 'like', '%' . $search . '%');
                    });
            });
        }

        if (!empty($filterStatus)) {
            $query->where('status', $filterStatus);
        }

        if (!empty($filterJenisSurat)) {
            $query->where('jenis_surat', $filterJenisSurat);
        }

        $data = $query->orderBy('created_at', 'desc')->get();
        $filename = 'laporan_layanan_surat_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($data) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'No',
                'Nomor Surat',
                'Jenis Surat',
                'Nama Pemohon',
                'Penanggung Jawab',
                'Tanggal Pengajuan',
                'Kepala Lingkungan',
                'Tanggal Keputusan',
                'Status',
                'Keperluan'
            ]);

            foreach ($data as $index => $item) {
                fputcsv($handle, [
                    $index + 1,
                    $item->nomor_surat_terbitan ?? '-',
                    $this->getJenisSuratReadable($item->jenis_surat),
                    $item->penduduk->nama_lengkap ?? '-',
                    $item->penanggungJawab->name ?? '-',
                    $item->tanggal_pengajuan ? date('d-m-Y', strtotime($item->tanggal_pengajuan)) : '-',
                    $item->kepalaLingkungan->name ?? '-',
                    $item->tanggal_surat_diterbitkan ? date('d-m-Y', strtotime($item->tanggal_surat_diterbitkan)) : '-',
                    ucfirst($item->status_pengajuan ?? '-'),
                    $item->keperluan_surat ?? '-'
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function exportSuratExcel(Request $request)
    {
        $search = $request->get('search', '');
        $filterStatus = $request->get('filterStatus', '');
        $filterJenisSurat = $request->get('filterJenisSurat', '');

        $query = \App\Models\layanan_surat::with(['penduduk', 'penanggungJawab', 'kepalaLingkungan']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', '%' . $search . '%')
                    ->orWhere('jenis_surat', 'like', '%' . $search . '%')
                    ->orWhereHas('penduduk', function ($subQ) use ($search) {
                        $subQ->where('nama_lengkap', 'like', '%' . $search . '%');
                    });
            });
        }

        if (!empty($filterStatus)) {
            $query->where('status', $filterStatus);
        }

        if (!empty($filterJenisSurat)) {
            $query->where('jenis_surat', $filterJenisSurat);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $filename = 'Laporan_Layanan_Surat_' . date('d-m-Y_H-i-s') . '.xls';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($data, $search, $filterStatus, $filterJenisSurat) {
            echo '<!DOCTYPE html>';
            echo '<html>';
            echo '<head>';
            echo '<meta charset="UTF-8">';
            echo '<style>';
            echo 'body { font-family: Arial, sans-serif; margin: 20px; }';
            echo '.header { text-align: center; margin-bottom: 20px; }';
            echo '.header h1 { color: #2c5282; margin: 5px 0; font-size: 18px; }';
            echo '.header p { color: #4a5568; margin: 2px 0; font-size: 12px; }';
            echo '.info-box { background-color: #f7fafc; border: 1px solid #e2e8f0; padding: 10px; margin: 10px 0; border-radius: 5px; }';
            echo '.info-box p { margin: 3px 0; font-size: 11px; }';
            echo 'table { border-collapse: collapse; width: 100%; margin-top: 20px; }';
            echo 'th { background-color: #16a085; color: white; font-weight: bold; padding: 8px; text-align: center; border: 1px solid #138f7a; font-size: 11px; }';
            echo 'td { padding: 6px 8px; border: 1px solid #e2e8f0; font-size: 10px; }';
            echo 'tr:nth-child(even) { background-color: #f8f9fa; }';
            echo 'tr:hover { background-color: #e3f2fd; }';
            echo '.status-disetujui { background-color: #c6f6d5; color: #22543d; text-align: center; font-weight: bold; }';
            echo '.status-pending { background-color: #fed7d7; color: #c53030; text-align: center; font-weight: bold; }';
            echo '.status-ditolak { background-color: #fed7d7; color: #c53030; text-align: center; font-weight: bold; }';
            echo '.footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }';
            echo '.number { text-align: center; }';
            echo '.text-center { text-align: center; }';
            echo '.jenis-surat { background-color: #e3f2fd; color: #1976d2; text-align: center; font-weight: bold; }';
            echo '</style>';
            echo '</head>';
            echo '<body>';

            // Header
            echo '<div class="header">';
            echo '<h1>LAPORAN LAYANAN SURAT</h1>';
            echo '<p>Balai Kencana Resort, Kecamatan Kuta Selatan, Kabupaten Badung</p>';
            echo '<p>Tanggal Export: ' . date('d F Y, H:i:s') . '</p>';
            echo '</div>';

            // Info Box
            echo '<div class="info-box">';
            echo '<p><strong>Total Data:</strong> ' . $data->count() . ' layanan surat</p>';

            $filterInfo = [];
            if (!empty($search)) $filterInfo[] = '<strong>Pencarian:</strong> ' . htmlspecialchars($search);
            if (!empty($filterStatus)) $filterInfo[] = '<strong>Status:</strong> ' . ucfirst($filterStatus);
            if (!empty($filterJenisSurat)) $filterInfo[] = '<strong>Jenis Surat:</strong> ' . $this->getJenisSuratReadable($filterJenisSurat);

            if (!empty($filterInfo)) {
                echo '<p>' . implode(' | ', $filterInfo) . '</p>';
            }
            echo '</div>';

            // Table
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th rowspan="2">No</th>';
            echo '<th colspan="3">Data Surat</th>';
            echo '<th colspan="2">Pemohon & Penanggung Jawab</th>';
            echo '<th colspan="3">Waktu & Persetujuan</th>';
            echo '<th rowspan="2">Keperluan</th>';
            echo '</tr>';
            echo '<tr>';
            echo '<th>Nomor Surat</th>';
            echo '<th>Jenis Surat</th>';
            echo '<th>Status</th>';
            echo '<th>Nama Pemohon</th>';
            echo '<th>Penanggung Jawab</th>';
            echo '<th>Tgl Pengajuan</th>';
            echo '<th>Kepala Lingkungan</th>';
            echo '<th>Tgl Keputusan</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            // Data rows
            foreach ($data as $index => $item) {
                $statusClass = match ($item->status_pengajuan ?? 'pending') {
                    'disetujui' => 'status-disetujui',
                    'pending' => 'status-pending',
                    'ditolak' => 'status-ditolak',
                    default => ''
                };

                echo '<tr>';
                echo '<td class="number">' . ($index + 1) . '</td>';
                echo '<td>' . htmlspecialchars($item->nomor_surat_terbitan ?? '-') . '</td>';
                echo '<td class="jenis-surat">' . htmlspecialchars($this->getJenisSuratReadable($item->jenis_surat)) . '</td>';
                echo '<td class="' . $statusClass . '">' . htmlspecialchars(ucfirst($item->status_pengajuan ?? 'pending')) . '</td>';
                echo '<td><strong>' . htmlspecialchars($item->penduduk->nama_lengkap ?? 'Tidak diketahui') . '</strong></td>';
                echo '<td>' . htmlspecialchars($item->penanggungJawab->name ?? 'Tidak ada') . '</td>';
                echo '<td class="text-center">' . ($item->tanggal_pengajuan ? date('d-m-Y', strtotime($item->tanggal_pengajuan)) : '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->kepalaLingkungan->name ?? 'Belum disetujui') . '</td>';
                echo '<td class="text-center">' . ($item->tanggal_surat_diterbitkan ? date('d-m-Y', strtotime($item->tanggal_surat_diterbitkan)) : '-') . '</td>';
                echo '<td>' . htmlspecialchars($item->keperluan_surat ?? '-') . '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';

            // Footer
            echo '<div class="footer">';
            echo '<p>--- Akhir Laporan ---</p>';
            echo '<p>Dicetak oleh: Sistem Pendataan Penduduk Pendatang</p>';
            echo '<p>Waktu Cetak: ' . date('d F Y, H:i:s') . '</p>';
            echo '</div>';

            echo '</body>';
            echo '</html>';
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getJenisSuratReadable($jenis)
    {
        return match ($jenis) {
            'surat_pengantar' => 'Surat Pengantar',
            'surat_keterangan_domisili' => 'Surat Keterangan Domisili',
            'surat_keterangan_usaha' => 'Surat Keterangan Usaha',
            'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'surat_keterangan_kelahiran' => 'Surat Keterangan Kelahiran',
            'surat_keterangan_kematian' => 'Surat Keterangan Kematian',
            default => ucfirst(str_replace('_', ' ', $jenis))
        };
    }
}
