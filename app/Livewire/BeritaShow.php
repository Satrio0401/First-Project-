<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
#[Layout('components.layouts.app')]

class BeritaShow extends Component
{
    public Berita $berita;
    public $slug;
    #[Title]
    public function title(): string
    {
        return $this->berita->judul ?? 'Berita';
    }
    public function mount($slug)
    {
        $this->slug = $slug;
        $this->berita = Berita::where('slug', $slug)
            ->published()
            ->firstOrFail();
        
        // Increment views
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
        return 'https://api.whatsapp.com/?text=' . $text;
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
        ]);
    }
}
