<?php
// filepath: app/Http/Controllers/MapController.php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Jurusan;
use App\Models\Komisariat;
use Illuminate\Http\Request;

class MapPageController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data yang diperlukan sekali saja
        $anggotas = Anggota::query()
            ->with(['jurusan', 'komisariat']) // Eager load relasi
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $komisariatOptions = Komisariat::orderBy('nama')->pluck('nama', 'id');
        $jurusanOptions = Jurusan::orderBy('nama_jurusan')->pluck('nama_jurusan', 'id');

        // 2. Kirim semua data ke view
        return view('map-page', [
            'anggotas' => $anggotas,
            'komisariatOptions' => $komisariatOptions,
            'jurusanOptions' => $jurusanOptions,
        ]);
    }
}