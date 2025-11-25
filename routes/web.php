<?php

use App\Http\Controllers\MapPageController;
use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\TentangPage;
use App\Livewire\PengurusPage;
use App\Livewire\BeritaIndex;
use App\Livewire\BeritaShow;
use App\Livewire\GaleriIndex;
use App\Livewire\ProgramKerjaPage;
use App\Livewire\MapPage;

// Public Routes
Route::get('/', HomePage::class)->name('home');
Route::get('/tentang', TentangPage::class)->name('tentang');
Route::get('/pengurus', PengurusPage::class)->name('pengurus');
Route::get('/berita', BeritaIndex::class)->name('berita.index');
Route::get('/galeri', GaleriIndex::class)->name('galeri.index');
Route::get('/berita/{slug}', BeritaShow::class)->name('berita.show');
Route::get('/program-kerja', ProgramKerjaPage::class)->name('program-kerja');
// Route::get('/map', MapPage::class)->name('map');
Route::get('/map', [MapPageController::class, 'index'])->name('map');
// Route A: Tes Framework Murni (Tanpa DB)
Route::get('/tes-framework', function () {
    $durasi = (microtime(true) - LARAVEL_START) * 1000;
    return 'Laravel Booting Time: ' . $durasi . ' ms';
});

// Route B: Tes Koneksi DB via Laravel
Route::get('/tes-db', function () {
    $start = microtime(true);
    try {
        \DB::connection()->getPdo();
        $status = "Sukses Konek!";
    } catch (\Exception $e) {
        $status = "Gagal: " . $e->getMessage();
    }
    return $status . " | Durasi: " . ((microtime(true) - $start) * 1000) . " ms";
});