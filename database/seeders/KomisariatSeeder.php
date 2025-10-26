<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Komisariat;

class KomisariatSeeder extends Seeder
{
    public function run(): void
    {
        $komisariats = [
            'Pontianak Selatan',
            'Pontianak Barat',
            'Pontianak Kota',
            'Pontianak Timur',
            'Pontianak Utara',
        ];

        foreach ($komisariats as $nama) {
            Komisariat::updateOrCreate(['nama' => $nama]);
        }
    }
}
