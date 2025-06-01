<?php

namespace App\Livewire;

use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\layanan_surat;



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

    public $penanggungJawabNames = [];


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
    public $alasanPenolakanPreview = null;

    public $isEditMode = false;
    public $isVerifikasiUlangMode = false;
    public $isPendatangKembaliMode = false;
    public $isPengajuanMode = false;
    public $search = '';
    public $selectedId;
    public $isPreviewAlasanModal = false;

    public $isModalUploadOpen = false;
    public $isModalFormOpen = false;

    public $isPreviewKtpOpen = false;
    public $isPreviewSelfieKtpOpen = false;

    public $isVerifikasiModal = false;

    // variables for preview modal
    public $isPreviewModal = false;
    public $pendudukPreview;
    public $isPreviewKtpSelfieOpen = false;
    public $provinsiNames = [];
    public $kabupatenNames = [];
    public $kecamatanNames = [];
    public $kelurahanNames = [];
    public $kepalaLingkunganNames = [];

    public $jenis_surat = '';
    public $jenisSuratOptions = [];
    public $keperluan_surat = '';
    public $suratTerblokir = [];

    public $barang_hilang = '';
    public $waktu_kehilangan = '';
    public $lokasi_kehilangan = '';

    public $nama_anak = '';
    public $tempat_lahir_anak = '';
    public $tanggal_lahir_anak = '';
    public $nama_sekolah = '';




    public function render()
    {

        $user = Auth::user();
        $query = penduduk_pendatang::query();

        if ($user->role === 'kepalaLingkungan') {
            $query->where('id_kepalaLingkungan', $user->id);
        } elseif ($user->role === 'penanggungJawab') {
            $query->where('id_penanggungJawab', $user->id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat_asal', 'like', '%' . $this->search . '%')
                    ->orWhere('telepon', 'like', '%' . $this->search . '%');
            });
        }

        $penduduk = $query->get();

        if (session()->has('message')) {
            $this->isNotificationModal = true;
        } else {
            $this->isNotificationModal = false;
        }

        return view('livewire.data-penduduk', [
            'penduduk' => $penduduk,
            'kepalaLingkungan' => User::where('role', 'kepalaLingkungan')->get(),
        ]);
    }

    public function mount()
    {
        $this->provinsiOptions = $this->getProvinsi();
        $this->penanggungJawabNames = User::where('role', 'penanggungJawab')->orWhere('role', 'admin')->get()->pluck('name', 'id')->toArray();
        $this->kepalaLingkunganNames = User::where('role', 'kepalaLingkungan')->get()->pluck('name', 'id')->toArray();
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
        $this->foto_ktp = '';
        $this->foto_selfie_ktp = '';
        $this->id_kepalaLingkungan = '';
        $this->id_penanggungJawab = '';
        $this->kabupatenOptions = [];
        $this->kecamatanOptions = [];
        $this->kelurahanOptions = [];
        $this->jenis_surat = '';
        $this->jenisSuratOptions = [];
        $this->keperluan_surat = '';
        $this->suratTerblokir = [];
        $this->barang_hilang = '';
        $this->waktu_kehilangan = '';
        $this->lokasi_kehilangan = '';
        $this->nama_anak = '';
        $this->tempat_lahir_anak = '';
        $this->tanggal_lahir_anak = '';
        $this->nama_sekolah = '';
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



    public function openPreviewModal($selectedId)
    {
        $this->selectedId = $selectedId;
        $penduduk = penduduk_pendatang::find($selectedId);
        $this->pendudukPreview = $penduduk;
        $this->isPreviewModal = true;

        // fetching provinsi dan masukkan ke provisiNames
        $responseProvinsi = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $this->provinsiNames = collect($responseProvinsi->json())->pluck('name', 'id')->toArray();

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
            'nik' => [
                'required',
                'numeric',
                'digits:16',
                $this->isEditMode
                    ? 'unique:penduduk_pendatang,nik,' . $this->selectedId
                    : 'unique:penduduk_pendatang,nik'
            ],
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
            'foto_ktp' => $this->isEditMode
                ? (is_object($this->foto_ktp) ? 'required|image|max:2048' : 'required')
                : 'required|image|max:2048',
            'foto_selfie_ktp' => $this->isEditMode
                ? (is_object($this->foto_selfie_ktp) ? 'required|image|max:2048' : 'required')
                : 'required|image|max:2048',
            'id_kepalaLingkungan' => 'required|exists:users,id',
        ]);

        if ($this->isEditMode && $this->selectedId) {
            $penduduk = penduduk_pendatang::find($this->selectedId);

            // Overwrite existing KTP photo if a new one is uploaded
            if ($this->foto_ktp && is_object($this->foto_ktp)) {
                $ktpPath = $penduduk->foto_ktp;
                $this->foto_ktp->storeAs(
                    dirname($ktpPath),
                    basename($ktpPath),
                    'public'
                );
            } else {
                $ktpPath = $penduduk->foto_ktp;
            }

            // Overwrite existing selfie KTP photo if a new one is uploaded
            if ($this->foto_selfie_ktp && is_object($this->foto_selfie_ktp)) {
                $selfiePath = $penduduk->foto_selfie_ktp;
                $this->foto_selfie_ktp->storeAs(
                    dirname($selfiePath),
                    basename($selfiePath),
                    'public'
                );
            } else {
                $selfiePath = $penduduk->foto_selfie_ktp;
            }

            $penduduk->update([
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
            ]);
            session()->flash('message', [
                'title' => 'Data penduduk pendatang berhasil diperbarui.',
                'type' => 'success',
                'description' => 'Data penduduk pendatang dengan NIK ' . $this->nik . ' telah diperbarui.'
            ]);
            $this->closeEditModal();

            $this->resetInputFields();
        } else {
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
                'tanggal_keluar' => null,
                'foto_ktp' => $ktpPath,
                'foto_selfie_ktp' => $selfiePath,
                'id_kepalaLingkungan' => $this->id_kepalaLingkungan,
                'status_akun' => 'pending',
                'id_penanggungJawab' => \Illuminate\Support\Facades\Auth::id(),
                'alasan_penolakan' => null,
            ]);

            session()->flash('message', [
                'title' => 'Data penduduk pendatang berhasil disimpan.',
                'type' => 'success',
                'description' => 'Data penduduk pendatang dengan NIK ' . $this->nik . ' telah disimpan.'
            ]);
            $this->closeUploadModal();
            $this->resetInputFields();
        }
    }



    public function openDeleteModal($selectedId)
    {
        $this->selectedId = $selectedId;
        $this->isVerifikasiModal = true;
    }

    public function deletePenduduk()
    {
        $this->validate([
            'selectedId' => 'required|exists:penduduk_pendatang,id',
        ]);

        $penduduk = penduduk_pendatang::find($this->selectedId);
        if ($penduduk) {
            $penduduk->status_akun = 'keluar';
            $penduduk->tanggal_keluar = now();
            $penduduk->save();
            session()->flash('message', [
                'title' => 'Data Penduduk Berhasil Dihapus',
                'type' => 'success',
                'description' => 'Penduduk dengan NIK ' . $penduduk->nik . ' telah dihapus.',
            ]);
        }

        $this->isVerifikasiModal = false;
    }

    public function closeDeleteModal()
    {
        $this->isVerifikasiModal = false;
        $this->isVerifikasiUlangMode = false;
        $this->isPendatangKembaliMode = false;
    }


    public function openVerifikasiUlangModal($selectedId)
    {
        $this->selectedId = $selectedId;
        $this->isVerifikasiUlangMode = true;
        $this->isVerifikasiModal = true;
    }

    public function verifikasiUlangPenduduk()
    {
        $this->validate([
            'selectedId' => 'required|exists:penduduk_pendatang,id',
        ]);

        $penduduk = penduduk_pendatang::find($this->selectedId);
        if ($penduduk) {
            $penduduk->status_akun = 'pending';
            $penduduk->alasan_penolakan = null;
            $penduduk->save();
            session()->flash('message', [
                'title' => 'Data Penduduk Berhasil Diperbaiki',
                'type' => 'success',
                'description' => 'Penduduk dengan NIK ' . $penduduk->nik . ' telah diperbaiki.',
            ]);
        }

        $this->isVerifikasiModal = false;
    }

    public function closeVerifikasiUlangModal()
    {
        $this->isVerifikasiModal = false;
        $this->isPendatangKembaliMode = false;
        $this->isVerifikasiUlangMode = false;
    }

    public function openPendatangKembaliModal($selectedId)
    {
        $this->selectedId = $selectedId;
        $this->isPendatangKembaliMode = true;
        $this->isVerifikasiModal = true;
    }

    public function pendatangKembali()
    {
        $this->validate([
            'selectedId' => 'required|exists:penduduk_pendatang,id',
        ]);

        $penduduk = penduduk_pendatang::find($this->selectedId);
        if ($penduduk) {
            $penduduk->status_akun = 'pending';
            $penduduk->alasan_penolakan = null;
            $penduduk->save();
            session()->flash('message', [
                'title' => 'Status Penduduk Berhasil Diupdate',
                'type' => 'success',
                'description' => 'Penduduk dengan NIK ' . $penduduk->nik . 'Dimintai Validasi Kembali.',
            ]);
        }

        $this->isVerifikasiModal = false;
    }

    public function closePendatangKembaliModal()
    {
        $this->isVerifikasiModal = false;
        $this->isVerifikasiUlangMode = false;
        $this->isPendatangKembaliMode = false;
    }




    public function openEditModal($selectedId)
    {
        $this->selectedId = $selectedId;
        $penduduk = penduduk_pendatang::find($selectedId);
        if ($penduduk) {
            $this->foto_ktp = $penduduk->foto_ktp;
            $this->foto_selfie_ktp = $penduduk->foto_selfie_ktp;
            $this->nik = $penduduk->nik;
            $this->nama_lengkap = $penduduk->nama_lengkap;
            $this->telepon = $penduduk->telepon;
            $this->status_perkawinan = $penduduk->status_perkawinan;
            $this->jenis_kelamin = $penduduk->jenis_kelamin;
            $this->tempat_lahir = $penduduk->tempat_lahir;
            $this->tanggal_lahir = $penduduk->tanggal_lahir;
            $this->golongan_darah = $penduduk->golongan_darah;
            $this->agama = $penduduk->agama;
            $this->provinsi_asal = $penduduk->provinsi_asal;
            $this->kabupatenOptions = $this->getKabupaten($penduduk->provinsi_asal);
            $this->kabupaten_asal = $penduduk->kabupaten_asal;
            $this->kecamatanOptions = $this->getKecamatan($penduduk->kabupaten_asal);
            $this->kecamatan_asal = $penduduk->kecamatan_asal;
            $this->kelurahanOptions = $this->getKelurahan($penduduk->kecamatan_asal);
            $this->kelurahan_asal = $penduduk->kelurahan_asal;

            $this->rw_asal = $penduduk->rw_asal ?? '000';
            $this->rt_asal = $penduduk->rt_asal ?? '000';
            $this->alamat_asal = $penduduk->alamat_asal;
            $this->alamat_sekarang = $penduduk->alamat_sekarang;
            $this->latitude = $penduduk->latitude;
            $this->longitude = $penduduk->longitude;
            $this->tujuan = $penduduk->tujuan;
            $this->tanggal_masuk = $penduduk->tanggal_masuk;
            $this->tanggal_keluar = $penduduk->tanggal_keluar;
            $this->id_kepalaLingkungan = $penduduk->id_kepalaLingkungan;
        }

        // Open the edit modal
        // Example: 
        //   this.isEditMode = true
        $this->isEditMode = true;
        $this->isModalUploadOpen = true;
    }

    public function closeEditModal()
    {
        $this->isModalUploadOpen = false;
        $this->isEditMode = false;
        $this->resetInputFields();
    }

    public function openAlasanModal($selectedId)
    {
        $this->selectedId = $selectedId;
        $this->alasan_penolakan = penduduk_pendatang::find($selectedId)->alasan_penolakan;
        $this->isPreviewAlasanModal = true;
    }


    public function openPengajuanModal($selectedId)
    {
        $this->selectedId = $selectedId;
        $this->isPengajuanMode = true;
        $this->isVerifikasiModal = true;

        $this->jenisSuratOptions = layanan_surat::getJenisSuratOptions();


        $this->suratTerblokir = layanan_surat::where('id_penduduk_pendatang', $selectedId)
            ->whereIn('status_pengajuan', ['diajukan', 'disetujui'])
            ->pluck('jenis_surat')
            ->toArray();
    }

    public function pengajuanSurat()
    {

        $this->validate([
            'selectedId' => 'required|exists:penduduk_pendatang,id',
            'jenis_surat' => 'required|string',
        ], [
            'selectedId.required' => 'Penduduk yang dipilih tidak valid.',
            'jenis_surat.required' => 'Jenis surat harus dipilih.',
        ]);

        $this->validateDataTambahan();

        try {
            if ($this->jenis_surat === 'surat_keterangan_kehilangan_lokal' || $this->jenis_surat === 'surat_keterangan_untuk_sekolah_anak') {
                if ($this->jenis_surat === 'surat_keterangan_kehilangan_lokal') {
                    $dataTambahan = [
                        'barang_hilang' => $this->barang_hilang,
                        'waktu_kehilangan' => $this->waktu_kehilangan,
                        'lokasi_kehilangan' => $this->lokasi_kehilangan,
                    ];
                } elseif ($this->jenis_surat === 'surat_keterangan_untuk_sekolah_anak') {
                    $dataTambahan = [
                        'nama_anak' => $this->nama_anak,
                        'tempat_lahir_anak' => $this->tempat_lahir_anak,
                        'tanggal_lahir_anak' => $this->tanggal_lahir_anak,
                        'nama_sekolah' => $this->nama_sekolah,
                    ];
                }
            } else {
                $dataTambahan = null;
            }

            layanan_surat::create([
                'id_penduduk_pendatang' => $this->selectedId,
                'jenis_surat' => $this->jenis_surat,
                'keperluan_surat' => $this->keperluan_surat,
                'data_tambahan' => $dataTambahan,
                'status_pengajuan' => 'diajukan',
                'tanggal_pengajuan' => now(),
                'id_penanggungJawab_pemohon' => Auth::user()->id,
            ]);

            session()->flash('message', [
                'type' => 'success',
                'title' => 'Pengajuan Berhasil!',
                'description' => 'Pengajuan surat telah berhasil diajukan dan menunggu persetujuan dari Kepala Lingkungan.'
            ]);

            $this->closePengajuanModal();
            $this->isNotificationModal = true;
        } catch (\Exception $e) {
            Log::error('Error pengajuan surat: ' . $e->getMessage());

            session()->flash('message', [
                'type' => 'error',
                'title' => 'Gagal Mengajukan!',
                'description' => 'Terjadi kesalahan saat mengajukan surat. Silakan coba lagi.'
            ]);

            $this->closePengajuanModal();
            $this->isNotificationModal = true;
        }
    }

    private function getJudulSurat($jenis_surat)
    {
        if ($jenis_surat === 'surat_keterangan_domisili') {
            return 'Surat Keterangan Domisili';
        } elseif ($jenis_surat === 'surat_pengantar_umum') {
            return 'Surat Pengantar Umum';
        } elseif ($jenis_surat === 'surat_pengantar_skck') {
            return 'Surat Pengantar SKCK';
        } elseif ($jenis_surat === 'surat_keterangan_kehilangan_lokal') {
            return 'Surat Keterangan Kehilangan Lokal';
        } elseif ($jenis_surat === 'surat_keterangan_untuk_sekolah_anak') {
            return 'Surat Keterangan Untuk Sekolah Anak';
        }
    }

    private function validateDataTambahan()
    {
        switch ($this->jenis_surat) {
            case 'surat_keterangan_hilang_lokal':
                $this->validate([
                    'barang_hilang' => 'required|string|min:3',
                    'waktu_kehilangan' => 'required|date',
                    'lokasi_kehilangan' => 'required|string|min:5',
                ], [
                    'barang_hilang.required' => 'Barang/dokumen yang hilang harus diisi',
                    'barang_hilang.min' => 'Barang/dokumen yang hilang minimal 3 karakter',
                    'waktu_kehilangan.required' => 'Waktu kehilangan harus diisi',
                    'lokasi_kehilangan.required' => 'Lokasi kehilangan harus diisi',
                    'lokasi_kehilangan.min' => 'Lokasi kehilangan minimal 5 karakter',
                ]);
                break;

            case 'surat_keterangan_untuk_sekolah_anak':
                $this->validate([
                    'nama_anak' => 'required|string|min:3',
                    'tempat_lahir_anak' => 'required|string|min:3',
                    'tanggal_lahir_anak' => 'required|date|before:today',
                    'nama_sekolah' => 'required|string|min:5',
                ], [
                    'nama_anak.required' => 'Nama anak harus diisi',
                    'nama_anak.min' => 'Nama anak minimal 3 karakter',
                    'tempat_lahir_anak.required' => 'Tempat lahir anak harus diisi',
                    'tempat_lahir_anak.min' => 'Tempat lahir anak minimal 3 karakter',
                    'tanggal_lahir_anak.required' => 'Tanggal lahir anak harus diisi',
                    'tanggal_lahir_anak.before' => 'Tanggal lahir anak harus sebelum hari ini',
                    'nama_sekolah.required' => 'Nama sekolah harus diisi',
                    'nama_sekolah.min' => 'Nama sekolah minimal 5 karakter',
                ]);
                break;
        }
    }

    private function prepareDataTambahan()
    {
        $dataTambahan = [];

        switch ($this->jenis_surat) {
            case 'surat_keterangan_hilang_lokal':
                $dataTambahan = [
                    'barang_hilang' => $this->barang_hilang,
                    'waktu_kehilangan' => $this->waktu_kehilangan,
                    'lokasi_kehilangan' => $this->lokasi_kehilangan,
                ];
                break;

            case 'surat_keterangan_untuk_sekolah_anak':
                $dataTambahan = [
                    'nama_anak' => $this->nama_anak,
                    'tempat_lahir_anak' => $this->tempat_lahir_anak,
                    'tanggal_lahir_anak' => $this->tanggal_lahir_anak,
                    'nama_sekolah' => $this->nama_sekolah,
                ];
                break;

            default:
                $dataTambahan = null;
                break;
        }



        return $dataTambahan;
    }

    public function closePengajuanModal()
    {
        $this->isPengajuanMode = false;
        $this->isVerifikasiModal = false;
        $this->resetInputFields();
    }
}
