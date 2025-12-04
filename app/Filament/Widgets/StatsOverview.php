<?php

namespace App\Filament\Widgets;

use App\Models\Anggota;
use App\Models\Berita;
use App\Models\GaleriImage;
use App\Models\Pengurus;
use App\Models\ProgramKerja;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Anggota', Anggota::count())
                ->description('Jumlah seluruh anggota terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Anggota Baru Bulan Ini', Anggota::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count())
                ->description('Pendaftaran bulan ' . now()->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Berita', Berita::count())
                ->description('Semua artikel dan pengumuman')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('info'),

            Stat::make('Pengurus Aktif', Pengurus::where('is_active', true)->count())
                ->description('Jumlah anggota tim yang aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),

            Stat::make('Total Foto Galeri', GaleriImage::count())
                ->description('Semua foto dari semua album')
                ->descriptionIcon('heroicon-m-photo')
                ->color('gray'),

            Stat::make('Program Kerja Aktif', ProgramKerja::where('status', 'Aktif')->count())
                ->description('Program kerja yang sedang berjalan')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('danger'),
        ];
    }
    public static function canView(): bool
    {
        /** @var User|null $user */
        $user = auth()->user();
        return $user?->hasRole('Super Admin') ?? false;
    }
}
