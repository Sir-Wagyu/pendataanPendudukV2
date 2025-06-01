<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;


class DataKepalaLingkungan extends Component
{
    public $user, $name, $alamat, $telepon, $email, $status, $username, $nik, $selectedId;
    public $longitude = '';
    public $latitude = '';

    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $isNotificationModal = false;
    public $search = '';

    public function render()
    {

        if ($this->search) {
            return view('livewire.data-kepala-lingkungan', [
                'users' => User::where('role', 'kepalaLingkungan')
                    ->where(function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('nik', 'like', '%' . $this->search . '%')
                            ->orWhere('alamat', 'like', '%' . $this->search . '%')
                            ->orWhere('telepon', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                    ->get(),
            ]);
        }

        if (session()->has('message')) {
            $this->isNotificationModal = true;
        } else {
            $this->isNotificationModal = false;
        }

        return view('livewire.data-kepala-lingkungan', [
            'users' => User::where('role', 'kepalaLingkungan')->get(),
        ]);
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = false;
    }

    public function openDeleteModal($id)
    {
        $this->selectedId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
    }

    public function delete()
    {
        $user = User::find($this->selectedId);
        if ($user) {
            $user->update(['status' => 'nonactive']);
            session()->flash('message', [
                'title' => 'Data kepala lingkungan berhasil dinonaktifkan.',
                'type' => 'success',
                'description' => 'Data user dengan nama ' . $user->name . ' telah dinonaktifkan dari sistem.'
            ]);
        } else {
            session()->flash('message', [
                'title' => 'Data kepala lingkungan tidak ditemukan.',
                'type' => 'error',
                'description' => 'User dengan ID ' . $this->selectedId . ' tidak ditemukan di sistem.'
            ]);
        }

        $this->closeDeleteModal();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->alamat = '';
        $this->telepon = '';
        $this->email = '';
        $this->status = '';
        $this->username = '';
        $this->nik = '';
        $this->selectedId = null;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:40',
            'nik' => 'required|string|min:16|max:16|unique:users,nik,' . $this->selectedId,
            'alamat' => 'required|string|max:50',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . $this->selectedId,
            'username' => 'required|string|max:20|unique:users,username,' . $this->selectedId,
        ]);


        if ($this->selectedId) {
            $user = User::find($this->selectedId);
            $user->update([
                'name' => $this->name,
                'nik' => $this->nik,
                'alamat' => $this->alamat,
                'telepon' => $this->telepon,
                'email' => $this->email,
                'username' => $this->username,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);
        } else {
            User::create([
                'name' => $this->name,
                'nik' => $this->nik,
                'alamat' => $this->alamat,
                'telepon' => $this->telepon,
                'email' => $this->email,
                'username' => $this->username,
                'status' => 'pending',
                'role' => 'kepalaLingkungan',
                'password' => bcrypt('password'),
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);
        }

        session()->flash('message', [
            'title' => $this->selectedId ? 'Data berhasil diupdate.' : 'Data berhasil ditambahkan.',
            'type' => 'success',
            'description' => $this->selectedId ? 'Data Kepala Lingkungan dengan nama ' . $this->name . ' telah diupdate.' : 'Data Kepala Lingkungan dengan nama ' . $this->name . ' telah ditambahkan.'
        ]);

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::find($id);
        $this->selectedId = $id;
        $this->name = $user->name;
        $this->alamat = $user->alamat;
        $this->telepon = $user->telepon;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->nik = $user->nik;
        $this->latitude = $user->latitude;
        $this->longitude = $user->longitude;
        $this->openModal();
    }

    public function searchKapling()
    {
        $this->users = User::where('role', 'kepalaLingkungan')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat', 'like', '%' . $this->search . '%')
                    ->orWhere('telepon', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->get();
    }
}
