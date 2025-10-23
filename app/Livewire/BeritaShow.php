<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.app')]
class BeritaShow extends Component
{
    public Berita $berita;

    public function mount($slug)
    {
        $this->berita = Berita::where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        $this->berita->incrementViews();
    }

    public function getShareUrlProperty()
    {
        return route('berita.show', $this->berita->slug);
    }

    public function getFacebookShareProperty()
    {
        return 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($this->shareUrl);
    }

    public function getTwitterShareProperty()
    {
        $text = urlencode($this->berita->judul);
        return 'https://twitter.com/intent/tweet?url=' . urlencode($this->shareUrl) . '&text=' . $text;
    }

    public function getWhatsappShareProperty()
    {
        $text = urlencode($this->berita->judul . ' - ' . $this->shareUrl);
        // Perbaikan kecil: gunakan api.whatsapp.com untuk kompatibilitas mobile
        return 'https://api.whatsapp.com/send?text=' . $text;
    }

    public function render()
    {
        $relatedBerita = Berita::published()
            ->where('kategori', $this->berita->kategori)
            ->where('id', '!=', $this->berita->id)
            ->latest('published_at')
            ->take(3)
            ->get();
        
        return view('livewire.berita-show', [
            'relatedBerita' => $relatedBerita,
        ])->title($this->berita->judul);
    }
}
