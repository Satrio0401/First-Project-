<?php

namespace App\Livewire;

use App\Models\ProgramKerja;
use Livewire\Component;

class ProgramKerjaPage extends Component
{
    public function render()
    {
        $programAktif = ProgramKerja::aktif()
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        $programSelesai = ProgramKerja::selesai()
            ->orderBy('tanggal_selesai', 'desc')
            ->get();

        return view('livewire.program-kerja-page', [
            'programAktif' => $programAktif,
            'programSelesai' => $programSelesai,
        ])->layout('components.layouts.app', ['title' => 'Program Kerja']);
    }
}
