<?php

namespace App\Livewire;

use App\Models\Berita;
use App\Models\ProgramKerja;
use App\Models\Setting;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        // Pengumuman
        $pengumuman = Berita::published()
            ->where('kategori', 'Pengumuman')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Artikel
        $artikel = Berita::published()
            ->where('kategori', 'Artikel')
            ->latest('published_at')
            ->take(3)
            ->get();

        $programKerjaAktif = ProgramKerja::aktif()
            ->latest()
            ->take(3)
            ->get();

        $visi = Setting::get('visi');
        $misi = Setting::get('misi');

        return view('livewire.home-page', [
            'pengumuman' => $pengumuman,
            'artikel' => $artikel,
            'programKerjaAktif' => $programKerjaAktif,
            'visi' => $visi,
            'misi' => $misi,
        ])->layout('components.layouts.app', ['title' => 'Beranda']);
    }
}
