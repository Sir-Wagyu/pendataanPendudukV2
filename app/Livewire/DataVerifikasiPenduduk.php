<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\penduduk_pendatang;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class DataVerifikasiPenduduk extends Component
{
    public $provinsiNames = [];
    public $kabupatenNames = [];
    public $kecamatanNames = [];
    public $kelurahanNames = [];
    public $penanggungJawabNames = [];
    public $kepalaLingkunganNames = [];

    public $selectedId, $alasan_penolakan;
    public $pendudukPreview;

    public $id_provinsi, $id_kabupaten, $id_kecamatan, $id_kelurahan;

    public $isAlasanModal = false;
    public $isPerbaikanMode = false;
    public $isTerimaModal = false;
    public $isNotificationModal = false;
    public $isPreviewModal = false;
    public $isPreviewKtpOpen = false;
    public $isPreviewKtpSelfieOpen = false;

    public function mount()
    {
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $this->provinsiNames = collect($response->json())->pluck('name', 'id')->toArray();

        $this->penanggungJawabNames = User::where('role', 'penanggungJawab')->orWhere('role', 'admin')->get()->pluck('name', 'id')->toArray();

        $this->kepalaLingkunganNames = User::where('role', 'kepalaLingkungan')->get()->pluck('name', 'id')->toArray();
    }

    public function render()
    {
        if (session()->has('message')) {
            $this->isNotificationModal = true;
        } else {
            $this->isNotificationModal = false;
        }

        return view('livewire.data-verifikasi-penduduk', [
            'penduduks' => penduduk_pendatang::where('status_akun', 'pending')->get(),
        ]);
    }

    public function showAlasanModal($id)
    {
        $this->selectedId = $id;
        $this->isAlasanModal = true;
    }

    public function closeAlasanModal()
    {
        $this->isAlasanModal = false;
    }

    public function showAlasanPerbaikanModal($id)
    {
        $this->selectedId = $id;
        $this->isPerbaikanMode = true;
        $this->isAlasanModal = true;
    }

    public function closeAlasanPerbaikanModal()
    {
        $this->isPerbaikanMode = false;
        $this->isAlasanModal = false;
    }

    public function tolakPenduduk()
    {
        $penduduk = penduduk_pendatang::find($this->selectedId);
        $this->validate([
            'alasan_penolakan' => 'required|string|max:255',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan harus diisi.',
        ]);

        $penduduk->status_akun = 'ditolak';
        $penduduk->alasan_penolakan = $this->alasan_penolakan;
        $penduduk->save();

        session()->flash('message', [
            'title' => 'Data Penduduk Berhasil Ditolak',
            'type' => 'success',
            'description' => 'Penduduk dengan NIK ' . $penduduk->nik . ' telah ditolak.',
        ]);
        $this->isAlasanModal = false;
    }

    public function perbaikanDataPenduduk()
    {
        $penduduk = penduduk_pendatang::find($this->selectedId);
        $penduduk->status_akun = 'ulangi';
        $penduduk->save();
        session()->flash('message', [
            'title' => 'Data Penduduk Berhasil Dikirim Ulang',
            'type' => 'success',
            'description' => 'Penduduk dengan NIK ' . $penduduk->nik . ' telah dikirim ulang untuk perbaikan.',
        ]);
        $this->isAlasanModal = false;
    }



    public function showPreviewModal($selectedId)
    {
        $this->selectedId = $selectedId;


        $penduduk = penduduk_pendatang::find($selectedId);
        $this->pendudukPreview = $penduduk;
        $this->isPreviewModal = true;

        if ($penduduk && $penduduk->provinsi_asal) {
            $responseKabupaten = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/' . $penduduk->provinsi_asal . '.json');
            $this->kabupatenNames = collect($responseKabupaten->json())->pluck('name', 'id')->toArray();
        } else {
            $this->kabupatenNames = [];
        }
        if ($penduduk && $penduduk->kabupaten_asal) {
            $responseKecamatan = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/districts/' . $penduduk->kabupaten_asal . '.json');
            $this->kecamatanNames = collect($responseKecamatan->json())->pluck('name', 'id')->toArray();
        } else {
            $this->kecamatanNames = [];
        }
        if ($penduduk && $penduduk->kecamatan_asal) {
            $responseKelurahan = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/villages/' . $penduduk->kecamatan_asal . '.json');
            $this->kelurahanNames = collect($responseKelurahan->json())->pluck('name', 'id')->toArray();
        } else {
            $this->kelurahanNames = [];
        }
    }

    public function closePreviewModal()
    {
        $this->isPreviewModal = false;
    }

    public function showTerimaModal($selectedId)
    {
        $this->selectedId = $selectedId;
        $this->isTerimaModal = true;
    }

    public function closeTerimaModal()
    {
        $this->isTerimaModal = false;
    }

    public function closeNotificationModal()
    {
        session()->forget('message');
        $this->isNotificationModal = false;
    }

    public function terimaPenduduk()
    {
        $penduduk = penduduk_pendatang::find($this->selectedId);
        $penduduk->status_akun = 'diterima';
        $penduduk->alasan_penolakan = '';
        $penduduk->save();

        session()->flash('message', [
            'title' => 'Verifikasi Penduduk Berhasil',
            'type' => 'success',
            'description' => 'Penduduk dengan NIK ' . $penduduk->nik . ' telah Disetujui.',
        ]);
        $this->closeTerimaModal();
    }
}
