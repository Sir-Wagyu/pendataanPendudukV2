<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\penduduk_pendatang;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Carbon\Carbon;


class LaporanPenduduk extends Component
{
    public $penduduk;
    public $pendudukPreview;
    public $selectedId;

    //modals
    public $showPreviewModal = false;
    public $isLoading = false;

    //data-modal
    public $isPreviewKtpOpen = false;
    public $isPreviewKtpSelfieOpen = false;
    public $provinsiNames = [];
    public $kabupatenNames = [];
    public $kecamatanNames = [];
    public $kelurahanNames = [];

    // Data untuk ringkasan cepat
    public $totalPendudukAktif = 0;
    public $pendudukBaruBulanIni = 0;
    public $pendudukKeluarBulanIni = 0;
    public $pendudukMenungguVerifikasi = 0;
    public $pendudukDitolak = 0;
    public $totalLakilaki = 0;
    public $totalPerempuan = 0;
    public $updateTerakhir = null;

    //filters
    public $search = '';
    public $filterStatus = '';
    public $filterJenisKelamin = '';


    public function mount()
    {
        $this->loadStatistik();
        $this->loadPenduduk();
    }

    public function loadStatistik()
    {
        // Total penduduk aktif (status diterima)
        $this->totalPendudukAktif = penduduk_pendatang::where('status_akun', 'diterima')->count();

        // Penduduk baru bulan ini
        $this->pendudukBaruBulanIni = penduduk_pendatang::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Penduduk keluar bulan ini (bisa berdasarkan status tertentu atau field khusus)
        // Asumsi: penduduk yang status_akun berubah menjadi 'keluar' atau field tanggal_keluar
        $this->pendudukKeluarBulanIni = penduduk_pendatang::where('status_akun', 'keluar')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();

        // Penduduk menunggu verifikasi
        $this->pendudukMenungguVerifikasi = penduduk_pendatang::where('status_akun', 'pending')->count();

        // Penduduk ditolak
        $this->pendudukDitolak = penduduk_pendatang::where('status_akun', 'ditolak')->count();

        // Total laki-laki
        $this->totalLakilaki = penduduk_pendatang::where('jenis_kelamin', 'laki-laki')->count();
        // Total perempuan
        $this->totalPerempuan = penduduk_pendatang::where('jenis_kelamin', 'perempuan')->count();

        // Update terakhir
        $latestPenduduk = penduduk_pendatang::latest('updated_at')->first();
        $this->updateTerakhir = $latestPenduduk ? $latestPenduduk->updated_at->format('d M Y H:i') : 'Belum ada data';
    }

    public function loadPenduduk()
    {
        $query = penduduk_pendatang::with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat_sekarang', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status_akun', $this->filterStatus);
        }

        if ($this->filterJenisKelamin) {
            $query->where('jenis_kelamin', $this->filterJenisKelamin);
        }

        $this->penduduk = $query->get();
    }

    public function updated($propertyName)
    {
        // Reload data ketika search atau filter berubah
        if (in_array($propertyName, ['search', 'filterStatus', 'filterJenisKelamin'])) {
            $this->loadPenduduk();
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterJenisKelamin = '';
        $this->loadPenduduk();
    }

    public function render()
    {
        return view('livewire.laporan-penduduk', [
            'penduduk' => $this->penduduk,
        ]);
    }

    public function previewPenduduk($id)
    {
        $this->isLoading = true;


        $this->selectedId = $id;
        $this->pendudukPreview = penduduk_pendatang::with('user')->find($id);

        if ($this->pendudukPreview) {
            $this->provinsiNames = $this->getProvinsi();
            $this->kabupatenNames = $this->getKabupaten($this->pendudukPreview->provinsi_asal);
            $this->kecamatanNames = $this->getKecamatan($this->pendudukPreview->kabupaten_asal);
            $this->kelurahanNames = $this->getKelurahan($this->pendudukPreview->kecamatan_asal);
        }

        $this->isLoading = false;
        $this->showPreviewModal = true;
    }

    public function getProvinsi()
    {
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $data = $response->json();
        $provinsi = [];
        foreach ($data as $item) {
            $provinsi[$item['id']] = $item['name'];
        }
        return $provinsi;
    }

    public function getKabupaten($provinsiId)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinsiId}.json");
        $data = $response->json();
        $kabupaten = [];
        foreach ($data as $item) {
            $kabupaten[$item['id']] = $item['name'];
        }
        return $kabupaten;
    }
    public function getKecamatan($kabupatenId)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$kabupatenId}.json");
        $data = $response->json();
        $kecamatan = [];
        foreach ($data as $item) {
            $kecamatan[$item['id']] = $item['name'];
        }
        return $kecamatan;
    }
    public function getKelurahan($kecamatanId)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$kecamatanId}.json");
        $data = $response->json();
        $kelurahan = [];
        foreach ($data as $item) {
            $kelurahan[$item['id']] = $item['name'];
        }
        return $kelurahan;
    }

    public function closePreviewModal()
    {
        $this->showPreviewModal = false;
        $this->pendudukPreview = null;
        $this->selectedId = null;
    }
}
