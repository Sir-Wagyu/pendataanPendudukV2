<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan</title>
    <script src="https://cdn.tailwindcss.com"></script> 
    <style>
        /* Anda bisa menambahkan style kustom di sini jika diperlukan untuk PDF */
        body {
            font-family: 'Times New Roman', Times, serif; /* Font umum untuk surat resmi */
            font-size: 12pt;
            line-height: 1.5;
        }
        .kop-surat-title {
            font-size: 16pt;
            font-weight: bold;
        }
        .kop-surat-subtitle {
            font-size: 14pt;
        }
        .judul-surat {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
        }
        .nomor-surat {
            font-size: 12pt;
        }
        .table-data td {
            padding-right: 8px; /* Jarak antara label dan titik dua */
            vertical-align: top;
        }
        .table-data td:nth-child(2) {
            padding-right: 4px; /* Jarak titik dua ke data */
        }
    </style>
</head>
<body class="bg-white text-gray-900 p-8">
    <div class="max-w-3xl mx-auto">

        <header class="text-center mb-6">
            <h1 class="kop-surat-title">PEMERINTAH [NAMA KABUPATEN/KOTA]</h1>
            <h2 class="kop-surat-subtitle">KECAMATAN [NAMA KECAMATAN]</h2>
            <h2 class="kop-surat-subtitle">DESA/KELURAHAN [NAMA DESA/KELURAHAN]</h2>
            <h1 class="kop-surat-title">LINGKUNGAN/BANJAR [NAMA_LINGKUNGAN_ANDA]</h1>
            <p class="text-sm">Alamat: [Alamat Lengkap Lingkungan/Banjar Anda] Telp. [Nomor Telepon Jika Ada]</p>
            <hr class="my-3 border-t-2 border-black">
        </header>

        <div class="text-center mb-6">
            <h3 class="judul-surat">[JUDUL_SURAT_SPESIFIK]</h3>
            <p class="nomor-surat">Nomor: {{ $surat->nomor_surat_terbitan }}</p>
        </div>

        <div class="mb-6 leading-relaxed">
            <p class="mb-4">Yang bertanda tangan di bawah ini, Kepala Lingkungan [NAMA_LINGKUNGAN_ANDA], Desa/Kelurahan [Nama Desa/Kelurahan], Kecamatan [Nama Kecamatan], Kabupaten/Kota [Nama Kabupaten/Kota], menerangkan dengan sebenarnya bahwa:</p>
            
            <table class="mb-4 table-data">
                <tr>
                    <td class="w-1/3">Nama Lengkap</td>
                    <td>:</td>
                    <td class="font-semibold">{{ $surat->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>[NIK_PENDUDUK]</td>
                </tr>
                <tr>
                    <td>Tempat/Tanggal Lahir</td>
                    <td>:</td>
                    <td>[TEMPAT_LAHIR_PENDUDUK], [TANGGAL_LAHIR_PENDUDUK_FORMATTED]</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>[JENIS_KELAMIN_PENDUDUK]</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>:</td>
                    <td>[AGAMA_PENDUDUK]</td>
                </tr>
                 <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td>[PEKERJAAN_PENDUDUK]</td>
                </tr>
                <tr>
                    <td>Alamat Asal</td>
                    <td>:</td>
                    <td>[ALAMAT_ASAL_LENGKAP_PENDUDUK]</td>
                </tr>
                <tr>
                    <td>Alamat Sekarang</td>
                    <td>:</td>
                    <td>[ALAMAT_SEKARANG_LENGKAP_PENDUDUK] (Lingkungan [NAMA_LINGKUNGAN_ANDA])</td>
                </tr>
                <tr>
                    <td>Tanggal Masuk</td>
                    <td>:</td>
                    <td>[TANGGAL_MASUK_PENDUDUK_FORMATTED]</td>
                </tr>
            </table>

            [BAGIAN_ISI_SPESIFIK_SURAT]

            <p class="mt-4">Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <footer class="mt-12">
            <div class="flex justify-end">
                <div class="w-1/2 text-center">
                    <p>[NAMA_LINGKUNGAN_ANDA], [TANGGAL_SURAT_DITERBITKAN_FORMATTED]</p>
                    <p>Kepala Lingkungan [NAMA_LINGKUNGAN_ANDA]</p>
                    <div class="h-20 mt-4">
                        </div>
                    <p class="font-semibold underline">[NAMA_LENGKAP_KAPLING]</p>
                    </div>
            </div>
        </footer>

    </div>
</body>
</html>