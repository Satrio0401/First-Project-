<?php

namespace App\Filament\Resources\Komisariats\Schemas;

use App\Filament\Forms\Components\MapLocationPicker;
use App\Filament\Forms\Components\MapLocationPickerJsVanilla;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KomisariatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informasi Komisariat')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Komisariat')
                            ->required(),

                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->columnSpanFull(),
                        FileUpload::make('foto')
                            ->label('Foto Komisariat')
                            ->image()
                            ->directory('komisariat')
                            ->imageEditor()
                            ->maxSize(2048),
                    ])
                    ->columns(2),

                Section::make('Lokasi Geospasial')
                    ->description('Klik atau geser pin di peta untuk menentukan lokasi.')
                    ->schema([
                        MapLocationPickerJsVanilla::make('location')
                            ->label('Pilih Lokasi di Peta')
                            ->columnSpanFull()
                            ->dehydrated(false)
                            ->latitudeId('komisariat-latitude')
                            ->longitudeId('komisariat-longitude'),

                        TextInput::make('latitude')
                            ->id('komisariat-latitude')
                            ->numeric()
                            ->required(),
                        TextInput::make('longitude')
                            ->id('komisariat-longitude')
                            ->numeric()
                            ->required(),
                    ]),
            ]);
    }
}
