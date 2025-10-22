<?php

namespace App\Livewire;

use App\Models\ProgramKerja;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
#[Layout('components.layouts.app')]
#[Title('Program Kerja')]
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
        ]);
    }
}
