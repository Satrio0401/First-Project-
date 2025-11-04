<?php

namespace App\Filament\Widgets;

use App\Models\Anggota;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class KomisariatChart extends ChartWidget
{
    protected ?string $heading = 'Komisariat Chart';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Anggota::select(DB::raw('count(*) as total'), 'tahun_lk1')
            ->whereNotNull('tahun_lk1')
            ->where('tahun_lk1', '!=', '') 
            ->groupBy('tahun_lk1')
            ->orderBy('tahun_lk1', 'asc') 
            ->get();
        $labels = $data->pluck('tahun_lk1');
        $values = $data->pluck('total');
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Anggota',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
