<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Times New Roman', serif;
        }
        .kop-surat-title {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
        }
        .judul-surat {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .nomor-surat {
            font-size: 10pt;
            margin-bottom: 12px;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
        }
        .table-data td {
            padding: 4px 8px;
        }
        .table-data td:nth-child(1) {
            width: 30%;
            font-weight: bold;
        }
      </style>
</head>
<body class="bg-white p-8 text-gray-900">
    <div class="mx-auto max-w-3xl">
      <header class="flex items-center justify-center">
        <img src="https://kelurahantanjungbenoa.badungkab.go.id/storage/kelurahantanjungbenoa/image/PEMKAB%20BADUNG.png" alt="" class="h-28 w-auto" />
        <div class="text-center">
          <h1 class="kop-surat-title">PEMERINTAH KABUPATEN BADUNG</h1>
          <h1 class="text-[14pt] font-bold">LINGKUNGAN BALI KENCANA RESORT</h1>
          <h1 class="text-[14pt] font-bold">KECAMATAN KUTA SELATAN - BALI</h1>
        </div>
      </header>
      <hr class="my-3 border-t-2 border-black" />

      <div class="mb-6 text-center">
        <h3 class="judul-surat">{{ $judul_surat }}</h3>
        <p class="nomor-surat">Nomor: {{ $surat->nomor_surat_terbitan }}</p>
      </div>

      <div class="mb-6 leading-relaxed">
        <p class="mb-4">Yang bertanda tangan di bawah ini, Kepala Lingkungan Balai Kencana Resort, Desa/Kelurahan Desa Adat Ungasan, Kecamatan Kuta Selatan, Kabupaten/Kota Badung, menerangkan dengan sebenarnya bahwa:</p>

        <table class="table-data mb-4">
          <tr>
            <td class="w-1/3">Nama Lengkap</td>
            <td>:</td>
            <td class="font-semibold">{{ $surat->nama_lengkap }}</td>
          </tr>
          <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $surat->nik }}</td>
          </tr>
          <tr>
            <td>Tempat/Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $surat->tempat_lahir }}, {{ $surat->tanggal_lahir }}</td>
          </tr>
          <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $surat->jenis_kelamin }}</td>
          </tr>
          <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $surat->agama }}</td>
          </tr>
          <tr>
            <td>Alamat Asal</td>
            <td>:</td>
            <td>{{ $surat->alamat_asal }}</td>
          </tr>
          <tr>
            <td>Alamat Sekarang</td>
            <td>:</td>
            <td>{{ $surat->alamat_sekarang }}, Lingkungan Balai Kenana Resort</td>
          </tr>
          <tr>
            <td>Tanggal Masuk</td>
            <td>:</td>
            <td>{{ $surat->tanggal_masuk }}</td>
          </tr>
        </table>

        {!! $bagian_isi ?? '
        <p>Bagian isi tidak tersedia</p>
        ' !!}

        <p class="mt-4">Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
      </div>

      <footer class="mt-12">
        <div class="flex justify-end">
          <div class="w-1/2 text-center">
            <p>Balai Kenana Resort, {{ $surat->tanggal_surat_dicetak_pertama }}</p>
            <p>Kepala Lingkungan Balai Kenana Resort</p>
            <div class="mt-4 h-20"></div>
            <p class="font-semibold underline">{{ $surat->nama_kepala_lingkungan }}</p>
          </div>
        </div>
      </footer>
    </div>
  </body>
</html>