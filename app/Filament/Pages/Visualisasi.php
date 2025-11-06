<?php

namespace App\Filament\Pages;

use App\Models\Anggota;
use App\Models\Jurusan;
use App\Models\Komisariat;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Schemas\Schema;
use Livewire\Attributes\On;

class Visualisasi extends Page implements HasInfolists
{
    use InteractsWithInfolists;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Map;
    protected string $view = 'filament.pages.visualisasi';
    protected int | string | array $columnSpan = 'full';
    protected static bool $isLazy = false;

    public ?Anggota $selectedAnggota = null;
    public bool $showAnggotaFilters = false;

    public $selectedJurusan = null;
    public $selectedKomisariat = null;
    public int $markerCount = 0;
    public function getJurusanOptionsProperty()
    {
        return Jurusan::pluck('nama_jurusan', 'id');
    }
    public function getKomisariatOptionsProperty()
    {
        return Komisariat::pluck('nama', 'id');
    }
    public function getKomisariatsData(): array
    {
        return Komisariat::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['nama', 'latitude', 'longitude'])
            ->toArray();
        
    }
    public function getAnggotasData(): array
    {
        $query = Anggota::query()->whereNotNull('latitude')
            ->whereNotNull('longitude');
        if ($this->selectedJurusan) {
            $query->where('jurusan_id', $this->selectedJurusan);
        }
        if ($this->selectedKomisariat) {
            $query->where('komisariat_id', $this->selectedKomisariat);
        }

        return $query->get(['id', 'nama', 'latitude', 'longitude'])->toArray();
    }
    public function updated($property): void
    {
        if($property === 'selectedJurusan' || $property === 'selectedKomisariat'){
            $anggotaData = $this->getAnggotasData();
            $this->markerCount = count($anggotaData);
            $this->dispatch('redrawAnggotaMarkers', data: $this->getAnggotasData());
        }
    }
    #[On('showAnggotaDetails')]
    public function showAnggotaDetails(int $anggotaId): void
    {
        $this->selectedAnggota = Anggota::find($anggotaId);
    }

    #[On('hideInfolist')]
    public function hideDetails(): void
    {
        $this->selectedAnggota = null;
    }
    public function showAnggotaView(): void
    {
        $this->showAnggotaFilters = true;
        $anggotaData = $this->getAnggotasData();
        $this->markerCount = count($anggotaData);
        $this->dispatch('drawAnggotaMarkers', data: $this->getAnggotasData());
    }

    public function showKomisariatView(): void
    {
        $this->showAnggotaFilters = false;
        $this->hideDetails();
        $komisariatData = $this->getKomisariatsData();
        $this->markerCount = count($komisariatData);
        $this->dispatch('drawKomisariatMarkers', data: $this->getKomisariatsData());
    }

    public function infolist(Schema $schema): Schema
    {
        if (!$this->selectedAnggota) {
            return $schema;
        }

        return $schema
            ->record($this->selectedAnggota)
            ->columns(2)
            ->components([
                ImageEntry::make('foto')->square()
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                TextEntry::make('nama')->label('Nama'),
                TextEntry::make('kelamin')->label('Kelamin'),
                TextEntry::make('no_wa')->label('No. WA'),
                TextEntry::make('tempat_lahir')->label('Tempat Lahir'),
                TextEntry::make('tanggal_lahir')->label('Tanggal Lahir')->date('d F Y'),
                TextEntry::make('alamat')->label('Alamat'),
                TextEntry::make('jurusan.nama_jurusan')->label('Jurusan'),
                TextEntry::make('komisariat.nama')->label('Komisariat LK1'),
                TextEntry::make('tahun_lk1')->label('Tahun LK1'),
                TextEntry::make('cabang_lk2')->label('Cabang LK2'),
                TextEntry::make('tahun_lk2')->label('Tahun LK2'),
                TextEntry::make('badko_lk3')->label('Badko LK3'),
                TextEntry::make('tahun_lk3')->label('Tahun LK3'),
                TextEntry::make('tahun_lkk')->label('Tahun LKK')->visible(fn($record) => $record?->kelamin === 'Perempuan'),
                TextEntry::make('cabang_lkk')->label('Cabang LKK')->visible(fn($record) => $record?->kelamin === 'Perempuan'),
                TextEntry::make('tahun_masuk_kuliah')->label('Tahun Masuk Kuliah'),
                TextEntry::make('latitude')->label('Latitude'),
                TextEntry::make('longitude')->label('Longitude'),
            ]);
    }
}
