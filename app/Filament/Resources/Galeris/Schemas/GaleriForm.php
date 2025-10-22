<?php

namespace App\Filament\Resources\Galeris\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GaleriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                
                Section::make('Judul')->schema([TextInput::make('judul')->required()->maxLength(255),]),
                Section::make('Gambar')
                    ->schema([
                        Repeater::make('images')
                            ->relationship()
                            ->schema([
                                FileUpload::make('path')
                                    ->label('Unggah Gambar')
                                    ->disk('public')
                                    ->image()
                                    ->directory('galeri-images')
                                    ->visibility('public')
                                    ->required()
                                    ->imageEditor(),

                            ])
                            ->columns(1)
                            ->addActionLabel('Tambah Gambar')
                            ->defaultItems(1)
                            ->grid(2),
                    ]),
            ]);
    }
}
