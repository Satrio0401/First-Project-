<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
#[Layout('components.layouts.app')]
#[Title('Galeri')]
class GaleriIndex extends Component
{
    public function render()
    {
        return view('livewire.galeri-index');
    }
}
