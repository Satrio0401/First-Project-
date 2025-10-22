<?php

namespace App\Filament\Resources\ProgramKerjas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProgramKerjaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Program Kerja')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Program')
                            ->required()
                            ->maxLength(255),
                        
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Selesai' => 'Selesai',
                            ])
                            ->required()
                            ->default('Aktif')
                            ->native(false),
                        
                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Section::make('Jadwal Program')
                    ->schema([
                        DatePicker::make('tanggal_mulai')
                            ->label('Tanggal Mulai')
                            ->displayFormat('d/m/Y')
                            ->native(false),
                        
                        DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai')
                            ->displayFormat('d/m/Y')
                            ->native(false)
                            ->after('tanggal_mulai'),
                    ])->columns(2),
            ]);
    }
}
