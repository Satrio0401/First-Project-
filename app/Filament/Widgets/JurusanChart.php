<?php

namespace App\Filament\Widgets;

use App\Models\Anggota;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class JurusanChart extends ChartWidget
{
    protected ?string $heading = 'Jumlah Anggota per Jurusan';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        // Query untuk menghitung jumlah anggota per jurusan
        $data = Anggota::query()
            ->join('jurusans', 'anggotas.jurusan_id', '=', 'jurusans.id')
            ->select(DB::raw('count(*) as total'), 'jurusans.nama_jurusan')
            ->whereNotNull('anggotas.jurusan_id')
            ->groupBy('jurusans.nama_jurusan')
            ->get();

        // Ambil label (nama jurusan) dan nilai (total anggota) dari hasil query
        $labels = $data->pluck('nama_jurusan');
        $values = $data->pluck('total');

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Anggota',
                    'data' => $values,
                    // Optional: Tambahkan warna agar pie chart lebih menarik
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40'
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
