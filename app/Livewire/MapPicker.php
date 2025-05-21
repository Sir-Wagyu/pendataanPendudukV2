<?php

namespace App\Livewire;

use Livewire\Component;

class MapPicker extends Component
{
    protected $listeners = ['setMapLocation'];
    public $latitude = '';
    public $longitude = '';
    public function render()
    {
        return view('livewire.map-picker');
    }
}
