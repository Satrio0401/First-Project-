<?php

namespace App\Filament\Resources\Anggotas\Pages;

use App\Filament\Resources\Anggotas\AnggotaResource;
use App\Imports\AnggotaImport;
use App\Models\Anggota;
use App\Models\Jurusan;
use Carbon\Carbon;
use EightyNine\ExcelImport\ExcelImportAction;
use EightyNine\ExcelImport\Exceptions\ImportStoppedException;
use Filament\Actions\Action;
use Illuminate\Support\Collection;
use Filament\Actions\CreateAction;
// use Filament\Forms\Components\Builder;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Checkbox;
use Filament\Notifications\Notification;
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
            ExcelImportAction::make()
                ->use(AnggotaImport::class)
                ->uploadField(
                    fn (FileUpload $field) => $field->label('Data Anggota')
                )
                ->sampleExcel(
                    sampleData: [
                        ['NAMA' => 'Doni Handoko', 'JENIS KELAMIN' => 'laki-laki', 'TTL' => 'Tekarang, 1 April 2006', 'ALAMAT' => 'Desa Tekarang, Kabupaten sambas', 'NO HP/WA' => '085754400764', 'TAHUN MASUK KULIAH' => '2024', 'JURUSAN/PROGRAM STUDI' => 'Teknik Arsitektur'],
                        ['NAMA' => 'Bunga Cahaya Luna', 'JENIS KELAMIN' => 'Perempuan', 'TTL' => 'Semarang, 23 Agustus 2003', 'ALAMAT' => 'Desa Indah Permai, Kabupaten Panurukan', 'NO HP/WA' => '085776918462', 'TAHUN MASUK KULIAH' => '2021', 'JURUSAN/PROGRAM STUDI' => 'Teknik Kimia'],
                    ],
                    fileName: 'Contoh Impor Anggota - ' . date('Y-m-d') .'.xlsx',
                    sampleButtonLabel: 'Unduh Contoh',
                    customiseActionUsing: fn(Action $action) => $action->color('secondary')
                        ->icon('heroicon-m-clipboard')
                        ->requiresConfirmation(true),
                )
                ->label('Import Excel')
                ->modalHeading('Import File Excel')
                ->closeModalByClickingAway(true)
                ->modalDescription('Silahkan import file excel anda')
                ->visible(fn () => auth()->user()->hasRole('Super Admin')),
            CreateAction::make(),
            ExportAction::make()
                ->label('Ekspor ke Excel')
                ->icon('heroicon-o-arrow-up-tray')
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
