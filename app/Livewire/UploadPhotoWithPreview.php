<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UploadPhotoWithPreview extends Component
{

    public $provinsi = '';
    public $kabupaten = '';
    public $kecamatan = '';
    public $kelurahan = '';

    public $provinsiList = [];
    public $kabupatenList = [];
    public $kecamatanList = [];
    public $kelurahanList = [];

    public function mount()
    {
        $this->fetchProvinsi();
    }

    public function updatedProvinsi($value)
    {
        $this->kabupaten = '';
        $this->kecamatan = '';
        $this->kelurahan = '';
        $this->kabupatenList = [];
        $this->kecamatanList = [];
        $this->kelurahanList = [];

        $this->fetchKabupaten($value);
    }

    public function updatedKabupaten($value)
    {
        $this->kecamatan = '';
        $this->kelurahan = '';
        $this->kecamatanList = [];
        $this->kelurahanList = [];

        $this->fetchKecamatan($value);
    }

    public function updatedKecamatan($value)
    {
        $this->kelurahan = '';
        $this->kelurahanList = [];

        $this->fetchKelurahan($value);
    }

    public function fetchProvinsi()
    {
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $this->provinsiList = $response->json();
    }

    public function fetchKabupaten($provinsi_id)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinsi_id}.json");
        $this->kabupatenList = $response->json();
    }

    public function fetchKecamatan($kabupaten_id)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$kabupaten_id}.json");
        $this->kecamatanList = $response->json();
    }

    public function fetchKelurahan($kecamatan_id)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$kecamatan_id}.json");
        $this->kelurahanList = $response->json();
    }


    public function render()
    {
        return view('livewire.upload-photo-with-preview');
    }
}
