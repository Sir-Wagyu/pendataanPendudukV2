<?php

namespace App\Livewire;

use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

use App\Models\penduduk_pendatang;

use Illuminate\Support\Facades\Http;

class DataPenduduk extends Component
{
    use WithFileUploads;

    protected $listeners = ['setMapLocation'];
    public $latitude = '';
    public $longitude = '';

    public $provinsi_asal = '';
    public $kabupaten_asal = '';
    public $kecamatan_asal = '';
    public $kelurahan_asal = '';
    public $jenis_kelamin = '';

    public $provinsiOptions = [];
    public $kabupatenOptions = [];
    public $kecamatanOptions = [];
    public $kelurahanOptions = [];

    public $foto_ktp,
        $foto_selfie_ktp,
        $nik = '',
        $nama_lengkap = '',
        $telepon = '',
        $status_perkawinan = '',
        $tempat_lahir = '',
        $tanggal_lahir = '',
        $golongan_darah = '',
        $agama = '',
        $rw_asal = '',
        $rt_asal = '',
        $alamat_asal = '',
        $alamat_sekarang = '',
        $tujuan = '',
        $tanggal_masuk = '',
        $tanggal_keluar = '';

    public $id_penanggungJawab, $id_kepalaLingkungan, $status_akun, $alasan_penolakan;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $isNotificationModal = false;
    public $search = '';

    public $isModalUploadOpen = false;
    public $isModalFormOpen = false;

    public $isPreviewKtpOpen = false;
    public $isPreviewSelfieKtpOpen = false;


    public function render()
    {
        $this->dispatch('initMap');
        return view('livewire.data-penduduk', [
            'dataPenduduk' => penduduk_pendatang::all(),
        ]);
    }

    public function mount()
    {
        $this->provinsiOptions = $this->getProvinsi();
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

    public function updatedProvinsiAsal($value)
    {
        $this->kabupatenOptions = [];
        $this->kecamatanOptions = [];
        $this->kelurahanOptions = [];
        $this->kabupaten_asal = null;
        $this->kecamatan_asal = null;
        $this->kelurahan_asal = null;

        if ($value) {
            $this->kabupatenOptions = $this->getKabupaten($value);
        }
    }

    public function getKabupaten($provinsi_id)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinsi_id}.json");
        $data = $response->json();
        $kabupaten = [];
        foreach ($data as $item) {
            $kabupaten[$item['id']] = $item['name'];
        }
        return $kabupaten;
    }

    public function updatedKabupatenAsal($value)
    {
        $this->kecamatanOptions = [];
        $this->kelurahanOptions = [];
        $this->kecamatan_asal = null;
        $this->kelurahan_asal = null;

        if ($value) {
            $this->kecamatanOptions = $this->getKecamatan($value);
        }
    }

    public function getKecamatan($kabupaten_id)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$kabupaten_id}.json");
        $data = $response->json();
        $kecamatan = [];
        foreach ($data as $item) {
            $kecamatan[$item['id']] = $item['name'];
        }
        return $kecamatan;
    }

    public function updatedKecamatanAsal($value)
    {
        $this->kelurahanOptions = [];
        $this->kelurahan_asal = null;

        if ($value) {
            $this->kelurahanOptions = $this->getKelurahan($value);
        }
    }

    public function getKelurahan($kecamatan_id)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$kecamatan_id}.json");
        $data = $response->json();
        $kelurahan = [];
        foreach ($data as $item) {
            $kelurahan[$item['id']] = $item['name'];
        }
        return $kelurahan;
    }

    public function setMapLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }



    public function updatedFotoKtp()
    {
        $this->checkFilesReady();
    }

    public function updatedFotoSelfieKtp()
    {
        $this->checkFilesReady();
    }

    public function checkFilesReady()
    {
        if ($this->foto_ktp && $this->foto_selfie_ktp) {
            $this->dispatch('init-map'); // Kirim event ke browser
        }
    }



    public function simpan()
    {
        // $this->validate();
        // $this->photo->store('photos', 'public');
        // $this->photo = null;  // reset
        // $this->iteration++;

        // session()->flash('success', 'Photo saved successfully!');

        dd(request()->all());
    }

    public function resetInputFields()
    {
        $this->nik = '';
        $this->nama_lengkap = '';
        $this->telepon = '';
        $this->status_perkawinan = '';
        $this->jenis_kelamin = '';
        $this->tempat_lahir = '';
        $this->tanggal_lahir = '';
        $this->golongan_darah = '';
        $this->agama = '';
        $this->provinsi_asal = '';
        $this->kabupaten_asal = '';
        $this->kecamatan_asal = '';
        $this->kelurahan_asal = '';
        $this->rw_asal = '';
        $this->rt_asal = '';
        $this->alamat_asal = '';
        $this->alamat_sekarang = '';
        $this->latitude = '';
        $this->longitude = '';
        $this->tujuan = '';
        $this->tanggal_masuk = '';
        $this->tanggal_keluar = '';
    }

    public function openUploadModal()
    {
        $this->isModalUploadOpen = true;
        $this->isModalFormOpen = false;
        $this->dispatch('modalUploadOpened');
        $this->resetInputFields();
    }

    public function closeUploadModal()
    {
        $this->isModalUploadOpen = false;
        $this->dispatch('modalUploadClosed');
        $this->resetInputFields();
    }

    public function uploadFotoKTP()
    {
        $this->validate([
            'foto_ktp' => 'required|image',
            'foto_selfie_ktp' => 'required|image',
        ], [
            'foto_ktp.required' => 'Foto KTP harus diunggah.',
            'foto_ktp.image' => 'File yang diunggah harus berupa gambar.',
            'foto_selfie_ktp.required' => 'Foto selfie KTP harus diunggah.',
            'foto_selfie_ktp.image' => 'File yang diunggah harus berupa gambar.',
            'foto_selfie_ktp.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        $this->isModalUploadOpen = false;
        $this->isModalFormOpen = true;
    }

    public function save()
    {
        $this->validate([
            'id_penanggungJawab' => 'required',
            'id_kepalaLingkungan' => 'required',
            'foto_ktp' => 'required|image|max:2048',
            'foto_selfie_ktp' => 'required|image|max:2048',
            'status_akun' => 'required',
            'alasan_penolakan' => 'required',
            'nik' => 'required|unique:penduduk_pendatang,nik',
            'nama_lengkap' => 'required',
            'telepon'   => 'required',
            'status_perkawinan' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'golongan_darah' => 'required',
            'agama' => 'required',
            'provinsi_asal' => 'required',
            'kabupaten_asal' => 'required',
            'kecamatan_asal' => 'required',
            'kelurahan_asal' => 'required',
            'rw_asal' => 'required',
            'rt_asal' => 'required',
            'alamat_asal' => 'required',
            'alamat_sekarang' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'tujuan' => 'required',
            'tanggal_masuk' => 'required',
            'tanggal_keluar' => 'required',
        ]);

        $path = $this->foto_ktp->store('image.ktp', 'public');
        $path2 = $this->foto_selfie_ktp->store('image.selfie', 'public');

        penduduk_pendatang::create([
            'id_penanggungJawab' => $this->id_penanggungJawab,
            'id_kepalaLingkungan' => $this->id_kepalaLingkungan,
            'foto_ktp' => $path,
            'foto_selfie_ktp' => $path2,
            'status_akun' => 'pending',
            'alasan_penolakan' => '',
            'nik' => $this->nik,
            'nama_lengkap' => $this->nama_lengkap,
            'telepon'   => $this->telepon,
            'status_perkawinan' => $this->status_perkawinan,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'golongan_darah' => $this->golongan_darah,
            'agama' => $this->agama,
            'provinsi_asal' => $this->provinsi_asal,
            'kabupaten_asal' => $this->kabupaten_asal,
            'kecamatan_asal' => $this->kecamatan_asal,
            'kelurahan_asal' => $this->kelurahan_asal,
            'rw_asal' => $this->rw_asal,
            'rt_asal' => $this->rt_asal,
            'alamat_asal' => $this->alamat_asal,
            'alamat_sekarang' => $this->alamat_sekarang,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'tujuan' => $this->tujuan,
            'tanggal_masuk' => $this->tanggal_masuk,
            'tanggal_keluar' => $this->tanggal_keluar
        ]);
        $this->reset(['isModalFormOpen', 'isModalUploadOpen', 'foto_ktp', 'foto_selfie_ktp']);
        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => 'Data berhasil ditambahkan.'
        ]);
    }
}
