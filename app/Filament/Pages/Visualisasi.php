<?php

namespace App\Filament\Pages;

use App\Models\Komisariat;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class Visualisasi extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Map;
    protected string $view = 'filament.pages.visualisasi';
    protected int | string | array $columnSpan = 'full';
    protected static bool $isLazy = false;
    public function getKomisariatsData(): string
    {
        $komisariats = Komisariat::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['nama', 'latitude', 'longitude']);

        return json_encode($komisariats);
    }
}
