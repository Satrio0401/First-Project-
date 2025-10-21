<?php

namespace App\Filament\Resources\Beritas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BeritasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->square()
                    ->defaultImageUrl(url('/images/default-news.png')),
                    
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),
                    
                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Artikel' => 'info',
                        'Pengumuman' => 'warning',
                    })
                    ->sortable(),
                    
                IconColumn::make('is_published')
                    ->label('Terbit')
                    ->boolean()
                    ->sortable(),
                    
                TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                    
                TextColumn::make('views')
                    ->label('Dilihat')
                    ->numeric()
                    ->sortable()
                    ->suffix(' kali'),
                    
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'Artikel' => 'Artikel',
                        'Pengumuman' => 'Pengumuman',
                    ]),
                    
                TernaryFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->placeholder('Semua')
                    ->trueLabel('Terbit')
                    ->falseLabel('Draft'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }
}
