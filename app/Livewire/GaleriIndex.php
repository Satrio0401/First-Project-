<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;

class GaleriIndex extends Component
{
    public function render()
    {
        return view('livewire.galeri-index')->layout('components.layouts.app', ['title' => 'Galeri']);
    }
}
