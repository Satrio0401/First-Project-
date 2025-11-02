<?php

namespace App\Filament\Resources\Anggotas\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class AnggotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                ->label('Nama')
                ->searchable()
                ->sortable()
                ->wrap(),

                // Jenis Kelamin
                TextColumn::make('kelamin')
                    ->label('Jenis Kelamin')
                    ->sortable(),

                // Tempat & Tanggal Lahir
                TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir'),
                TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date('d M Y'),

                // Alamat
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(50)
                    ->wrap(),

                // Nomor WhatsApp
                TextColumn::make('no_wa')
                    ->label('No. WA')
                    ->copyable()
                    ->searchable(),

                // Jurusan
                TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan')
                    ->sortable()
                    ->wrap(),

                // Tahun masuk kuliah
                TextColumn::make('tahun_masuk_kuliah')
                    ->label('Masuk Kuliah')
                    ->sortable(),

                // Data pelatihan LK
                TextColumn::make('tahun_lk1')
                    ->label('LK 1')
                    ->sortable(),

                TextColumn::make('tahun_lk2')
                    ->label('LK 2')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tahun_lk3')
                    ->label('LK 3')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tahun_lkk')
                    ->label('LKK')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('komisariat.nama')
                    ->label('Komisariat')
                    ->sortable()
                    ->wrap(),
                

                // Prestasi
                TextColumn::make('prestasi')
                    ->label('Prestasi')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
