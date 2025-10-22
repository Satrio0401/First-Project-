<?php

namespace App\Livewire;

use App\Models\Setting;
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
        
        $sejarahKepengurusan = [];
        if (!empty($settings['sejarah_kepengurusan'])) {
            $sejarahKepengurusan = json_decode($settings['sejarah_kepengurusan'], true) ?? [];
        }

        return view('livewire.tentang-page', [
            'visi' => $settings['visi'] ?? '',
            'misi' => $settings['misi'] ?? '',
            'sejarah' => $settings['sejarah'] ?? '',
            'sejarahKepengurusan' => $sejarahKepengurusan,
        ]);
    }
}
