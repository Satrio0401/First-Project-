<?php

namespace App\Livewire;

use App\Models\Pengurus;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
#[Layout('components.layouts.app')]
#[Title('Struktur Pengurus')]
class PengurusPage extends Component
{
    public function render()
    {
        $pengurusInti = Pengurus::active()
            ->pengurusInti()
            ->ordered()
            ->get();

        $divisi = Pengurus::active()
            ->divisi()
            ->ordered()
            ->get();

        return view('livewire.pengurus-page', [
            'pengurusInti' => $pengurusInti,
            'divisi' => $divisi,
        ]);
    }
}
