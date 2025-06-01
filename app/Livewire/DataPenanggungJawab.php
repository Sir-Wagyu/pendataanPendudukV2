<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class DataPenanggungJawab extends Component
{
    public $user, $name, $email, $paassword, $alamat, $telepon, $role, $status, $nik, $username, $selectedId;
    public $longitude = '';
    public $latitude = '';


    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $isNotificationModal = false;
    public $search = '';


    public function render()
    {

        if ($this->search) {
            return view('livewire.data-penanggung-jawab', [
                'users' => User::where('role', 'penanggungJawab')
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

        return view('livewire.data-penanggung-jawab', [
            'users' => User::where('role', 'penanggungJawab')->get(),
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
                'title' => 'Data Penanggung Jawab berhasil dinonaktifkan.',
                'type' => 'success',
                'description' => 'Data user dengan nama ' . $user->name . ' telah dinonaktifkan dari sistem.'
            ]);
        } else {
            session()->flash('message', [
                'title' => 'Data Penanggung Jawab tidak ditemukan.',
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
        $this->longitude = '';
        $this->latitude = '';
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:40',
            'nik' => 'required|string|max:20|unique:users,nik,' . $this->selectedId,
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
                'role' => 'penanggungJawab',
                'password' => bcrypt('password'),
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);
        }

        session()->flash('message', [
            'title' => $this->selectedId ? 'Data berhasil diupdate.' : 'Data berhasil ditambahkan.',
            'type' => 'success',
            'description' => $this->selectedId ? 'Data penanggung jawab dengan nama ' . $this->name . ' telah diupdate.' : 'Data penanggung jawab dengan nama ' . $this->name . ' telah ditambahkan.'
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
}
