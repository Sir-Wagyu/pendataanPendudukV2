<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\layanan_surat;
use App\Models\users;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Log;


class DataLayananSurat extends Component
{
    public $search = '';
    public $isPreviewCatatanModal = false;
    public $keperluan_surat;
    public $isSetujuModal = false;
    public $isTolakModal = false;
    public $selectedSuratId = null;
    public $catatan_kepalaLingkungan = '';

    public $cetak_sebelum_tanggal = '';
    public $maksimal_generate_pdf = '';
    public $isVerifikasiModal = false;
    public $isSetujuiMode = false;
    public $isTolakMode = false;
    public $isBatalMode = false;
    public $isNotificationModal = false;
    public $isViewDetailModal = false;

    public $nama_lengkap = '';
    public $nik = '';
    public $alamat_asal = '';
    public $jenis_surat = '';
    public $status_pengajuan = '';
    public $tanggal_pengajuan = '';
    public $tanggal_surat_diterbitkan = '';
    public $nomor_surat_terbitan = '';
    public $jumlah_sudah_digenerate = '';

    public $penanggung_jawab = '';
    public $kepala_lingkungan = '';

    public function render()
    {
        $user = Auth::user();
        $query = layanan_surat::query();

        if ($user->role === 'penanggungJawab') {
            $query->where('id_penanggungJawab_pemohon', $user->id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat_asal', 'like', '%' . $this->search . '%')
                    ->orWhere('telepon', 'like', '%' . $this->search . '%');
            });
        }



        $semuaSurat = $query
            ->join('penduduk_pendatang', 'layanan_surat.id_penduduk_pendatang', '=', 'penduduk_pendatang.id')
            ->select(
                'layanan_surat.*',
                'penduduk_pendatang.id as penduduk_id',
                'penduduk_pendatang.nama_lengkap',
                'penduduk_pendatang.nik',
                'penduduk_pendatang.alamat_asal',
                'penduduk_pendatang.telepon'
            )
            ->get();

        $suratVerifikasi = layanan_surat::join('penduduk_pendatang', 'layanan_surat.id_penduduk_pendatang', '=', 'penduduk_pendatang.id')
            ->where('layanan_surat.status_pengajuan', 'diajukan')
            ->select(
                'layanan_surat.*',
                'penduduk_pendatang.id as penduduk_id',
                'penduduk_pendatang.nama_lengkap',
            )
            ->get();

        if (session()->has('message')) {
            $this->isNotificationModal = true;
        } else {
            $this->isNotificationModal = false;
        }

        return view('livewire.data-layanan-surat', [
            'surat' => $semuaSurat,
            'suratVerifikasi' => $suratVerifikasi,
        ]);
    }

    public function resetInputFields()
    {
        $this->catatan_kepalaLingkungan = '';
        $this->cetak_sebelum_tanggal = '';
        $this->maksimal_generate_pdf = '';
        $this->selectedSuratId = null;
        $this->keperluan_surat = '';
        $this->jenis_surat = '';
        $this->nama_lengkap = '';
        $this->nik = '';
        $this->alamat_asal = '';
        $this->status_pengajuan = '';
        $this->tanggal_pengajuan = '';
        $this->tanggal_surat_diterbitkan = '';
        $this->nomor_surat_terbitan = '';
        $this->penanggung_jawab = '';
        $this->kepala_lingkungan = '';
        $this->jumlah_sudah_digenerate = '';
    }


    public function openCatatanPengajuanModal($selectedSuratId)
    {
        $this->selectedSuratId = $selectedSuratId;
        $this->keperluan_surat = layanan_surat::find($selectedSuratId)->keperluan_surat;
        $this->isPreviewCatatanModal = true;
    }

    public function openTolakModal($id)
    {
        $this->selectedSuratId = $id;
        $this->isTolakMode = true;
        $this->isVerifikasiModal = true;
    }

    public function openSetujuiModal($id)
    {
        $this->selectedSuratId = $id;
        $this->isSetujuiMode = true;
        $this->isVerifikasiModal = true;
    }

    public function openBatalModal($id)
    {
        $this->selectedSuratId = $id;
        $this->isBatalMode = true;
        $this->isVerifikasiModal = true;
    }

    public function suratDisetujui()
    {
        $this->validate([
            'cetak_sebelum_tanggal' => 'nullable|date|after_or_equal:today',
            'maksimal_generate_pdf' => 'nullable|integer|min:1|max:20',
            'catatan_kepalaLingkungan' => 'nullable|max:500'
        ],);

        if (!$this->cetak_sebelum_tanggal) {
            $this->cetak_sebelum_tanggal = now()->addDays(7)->format('Y-m-d');
        }
        if (!$this->maksimal_generate_pdf) {
            $this->maksimal_generate_pdf = 10;
        }

        $surat = layanan_surat::find($this->selectedSuratId);
        if ($surat && $surat->status_pengajuan === 'diajukan') {
            $nomorSurat = $this->generateNomorSurat($surat);
            $surat->update([
                'status_pengajuan' => 'disetujui',
                'id_kepalaLingkungan_penyetuju' => Auth::user()->id,
                'tanggal_surat_diterbitkan' => now(),
                'nomor_surat_terbitan' => $nomorSurat,
                'cetak_sebelum_tanggal' => $this->cetak_sebelum_tanggal,
                'maksimal_generate_pdf' => $this->maksimal_generate_pdf,
                'catatan_kepalaLingkungan' => $this->catatan_kepalaLingkungan,
            ]);
            session()->flash('message', [
                'type' => 'success',
                'title' => 'Surat Berhasil Disetujui',
                'description' => 'Surat dengan nomor ' . $nomorSurat . ' telah disetujui dan siap dicetak'
            ]);
        }
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->isPreviewCatatanModal = false;
        $this->isVerifikasiModal = false;
        $this->isTolakMode = false;
        $this->isSetujuiMode = false;
        $this->isViewDetailModal = false;
    }

    public function closeNotificationModal()
    {
        $this->isNotificationModal = false;
        session()->forget('message');
    }

    public function batalkanPengajuan()
    {
        $surat = layanan_surat::find($this->selectedSuratId);
        if ($surat && $surat->status_pengajuan === 'diajukan') {
            $surat->update([
                'status_pengajuan' => 'dibatalkan',
                'keperluan_surat' => 'Pengajuan surat dibatalkan oleh ' . Auth::user()->name,
            ]);
            session()->flash('message', [
                'type' => 'success',
                'title' => 'Pengajuan Surat Dibatalkan',
                'description' => 'Pengajuan surat telah berhasil dibatalkan.'
            ]);
        }
        $this->closeModal();
    }

    public function tolakPengajuan()
    {
        $this->validate([
            'catatan_kepalaLingkungan' => 'required|max:500'
        ]);

        $surat = layanan_surat::find($this->selectedSuratId);
        if ($surat && $surat->status_pengajuan === 'diajukan') {
            $surat->update([
                'status_pengajuan' => 'ditolak',
                'catatan_kepalaLingkungan' => $this->catatan_kepalaLingkungan,
            ]);
            session()->flash('message', [
                'type' => 'success',
                'title' => 'Pengajuan Surat Ditolak',
                'description' => 'Pengajuan surat telah berhasil ditolak.'
            ]);
        }
        $this->closeModal();
    }


    public function openViewDetailModal($suratId)
    {
        // Ambil data dari hasil join, bukan dari model langsung
        $surat = layanan_surat::join('penduduk_pendatang', 'layanan_surat.id_penduduk_pendatang', '=', 'penduduk_pendatang.id')
            ->join('users as pj', 'layanan_surat.id_penanggungJawab_pemohon', '=', 'pj.id')
            ->leftJoin('users as kl', 'layanan_surat.id_kepalaLingkungan_penyetuju', '=', 'kl.id')
            ->where('layanan_surat.id', $suratId)
            ->select(
                'layanan_surat.*',
                'penduduk_pendatang.nama_lengkap',
                'penduduk_pendatang.nik',
                'penduduk_pendatang.alamat_asal',
                'penduduk_pendatang.telepon',
                'pj.name as nama_penanggung_jawab',      // Nama PJ dari users
                'pj.role as role_penanggung_jawab',      // Konfirmasi role PJ
                'kl.name as nama_kepala_lingkungan',     // Nama KL dari users
                'kl.role as role_kepala_lingkungan'      // Konfirmasi role KL
            )
            ->first();

        if ($surat) {
            $this->selectedSuratId = $suratId;
            $this->nama_lengkap = $surat->nama_lengkap;
            $this->keperluan_surat = $surat->keperluan_surat;
            $this->catatan_kepalaLingkungan = $surat->catatan_kepalaLingkungan;
            $this->cetak_sebelum_tanggal = $surat->cetak_sebelum_tanggal;
            $this->maksimal_generate_pdf = $surat->maksimal_generate_pdf;
            $this->tanggal_pengajuan = $surat->tanggal_pengajuan;
            $this->tanggal_surat_diterbitkan = $surat->tanggal_surat_diterbitkan;
            $this->nomor_surat_terbitan = $surat->nomor_surat_terbitan;
            $this->jumlah_sudah_digenerate = $surat->jumlah_sudah_digenerate;

            // Data penduduk
            $this->nik = $surat->nik;
            $this->alamat_asal = $surat->alamat_asal;
            $this->jenis_surat = $surat->jenis_surat;
            $this->status_pengajuan = $surat->status_pengajuan;

            // Data penanggung jawab dan kepala lingkungan
            $this->penanggung_jawab = $surat->nama_penanggung_jawab;
            $this->kepala_lingkungan = $surat->nama_kepala_lingkungan;

            $this->isViewDetailModal = true;
        } else {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Data Tidak Ditemukan',
                'description' => 'Data surat yang dimaksud tidak ditemukan.'
            ]);
            $this->isNotificationModal = true;
        }
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
}
