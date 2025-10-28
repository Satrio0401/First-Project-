<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Komisariat;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $komisariatFT = Komisariat::firstOrCreate(['nama' => 'Komisariat Teknik UNTAN']);
        $komisariatFISIP = Komisariat::firstOrCreate(['nama' => 'Komisariat FISIP UNTAN']);

        
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $adminRole = Role::create(['name' => 'Admin Komisariat']);
        $userRole = Role::create(['name' => 'Anggota']);

        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@organization.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole($superAdminRole);
        $adminTeknik = User::factory()->create([
            'name' => 'Admin Teknik',
            'email' => 'admin.teknik@hmi.com',
            'password' => bcrypt('password'),
            'komisariat_id' => $komisariatFT->id,
        ]);
        $adminTeknik->assignRole($adminRole);

        // Buat Admin untuk Komisariat FISIP
        $adminFisip = User::factory()->create([
            'name' => 'Admin FISIP',
            'email' => 'admin.fisip@hmi.com',
            'password' => bcrypt('password'),
            'komisariat_id' => $komisariatFISIP->id,
        ]);
        $adminFisip->assignRole($adminRole);
        $anggota1 = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'anggota1@hmi.com',
            'password' => bcrypt('password'),
            'komisariat_id' => $komisariatFISIP->id,
        ]);
        $anggota1->assignRole($userRole);
        $anggota2 = User::factory()->create([
            'name' => 'Siti Aminah',
            'email' => 'anggota2@hmi.com',
            'password' => bcrypt('password'),
            'komisariat_id' => $komisariatFISIP->id,
        ]);
        $anggota2->assignRole($userRole);
        $anggota3 = User::factory()->create([
            'name' => 'Rahmat Hidayat',
            'email' => 'anggota3@hmi.com',
            'password' => bcrypt('password'),
            'komisariat_id' => $komisariatFT->id,
        ]);
        $anggota3->assignRole($userRole);
        
        Anggota::create([
            'user_id' => $anggota1->id,
            'alamat' => 'Pontianak Selatan',
            'latitude' => -0.0512,
            'longitude' => 109.3479,
            'foto' => null
        ]);

        Anggota::create([
            'user_id' => $anggota2->id,
            'alamat' => 'Pontianak Kota',
            'latitude' => -0.0255,
            'longitude' => 109.3398,
            'foto' => null
        ]);

        Anggota::create([
            'user_id' => $anggota3->id,
            'alamat' => 'Pontianak Timur',
            'latitude' => -0.0050,
            'longitude' => 109.3600,
            'foto' => null
        ]);
        // Seed organization data
        $this->call([
            OrganizationSeeder::class,
        ]);
    }
}
