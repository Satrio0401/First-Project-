<?php

namespace App\Filament\Widgets;

use App\Models\Komisariat;
use Filament\Widgets\Widget;

class KomisariatMapWidget extends Widget
{
    protected string $view = 'filament.widgets.komisariat-map-widget';
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
