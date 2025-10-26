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
    public static function schema(Schema $schema): Schema
    {
        return $schema
            ->columns(1) // Set layout utama ke 1 kolom
            ->components([
                Section::make('Informasi Anggota')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        // 👇 Input untuk Relasi Komisariat
                        Select::make('komisariat_id')
                            ->label('Asal Komisariat')
                            ->relationship('komisariat', 'nama') // Hubungkan ke relasi 'komisariat' & tampilkan kolom 'nama'
                            ->searchable() // Agar bisa dicari
                            ->preload()    // Muat opsi saat halaman dibuka
                            ->createable() // Ini akan memunculkan opsi untuk membuat komisariat baru
                            ->required(),
                        
                        Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(), // Agar alamat lebarnya penuh
                    ])->columns(2), // Section ini punya 2 kolom

                Section::make('Lokasi Geospasial')
                    ->description('Klik atau geser pin di peta untuk menentukan lokasi.')
                    ->schema([
                        // 👇 Input Peta Interaktif
                        // Pastikan komponen MapLocationPicker Anda sudah dibuat
                        MapLocationPicker::make('location')
                            ->label('Pilih Lokasi di Peta')
                            ->columnSpanFull()
                            ->live() // Agar update saat digeser
                            // Ambil state 'location' dan pecah menjadi latitude & longitude
                            ->afterStateUpdated(function (callable $set, ?array $state): void {
                                if ($state) {
                                    $set('latitude', $state['lat']);
                                    $set('longitude', $state['lng']);
                                }
                            })
                            // Saat form diload (misal, edit), gabungkan latitude & longitude menjadi state 'location'
                            ->hydrateStateUsing(function (callable $get) {
                                $lat = $get('latitude');
                                $lng = $get('longitude');
                                if ($lat && $lng) {
                                    return ['lat' => (float)$lat, 'lng' => (float)$lng];
                                }
                                return null; // Default value jika belum ada koordinat
                            }),

                        // Field ini tetap dibutuhkan untuk menyimpan data ke database, tapi kita sembunyikan
                        Hidden::make('latitude'),
                        Hidden::make('longitude'),
                    ]),
            ]);
    }
}