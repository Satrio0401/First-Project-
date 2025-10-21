<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Component;

class BeritaShow extends Component
{
    public $slug;
    public $berita;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->berita = Berita::where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        // Increment views
        $this->berita->incrementViews();
    }

    public function render()
    {
        // Get related news
        $relatedBerita = Berita::published()
            ->where('kategori', $this->berita->kategori)
            ->where('id', '!=', $this->berita->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('livewire.berita-show', [
            'relatedBerita' => $relatedBerita,
        ])->layout('components.layouts.app', ['title' => $this->berita->judul]);
    }
}
