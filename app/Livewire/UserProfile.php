<?php
// app/Livewire/UserProfile.php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfile extends Component
{
    // Properties
    public $name;
    public $email;
    public $telepon;
    public $latitude;
    public $longitude;
    public $alamat;

    // Password properties
    public $passwordLama;
    public $passwordBaru;
    public $password_confirmation;

    // View state
    public $currentView = 'profile';
    public $isLoading = false;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->telepon = $user->telepon;
        $this->latitude = $user->latitude;
        $this->longitude = $user->longitude;
        $this->alamat = $user->alamat;

        if (request()->is('user-profile/ganti-password')) {
            $this->currentView = 'change-password';
        }
    }

    public function render()
    {
        return view('livewire.user-profile');
    }

    public function changePassword()
    {
        $this->isLoading = true;
        $this->validate([
            'passwordLama' => 'required',
            'passwordBaru' => 'required|min:6',
            'password_confirmation' => 'required|same:passwordBaru',
        ], [
            'passwordLama.required' => 'Password lama harus diisi',
            'passwordBaru.required' => 'Password baru harus diisi',
            'passwordBaru.min' => 'Password minimal 6 karakter',
            'password_confirmation.required' => 'Konfirmasi password harus diisi',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok',
        ]);

        $user = User::find(Auth::id());
        if (!$user) {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'User tidak ditemukan',
            ]);
            return;
        }

        if (!Hash::check($this->passwordLama, $user->password)) {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Password Lama Salah',
                'description' => 'Password lama yang Anda masukkan tidak sesuai.'
            ]);
            return;
        }

        sleep(1);

        // Cek apakah password baru dan konfirmasi sama
        if ($this->passwordBaru !== $this->password_confirmation) {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'Konfirmasi Password Tidak Cocok',
                'description' => 'Password baru dan konfirmasi password tidak cocok.'
            ]);
            return;
        }
        // Update password
        $user->password = Hash::make($this->passwordBaru);
        $user->save();

        // Reset form
        $this->passwordLama = '';
        $this->passwordBaru = '';
        $this->password_confirmation = '';

        $this->isLoading = false;

        session()->flash('message', [
            'type' => 'success',
            'title' => 'Password berhasil diubah',
            'description' => 'Password Anda telah diperbarui dan disimpan dengan aman.'
        ]);
    }

    public function updateProfile()
    {
        $this->isLoading = true;

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:15',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'alamat' => 'nullable|string|max:255',
        ]);

        sleep(1);

        $user = User::find(Auth::id());
        if (!$user) {
            session()->flash('message', [
                'type' => 'error',
                'title' => 'User tidak ditemukan',
            ]);
            return;
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->telepon = $this->telepon;
        $user->latitude = $this->latitude;
        $user->longitude = $this->longitude;
        $user->alamat = $this->alamat;
        $user->save();

        $this->isLoading = false;

        session()->flash('message', [
            'type' => 'success',
            'title' => 'Profil Berhasil Diperbarui',
            'description' => 'Data profil Anda telah tersimpan dengan aman'
        ]);
    }

    public function clearMessage()
    {
        session()->forget('message');
    }
}
