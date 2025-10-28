<?php

namespace App\Livewire;

use App\Models\Anggota;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Peta')]
class MapPage extends Component
{
    public function render()
    {
        $kecamatanData = Anggota::selectRaw('alamat as kecamatan, AVG(latitude) as latitude, AVG(longitude) as longitude, COUNT(*) as jumlah')
            ->groupBy('alamat')
            ->get();

        return view('livewire.map-page', [
            'kecamatanData' => $kecamatanData
        ]);
    }
}
