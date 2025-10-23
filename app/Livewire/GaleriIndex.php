<?php

namespace App\Livewire;

use Livewire\WithPagination;
use App\Models\Galeri;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Galeri')]
class GaleriIndex extends Component
{
    use WithPagination;

    // Properti untuk mengelola state modal
    public bool $isModalOpen = false;
    public ?Galeri $activeAlbum = null;
    public int $currentImageIndex = 0;

    #[Url(as: 'q')]
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->resetPage();
    }

    // Method untuk membuka modal
    public function openModal($albumId)
    {
        // Ambil album beserta semua gambarnya
        $this->activeAlbum = Galeri::with('images')->find($albumId);
        $this->currentImageIndex = 0;
        $this->isModalOpen = true;
    }

    // Method untuk menutup modal
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->activeAlbum = null; // Reset album aktif
    }

    // Method untuk ke gambar berikutnya
    public function nextImage()
    {
        if ($this->activeAlbum && $this->activeAlbum->images->count() > 0) {
            $this->currentImageIndex = ($this->currentImageIndex + 1) % $this->activeAlbum->images->count();
        }
    }

    // Method untuk ke gambar sebelumnya
    public function prevImage()
    {
        if ($this->activeAlbum && $this->activeAlbum->images->count() > 0) {
            $this->currentImageIndex = ($this->currentImageIndex - 1 + $this->activeAlbum->images->count()) % $this->activeAlbum->images->count();
        }
    }

    public function render()
    {
        $query = Galeri::with('firstImage')
            ->has('firstImage')
            ->latest();
    
        if ($this->search) {
            $query->search($this->search);
        }
    
        $galeris = $query->paginate(9);
    
        return view('livewire.galeri-index', [
            'galeris' => $galeris,
        ]);
    }
    
}
