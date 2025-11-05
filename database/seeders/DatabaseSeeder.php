<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Jurusan;
use App\Models\Komisariat;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // === Komisariat ===
        $komisariatFT = Komisariat::firstOrCreate(['nama' => 'Komisariat Teknik UNTAN']);
        $komisariatFISIP = Komisariat::firstOrCreate(['nama' => 'Komisariat FISIP UNTAN']);
        $jurusanTeknikArsitektur = Jurusan::create(['nama_jurusan' => 'Teknik Arsitektur']);
        $jurusanTeknikKimia = Jurusan::create(['nama_jurusan' => 'Teknik Kimia']);
        $jurusanTeknikIndustri = Jurusan::create(['nama_jurusan' => 'Teknik Industri']);

        // === Roles ===
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin Komisariat']);
        $userRole = Role::firstOrCreate(['name' => 'Anggota']);
        $superAdminAnggota = Anggota::create([
            'nama' => 'Super Admin',
            'kelamin' => 'Laki-laki',
            'tahun_lk1' => null,
        ]);
        // === Super Admin (tanpa anggota) ===
        $superAdmin = User::create([
            'email' => 'admin@organization.com',
            'password' => bcrypt('password'),
            'anggota_id' => $superAdminAnggota->id,
        ]);
        $superAdmin->assignRole($superAdminRole);

        // === Buat beberapa anggota terlebih dahulu ===
        $anggota1 = Anggota::create([
            'nama' => 'Dona Agnessia',
            'kelamin' => 'Perempuan',
            'tempat_lahir' => 'Tekarang',
            'tanggal_lahir'=>'2006-4-1',
            'alamat' => 'Desa Tekarang, Kabupaten Sambas',
            'no_wa'=>'085754400764',
            'tahun_masuk_kuliah' => '2024',
            'jurusan_id' => $jurusanTeknikArsitektur->id,
            'tahun_lk1' => '2024',
            'komisariat_id' => $komisariatFT->id,
            'latitude' => -0.0512,
            'longitude' => 109.3479,
        ]);

        $anggota2 = Anggota::create([
            'nama' => 'Andi nurinayah',
            'kelamin' => 'Perempuan',
            'tempat_lahir' => 'Makassar',
            'tanggal_lahir'=>'2006-10-3',
            'alamat' => 'Tanjung Raya',
            'no_wa'=>'081523905320',
            'tahun_masuk_kuliah' => '2024',
            'jurusan_id' => $jurusanTeknikKimia->id,
            'tahun_lk1' => '2024',
            'komisariat_id' => $komisariatFT->id,
            'latitude' => -0.0255,
            'longitude' => 109.3398,
        ]);

        $anggota3 = Anggota::create([
            'nama' => 'Raihan Ramdhan Pratama',
            'kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Pontianak',
            'tanggal_lahir'=>'2005-10-5',
            'alamat' => 'Jl. Wonobaru Gang Wonodadi 3 jalur D',
            'no_wa'=>'0881010948498',
            'tahun_masuk_kuliah' => '2024',
            'jurusan_id' => $jurusanTeknikKimia->id,
            'tahun_lk1' => '2024',
            'komisariat_id' => $komisariatFT->id,
            'latitude' => -0.0255,
            'longitude' => 109.3398,
        ]);

        // === Admin untuk Komisariat ===
        $adminTeknikAnggota = Anggota::create([
            'nama' => 'Admin Teknik',
            'kelamin' => 'Laki-laki',
            'komisariat_id' => $komisariatFT->id,
            'tahun_lk1' => null,
        ]);

        $adminFisipAnggota = Anggota::create([
            'nama' => 'Admin FISIP',
            'kelamin' => 'Laki-laki',
            'komisariat_id' => $komisariatFISIP->id,
            'tahun_lk1' => null,
        ]);

        // === Buat user dan hubungkan ke anggota ===
        $adminTeknik = User::create([
            'email' => 'admin.teknik@hmi.com',
            'password' => bcrypt('password'),
            'anggota_id' => $adminTeknikAnggota->id,
        ]);
        $adminTeknik->assignRole($adminRole);

        $adminFisip = User::create([
            'email' => 'admin.fisip@hmi.com',
            'password' => bcrypt('password'),
            'anggota_id' => $adminFisipAnggota->id,
        ]);
        $adminFisip->assignRole($adminRole);

        // === Buat user biasa dari anggota ===
        $user1 = User::create([
            'email' => 'anggota1@hmi.com',
            'password' => bcrypt('password'),
            'anggota_id' => $anggota1->id,
        ]);
        $user1->assignRole($userRole);

        $user2 = User::create([
            'email' => 'anggota2@hmi.com',
            'password' => bcrypt('password'),
            'anggota_id' => $anggota2->id,
        ]);
        $user2->assignRole($userRole);

        $user3 = User::create([
            'email' => 'anggota3@hmi.com',
            'password' => bcrypt('password'),
            'anggota_id' => $anggota3->id,
        ]);
        $user3->assignRole($userRole);
        foreach (range(2018, 2024) as $tahun) {
            // Buat jumlah anggota random antara 20 sampai 50 untuk tahun ini
            $jumlahAnggota = rand(20, 50);

            Anggota::factory()
                ->count($jumlahAnggota)
                ->create([
                    // Atur tahun_lk1 dan tahun_masuk_kuliah sesuai dengan tahun loop saat ini
                    'tahun_lk1' => $tahun,
                    'tahun_masuk_kuliah' => $tahun,
                ]);
        }
        // === Jalankan seeder tambahan jika ada ===
        $this->call([
            OrganizationSeeder::class,
        ]);
    }
}

