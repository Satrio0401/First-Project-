<?php

namespace App\Filament\Resources\Anggotas\Pages;

use App\Filament\Resources\Anggotas\AnggotaResource;
use Carbon\Carbon;
use Filament\Actions\CreateAction;
// use Filament\Forms\Components\Builder;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Actions\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Illuminate\Database\Eloquent\Builder;

class ListAnggotas extends ListRecords
{
    protected static string $resource = AnggotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExportAction::make()
                ->label('Ekspor ke Excel')
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->modifyQueryUsing(function (Builder $query) {
                            return $query->whereHas('user', function (Builder $userQuery) {
                                $userQuery->whereHas('roles', function (Builder $roleQuery) {
                                    $roleQuery->where('name', 'Anggota');
                                });
                            });
                        })
                        ->withFilename('Data Anggota - ' . date('Y-m-d'))
                        ->withColumns([
                            Column::make('nama')->heading('Nama'),
                            Column::make('kelamin')->heading('Jenis Kelamin'),
                            Column::make('tempat_tanggal_lahir')
                                ->heading('Tempat, Tanggal Lahir')
                                ->formatStateUsing(function ($record) {
                                    if (empty($record->tanggal_lahir)) {
                                        return $record->tempat_lahir ?? null;
                                    }
                                    $tanggal = Carbon::parse($record->tanggal_lahir)
                                        ->locale('id')
                                        ->translatedFormat('d F Y');
                                    return $record->tempat_lahir . ', ' . $tanggal;
                                }),
                            Column::make('alamat')->heading('Alamat'),
                            Column::make('no_wa')->heading('No. WA'),
                            Column::make('jurusan.nama_jurusan')->heading('Jurusan'),
                            Column::make('tahun_masuk_kuliah')->heading('Masuk Kuliah'),
                            Column::make('tahun_lk1')->heading('Tahun LK1'),
                            Column::make('tahun_lk2')->heading('Tahun LK2'),
                            Column::make('tahun_lk3')->heading('Tahun LK3'),
                            Column::make('tahun_lkk')->heading('Tahun LKK'),
                            Column::make('komisariat.nama')->heading('Komisariat'),
                            Column::make('prestasi')->heading('Prestasi'),
                        ])
                ]),
        ];
    }
}
