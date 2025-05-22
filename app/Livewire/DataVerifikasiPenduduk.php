<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\penduduk_pendatang;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class DataVerifikasiPenduduk extends Component
{
    public $provinsiNames = [];
    public $penanggungJawabNames = [];

    public $selectedId, $alasan_penolakan;

    public $isAlasanModal = false;
    public $isNotificationModal = false;

    public function mount()
    {
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        $this->provinsiNames = collect($response->json())->pluck('name', 'id')->toArray();

        $this->penanggungJawabNames = User::where('role', 'penanggungJawab')->orWhere('role', 'admin')->get()->pluck('name', 'id')->toArray();

        if (session()->has('message')) {
            $this->isNotificationModal = true;
        } else {
            $this->isNotificationModal = false;
        }
    }

    public function render()
    {
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
}
