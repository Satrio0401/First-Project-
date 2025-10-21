<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\TentangPage;
use App\Livewire\PengurusPage;
use App\Livewire\BeritaIndex;
use App\Livewire\BeritaShow;
use App\Livewire\ProgramKerjaPage;

// Public Routes
Route::get('/', HomePage::class)->name('home');
Route::get('/tentang', TentangPage::class)->name('tentang');
Route::get('/pengurus', PengurusPage::class)->name('pengurus');
Route::get('/berita', BeritaIndex::class)->name('berita.index');
Route::get('/berita/{slug}', BeritaShow::class)->name('berita.show');
Route::get('/program-kerja', ProgramKerjaPage::class)->name('program-kerja');
