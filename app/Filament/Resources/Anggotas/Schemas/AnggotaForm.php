<?php

namespace App\Filament\Resources\Penguruses\Schemas;

use App\Filament\Forms\Components\MapLocationPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AnggotaForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = auth()->user();
        return $schema
            ->columns(1) 
            ->components([
                Section::make('Informasi Anggota')
                    ->schema([
                        TextInput::make('user.name')
                            ->label('Nama Lengkap')
                            ->required()                            
                            ->maxLength(255),
                        Select::make('komisariat_id')
                            ->label('Asal Komisariat')
                            ->relationship('user.komisariat', 'nama')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default($user->komisariat_id)
                            ->disabled(! $user->hasRole('Super Admin')),
                        Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('foto')
                            ->label('Foto Anggota')
                            ->image()
                            ->directory('anggota')
                            ->imageEditor()
                            ->maxSize(2048),
                    ])->columns(2),

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
