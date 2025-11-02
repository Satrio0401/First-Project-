<?php

namespace App\Filament\Resources\Komisariats\Schemas;

use App\Filament\Forms\Components\MapLocationPicker;
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
                    ])
                    ->columns(2),

                Section::make('Lokasi Geospasial')
                    ->description('Klik atau geser pin di peta untuk menentukan lokasi.')
                    ->schema([
                        MapLocationPicker::make('location')
                            ->label('Pilih Lokasi di Peta')
                            ->columnSpanFull()
                            ->live()
                            ->afterStateUpdated(function (callable $set, ?array $state): void {
                                if ($state) {
                                    $set('latitude', $state['lat']);
                                    $set('longitude', $state['lng']);
                                }
                            }),

                        Hidden::make('latitude'),
                        Hidden::make('longitude'),

                    ]),
            ]);
    }
}
