<?php

namespace App\Filament\Resources\TestingMaps\Schemas;

use App\Filament\Forms\Components\MapLocationPickerJsVanilla;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestingMapForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Percobaan dgn vanilla js (tanpa alpine) Lokasi Geospasial')
                    ->description('Klik peta atau ketik koordinat untuk menentukan lokasi.')
                    ->schema([
                        MapLocationPickerJsVanilla::make('location')
                            ->label('Pilih Lokasi di Peta')
                            ->columnSpanFull()
                            ->dehydrated(false)
                            ->latitudeId('latitude-testing')
                            ->longitudeId('longitude-testing'),

                        TextInput::make('latitude')
                            ->id('latitude-testing')
                            ->numeric()
                            ->default(-0.0236)
                            ->required(),

                        TextInput::make('longitude')
                            ->id('longitude-testing')
                            ->numeric()
                            ->default(109.3322)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}
