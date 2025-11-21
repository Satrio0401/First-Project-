<?php

namespace App\Filament\Pages;

use App\Models\Anggota;
use App\Models\Jurusan;
use App\Models\Komisariat;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class visualisasi extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Map;
    protected string $view = 'filament.pages.visualisasi';
    protected static bool $isLazy = false;

    // Kita kirim data mentah ke view, tidak perlu property livewire yang reaktif
    public $anggotaJson;
    public $komisariatJson;
    public $jurusanOptions;
    public $komisariatOptions;

    public function mount()
    {
        // 1. Siapkan Option untuk Select Filter
        $this->jurusanOptions = Jurusan::pluck('nama_jurusan', 'id');
        $this->komisariatOptions = Komisariat::pluck('nama', 'id');

        // 2. Ambil Data Komisariat
        $this->komisariatJson = Komisariat::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'nama', 'latitude', 'longitude'])
            ->toArray();

        // 3. Ambil SEMUA Data Anggota beserta relasinya
        // Kita perlu select semua field yang mau ditampilkan di Detail
        $anggotas = Anggota::with(['jurusan', 'komisariat'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // Format data agar mudah dikonsumsi JS (terutama URL gambar dan Tanggal)
        $this->anggotaJson = $anggotas->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'latitude' => $item->latitude,
                'longitude' => $item->longitude,
                'jurusan_id' => $item->jurusan_id,
                'komisariat_id' => $item->komisariat_id,
                'foto_url' => $item->foto ? Storage::url($item->foto) : url('/images/default-avatar.png'),
                'kelamin' => $item->kelamin,
                'no_wa' => $item->no_wa,
                'tempat_lahir' => $item->tempat_lahir,
                'tanggal_lahir' => $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d F Y') : '-',
                'alamat' => $item->alamat,
                'jurusan_nama' => $item->jurusan?->nama_jurusan ?? '-',
                'komisariat_nama' => $item->komisariat?->nama ?? '-',
                'tahun_lk1' => $item->tahun_lk1,
                'tahun_masuk_kuliah' => $item->tahun_masuk_kuliah,
                'tahun_lk2' => $item->tahun_lk2,
                'cabang_lk2' => $item->cabang_lk2,
                'tahun_lk3' => $item->tahun_lk3,
                'badko_lk3' => $item->badko_lk3,
                'tahun_lkk' => $item->tahun_lkk,
                'cabang_lkk' => $item->cabang_lkk,
                'prestasi' => $item->prestasi,
            ];
        })->toArray();
    }
}