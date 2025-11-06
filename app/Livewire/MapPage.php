<?php

namespace App\Livewire;

use App\Models\Anggota;
use App\Models\Jurusan;
use App\Models\Komisariat;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Peta Anggota')]
class MapPage extends Component
{
    public $selectedKomisariat = null;
    public $selectedJurusan = null;
    public int $markerCount = 0;

    public function getKomisariatOptionsProperty()
    {
        return Komisariat::orderBy('nama')->pluck('nama', 'id');
    }

    public function getJurusanOptionsProperty()
    {
        return Jurusan::orderBy('nama_jurusan')->pluck('nama_jurusan', 'id');
    }
    public function triggerRender(): void
    {
        // Tidak perlu melakukan apa-apa di sini.
        // Memanggil method ini saja sudah cukup untuk memicu ulang render().
    }
    public function render()
    {
        $query = Anggota::query()
            ->with(['jurusan', 'komisariat'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        if ($this->selectedKomisariat) {
            $query->where('komisariat_id', $this->selectedKomisariat);
        }

        if ($this->selectedJurusan) {
            $query->where('jurusan_id', $this->selectedJurusan);
        }

        $anggotas = $query->get();
        $this->markerCount = $anggotas->count();

        // 3. Kirim event ke browser dengan data baru setiap kali render
        $this->dispatch('updateMap', data: $anggotas);

        return view('livewire.map-page', [
            'anggotas' => $anggotas,
        ]);
    }
}
