<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;


class DataKepalaLingkungan extends Component
{
    public $users, $name, $alamat, $telepon, $email, $status, $selectedId;
    public $isModalOpen = false;

    public function render()
    {
        $this->users = User::kepalaLingkungan()->get();

        return view('livewire.data-kepala-lingkungan', [
            'users' => $this->users,
        ]);
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->alamat = '';
        $this->telepon = '';
        $this->selectedId = null;
    }
}
