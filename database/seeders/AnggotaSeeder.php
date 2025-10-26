<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;
use App\Models\Komisariat;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        // Buat komisariat (alamat = kecamatan)
        $k1 = Komisariat::firstOrCreate(['nama' => 'Pontianak Selatan']);
        $k2 = Komisariat::firstOrCreate(['nama' => 'Pontianak Kota']);
        $k3 = Komisariat::firstOrCreate(['nama' => 'Pontianak Timur']);

        // Buat anggota
        Anggota::create([
            'nama' => 'Budi Santoso',
            'komisariat_id' => $k1->id,
            'alamat' => 'Pontianak Selatan',
            'latitude' => -0.0512,
            'longitude' => 109.3479,
            'foto' => null
        ]);

        Anggota::create([
            'nama' => 'Siti Aminah',
            'komisariat_id' => $k2->id,
            'alamat' => 'Pontianak Kota',
            'latitude' => -0.0255,
            'longitude' => 109.3398,
            'foto' => null
        ]);

        Anggota::create([
            'nama' => 'Rahmat Hidayat',
            'komisariat_id' => $k3->id,
            'alamat' => 'Pontianak Timur',
            'latitude' => -0.0050,
            'longitude' => 109.3600,
            'foto' => null
        ]);
    }
}
