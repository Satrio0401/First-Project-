<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class BeritaIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'kategori')]
    public $kategoriFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingKategoriFilter()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->kategoriFilter = '';
        $this->resetPage();
    }
    
    public function render()
    {
        $query = Berita::published()->latest('published_at');

        if ($this->search) {
            $query->search($this->search);
        }

        if ($this->kategoriFilter) {
            $query->kategori($this->kategoriFilter);
        }

        $berita = $query->paginate(9);

        return view('livewire.berita-index', [
            'berita' => $berita,
        ])->layout('components.layouts.app', ['title' => 'Berita']);
    }
}
