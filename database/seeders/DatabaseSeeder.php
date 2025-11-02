<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Anggota;
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

        // === Roles ===
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin Komisariat']);
        $userRole = Role::firstOrCreate(['name' => 'Anggota']);

        // === Super Admin (tanpa anggota) ===
        $superAdmin = User::create([
            'email' => 'admin@organization.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        // === Buat beberapa anggota terlebih dahulu ===
        $anggota1 = Anggota::create([
            'nama' => 'Budi Santoso',
            'alamat' => 'Pontianak Selatan',
            'kelamin' => 'Laki-laki',
            'komisariat_id' => $komisariatFISIP->id,
            'latitude' => -0.0512,
            'longitude' => 109.3479,
        ]);

        $anggota2 = Anggota::create([
            'nama' => 'Siti Aminah',
            'alamat' => 'Pontianak Kota',
            'kelamin' => 'Perempuan',
            'komisariat_id' => $komisariatFISIP->id,
            'latitude' => -0.0255,
            'longitude' => 109.3398,
        ]);

        $anggota3 = Anggota::create([
            'nama' => 'Rahmat Hidayat',
            'alamat' => 'Pontianak Timur',
            'kelamin' => 'Laki-laki',
            'komisariat_id' => $komisariatFISIP->id,
            'latitude' => -0.0050,
            'longitude' => 109.3600,
        ]);

        // === Admin untuk Komisariat ===
        $adminTeknikAnggota = Anggota::create([
            'nama' => 'Admin Teknik',
            'alamat' => 'Pontianak',
            'kelamin' => 'Laki-laki',
        ]);

        $adminFisipAnggota = Anggota::create([
            'nama' => 'Admin FISIP',
            'alamat' => 'Pontianak',
            'kelamin' => 'Laki-laki',
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

        // === Jalankan seeder tambahan jika ada ===
        $this->call([
            OrganizationSeeder::class,
        ]);
    }
}

