<?php

namespace App\Providers;
use App\Models\Berita;
use App\Models\Anggota;
use App\Models\Galeri;
use App\Models\Pengurus;
use App\Models\ProgramKerja;
use App\Policies\BeritaPolicy;
use App\Policies\AnggotaPolicy;
use App\Policies\GaleriPolicy;
use App\Policies\PengurusPolicy;
use App\Policies\ProgramKerjaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Anggota::class => AnggotaPolicy::class,
        Berita::class => BeritaPolicy::class,
        Galeri::class => GaleriPolicy::class,
        ProgramKerja::class => ProgramKerjaPolicy::class,
        Pengurus::class => PengurusPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}