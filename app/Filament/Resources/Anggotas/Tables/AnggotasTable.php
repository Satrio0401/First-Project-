<?php

namespace App\Filament\Resources\Anggotas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnggotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto')
                    ->square()
                    ->defaultImageUrl(url('/images/default-news.png')),
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('komisariat.nama')
                    ->label('Komisariat')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),
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
