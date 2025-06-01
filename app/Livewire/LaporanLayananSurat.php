<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\layanan_surat; // Sesuaikan dengan model Anda
use Illuminate\Support\Facades\DB;

class LaporanLayananSurat extends Component
{
    public $search = '';
    public $filterStatus = '';
    public $filterJenisSurat = '';

    public $showPreviewModal = false;
    public $suratPreview;

    public $totalPengajuan = 0;
    public $totalDisetujui = 0;
    public $totalDitolak = 0;
    public $jenisTerpopuler = '';

    public function mount()
    {
        $this->loadStatistik();
    }

    public function loadStatistik()
    {
        $this->totalPengajuan = layanan_surat::count();
        $this->totalDisetujui = layanan_surat::where('status_pengajuan', 'disetujui')->count();
        $this->totalDitolak = layanan_surat::where('status_pengajuan', 'ditolak')->count();

        // Cari jenis surat terpopuler
        $terpopuler = layanan_surat::select('jenis_surat', DB::raw('count(*) as total'))
            ->groupBy('jenis_surat')
            ->orderBy('total', 'desc')
            ->first();

        $this->jenisTerpopuler = $terpopuler ? $this->getJenisSuratReadable($terpopuler->jenis_surat) : 'Belum Ada';
    }

    public function updatedSearch()
    {
        // Refresh data ketika search berubah
    }

    public function updatedFilterStatus()
    {
        // Refresh data ketika filter status berubah
    }

    public function updatedFilterJenisSurat()
    {
        // Refresh data ketika filter jenis surat berubah
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterJenisSurat = '';
    }

    public function previewSurat($id)
    {
        $this->suratPreview = layanan_surat::with(['penduduk', 'penanggungJawab', 'kepalaLingkungan'])->find($id);
        $this->showPreviewModal = true;
    }

    public function closePreviewModal()
    {
        $this->showPreviewModal = false;
        $this->suratPreview = null;
    }

    public function downloadSurat($id)
    {
        return redirect()->route('cetak.surat', $id);
    }

    public function getJenisSuratReadable($jenis)
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

    public function render()
    {
        $query = layanan_surat::with(['penduduk', 'penanggungJawab', 'kepalaLingkungan']);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nomor_surat', 'like', '%' . $this->search . '%')
                    ->orWhere('jenis_surat', 'like', '%' . $this->search . '%')
                    ->orWhereHas('penduduk', function ($subQ) {
                        $subQ->where('nama_lengkap', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Apply status filter
        if ($this->filterStatus) {
            $query->where('status_pengajuan', $this->filterStatus);
        }

        // Apply jenis surat filter
        if ($this->filterJenisSurat) {
            $query->where('jenis_surat', $this->filterJenisSurat);
        }

        $layananSurat = $query->orderBy('created_at', 'desc')->get();

        return view('livewire.laporan-layanan-surat', [
            'layananSurat' => $layananSurat
        ]);
    }
}
