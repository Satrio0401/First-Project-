<?php

namespace App\Livewire;

use App\Models\Pengurus;
use Livewire\Component;

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
        ])->layout('components.layouts.app', ['title' => 'Struktur Pengurus']);
    }
}
