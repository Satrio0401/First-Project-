<?php

namespace Database\Factories;

use App\Models\Jurusan;
use App\Models\Komisariat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil ID yang ada dari database agar relasinya valid
        $jurusanIds = Jurusan::pluck('id')->toArray();
        $komisariatIds = Komisariat::pluck('id')->toArray();

        return [
            'nama' => $this->faker->name(),
            'foto' => null, // Biarkan kosong untuk seeder
            'alamat' => $this->faker->address(),
            'kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->dateTimeBetween('2000-01-01', '2006-12-31')->format('Y-m-d'),
            'no_wa' => $this->faker->phoneNumber(),
            // tahun_masuk_kuliah dan tahun_lk1 akan kita atur di seeder
            'jurusan_id' => $this->faker->randomElement($jurusanIds),
            'komisariat_id' => $this->faker->randomElement($komisariatIds),
            'tahun_lk2' => null,
            'cabang_lk2' => null,
            'tahun_lk3' => null,
            'badko_lk3' => null,
            'tahun_lkk' => null,
            'cabang_lkk' => null,
            'prestasi' => null,
            'latitude' => $this->faker->latitude(-0.1, 0.1),
            'longitude' => $this->faker->longitude(109.2, 109.4),
        ];
    }
}