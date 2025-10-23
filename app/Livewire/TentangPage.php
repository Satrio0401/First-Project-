<?php

namespace App\Livewire;

use App\Models\Setting;
use App\Models\SejarahPengurus;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
#[Layout('components.layouts.app')]
#[Title('Tentang Kami')]
class TentangPage extends Component
{
    public function render()
    {
        $settings = Setting::getMultiple(['visi', 'misi', 'sejarah', 'sejarah_kepengurusan']);
        
        $sejarahKepengurusan = SejarahPengurus::orderBy('order_column')->get();

        return view('livewire.tentang-page', [
            'visi' => $settings['visi'] ?? '',
            'misi' => $settings['misi'] ?? '',
            'sejarah' => $settings['sejarah'] ?? '',
            'sejarahKepengurusan' => $sejarahKepengurusan,
        ]);
    }
}
