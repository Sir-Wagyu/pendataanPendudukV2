<?php

namespace App\Livewire;

use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use App\Models\User;


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
        $tanggal_keluar = '',
        $id_kepalaLingkungan = '';

    public $id_penanggungJawab, $status_akun, $alasan_penolakan;
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

        if ($this->search) {
            return view('livewire.data-penduduk', [
                'penduduk' => penduduk_pendatang::where('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat_asal', 'like', '%' . $this->search . '%')
                    ->orWhere('telepon', 'like', '%' . $this->search . '%')
                    ->get(),
            ]);
        }

        if (session()->has('message')) {
            $this->isNotificationModal = true;
        } else {
            $this->isNotificationModal = false;
        }

        return view('livewire.data-penduduk', [
            'penduduk' => penduduk_pendatang::all(),
            'kepalaLingkungan' => User::where('role', 'kepalaLingkungan')->get(),
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

    public function simpan()
    {
        $this->validate([
            'nik' => 'required|numeric|digits:16|unique:penduduk_pendatang,nik',
            'nama_lengkap' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'status_perkawinan' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'golongan_darah' => 'nullable|string|max:3',
            'agama' => 'required|string|max:50',
            'provinsi_asal' => 'required|string',
            'kabupaten_asal' => 'required|string',
            'kecamatan_asal' => 'required|string',
            'kelurahan_asal' => 'required|string',
            'rw_asal' => 'nullable|string|max:5',
            'rt_asal' => 'nullable|string|max:5',
            'alamat_asal' => 'required|string|max:255',
            'alamat_sekarang' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
            'tujuan' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'foto_ktp' => 'required|image|max:2048',
            'foto_selfie_ktp' => 'required|image|max:2048',
            'id_kepalaLingkungan' => 'required|exists:users,id',
        ]);



        $ktpPath = $this->foto_ktp->store('ktp', 'public');
        $selfiePath = $this->foto_selfie_ktp->store('selfie_ktp', 'public');

        penduduk_pendatang::create([
            'nik' => $this->nik,
            'nama_lengkap' => $this->nama_lengkap,
            'telepon' => $this->telepon,
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
            'rw_asal' => $this->rw_asal ?? '000',
            'rt_asal' => $this->rt_asal ?? '000',
            'alamat_asal' => $this->alamat_asal,
            'alamat_sekarang' => $this->alamat_sekarang,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'tujuan' => $this->tujuan,
            'tanggal_masuk' => $this->tanggal_masuk,
            'tanggal_keluar' => $this->tanggal_keluar,
            'foto_ktp' => $ktpPath,
            'foto_selfie_ktp' => $selfiePath,
            'id_kepalaLingkungan' => $this->id_kepalaLingkungan,
            'status_akun' => 'pending',
            'id_penanggungJawab' => \Illuminate\Support\Facades\Auth::id(),
            'alasan_penolakan' => null,
        ]);

        $this->closeUploadModal();
        session()->flash('message', [
            'title' => 'Data penduduk pendatang berhasil disimpan.',
            'type' => 'success',
            'description' => 'Data penduduk pendatang dengan NIK ' . $this->nik . ' telah disimpan.'
        ]);

        $this->resetInputFields();
    }
}
