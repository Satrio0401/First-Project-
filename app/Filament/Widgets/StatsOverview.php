<?php

namespace App\Filament\Widgets;

use App\Models\Berita;
use App\Models\GaleriImage;
use App\Models\Pengurus;
use App\Models\ProgramKerja;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Berita', Berita::count())
                ->description('Semua artikel dan pengumuman')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),

            Stat::make('Pengurus Aktif', Pengurus::where('is_active', true)->count())
                ->description('Jumlah anggota tim yang aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Total Foto Galeri', GaleriImage::count())
                ->description('Semua foto dari semua album')
                ->descriptionIcon('heroicon-m-photo')
                ->color('warning'),

            Stat::make('Program Kerja Aktif', ProgramKerja::where('status', 'Aktif')->count())
                ->description('Program kerja yang sedang berjalan')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('primary'),
        ];
    }
    public static function canView(): bool
    {
        // Periksa apakah user yang login punya role 'Super Admin'
        return auth()->user()->hasRole('Super Admin');
    }
}
