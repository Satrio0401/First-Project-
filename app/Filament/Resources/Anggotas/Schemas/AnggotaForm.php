<?php

namespace App\Filament\Resources\Penguruses\Schemas;

use App\Filament\Forms\Components\MapLocationPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
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
                        TextInput::make('nama')
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
                            ->label('Alamat')
                            ->nullable()
                            ->columnSpanFull(),

                        Select::make('kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required(),

                        TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->nullable(),

                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->nullable(),

                        TextInput::make('no_wa')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->maxLength(20)
                            ->nullable(),

                        TextInput::make('tahun_masuk_kuliah')
                            ->label('Tahun Masuk Kuliah')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y'))
                            ->nullable(),

                        Select::make('jurusan_id')
                            ->label('Jurusan')
                            ->relationship('jurusan', 'nama')
                            ->searchable()
                            ->nullable(),

                        TextInput::make('tahun_lk1')
                            ->label('Tahun LK1')
                            ->numeric()
                            ->nullable(),

                        TextInput::make('tahun_lk2')
                            ->label('Tahun LK2')
                            ->numeric()
                            ->nullable(),

                        TextInput::make('cabang_lk2')
                            ->label('Cabang LK2')
                            ->nullable(),

                        TextInput::make('tahun_lk3')
                            ->label('Tahun LK3')
                            ->numeric()
                            ->nullable(),

                        TextInput::make('badko_lk3')
                            ->label('Badko LK3')
                            ->nullable(),

                        TextInput::make('tahun_lkk')
                            ->label('Tahun LKK')
                            ->numeric()
                            ->nullable(),

                        TextInput::make('cabang_lkk')
                            ->label('Cabang LKK')
                            ->nullable(),

                        Textarea::make('prestasi')
                            ->label('Prestasi')
                            ->rows(3)
                            ->nullable(),

                        FileUpload::make('foto')
                            ->label('Foto Anggota')
                            ->image()
                            ->directory('anggota')
                            ->imageEditor()
                            ->maxSize(2048),
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
