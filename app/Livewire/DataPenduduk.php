<?php

namespace App\Livewire;

use Livewire\Component;

class DataPenduduk extends Component
{
    public $table = 'warga';

    public function setTable($tableName)
    {
        $this->table = $tableName;
    }

    public function render()
    {
        return view('livewire.data-penduduk');
    }
}
