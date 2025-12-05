<?php

namespace App\Filament\Resources\Anggotas\Pages;

use App\Filament\Resources\Anggotas\AnggotaResource;
use App\Models\Anggota;
use App\Models\Jurusan;
use Carbon\Carbon;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions\Action;
use Illuminate\Support\Collection;
use Filament\Actions\CreateAction;
// use Filament\Forms\Components\Builder;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\FileUpload;
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
                ->uploadField(
                    fn (FileUpload $field) => $field->label('Format File')
                )
                ->sampleExcel(
                    sampleData: [
                        ['nama' => '', 'jenis_kelamin' => '', 'ttl' => '', 'alamat' => '', 'no_hpwa' => '', 'tahun_masuk_kuliah' => '', 'jurusan/program studi' => ''],
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
                ->processCollectionUsing(function (string $modelClass, Collection $rows) {
                    // dd($rows);
                    foreach ($rows as $row) {
                        $tempat = null;
                        $tanggal = null;

                        if (!empty($row['ttl'])) {
                            $value = trim($row['ttl']);

                            if (strpos($value, ',') !== false) {
                                $parts = explode(',', $value);
                            } else {
                                $parts = preg_split('/\s+(?=\d)/', $value, 2);
                            }

                            $tempat = trim($parts[0] ?? '');

                            try {
                                $tanggal = Carbon::parse(trim($parts[1] ?? ''))->format('Y-m-d');
                            } catch (\Exception) {
                                $tanggal = null;
                            }
                        }
                        $kelamin = null;
                        if (!empty($row['jenis_kelamin'])) {
                            $val = strtolower(trim($row['jenis_kelamin']));

                            $kelamin = match (true) {
                                in_array($val, ['l', 'laki', 'laki-laki']) => 'Laki-laki',
                                in_array($val, ['p', 'perempuan']) => 'Perempuan',
                                default => null,
                            };
                        }
                        $jurusanId = null;
                        if (!empty($row['jurusan/program studi'])) {
                            $jurusan = Jurusan::where('nama_jurusan', 'LIKE', '%' . $row['jurusan/program studi'] . '%')->first();
                            $jurusanId = $jurusan?->id;
                        }

                        // ===========================
                        // 4. SIMPAN KE DATABASE
                        // ===========================
                        // dd($row);
                        Anggota::create([
                            'nama'                => $row['nama'] ?? null,
                            'kelamin'             => $kelamin,
                            'tempat_lahir'        => $tempat,
                            'tanggal_lahir'       => $tanggal,
                            'alamat'              => $row['alamat'] ?? null,
                            'no_wa'               => $row['no_hpwa'] ?? null,
                            'tahun_masuk_kuliah'  => $row['tahun_masuk_kuliah'] ?? null,
                            'jurusan_id'          => $jurusanId,
                        ]);
                    }

                    return $rows;
                }),

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
