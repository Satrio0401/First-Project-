<?php

namespace App\Filament\Resources\Penguruses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Schemas\Schema;

class PengurusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengurus')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->required()
                            ->maxLength(255),
                        
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Pengurus Inti' => 'Pengurus Inti',
                                'Divisi' => 'Divisi',
                            ])
                            ->required()
                            ->default('Divisi'),
                        
                        FileUpload::make('foto')
                            ->label('Foto')
                            ->image()
                            ->directory('pengurus')
                            ->imageEditor()
                            ->maxSize(2048),
                    ])->columns(2),
                
                Section::make('Pengaturan Tampilan')
                    ->schema([
                        TextInput::make('urutan')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil angka, semakin atas urutan tampilan'),
                        
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Pengurus aktif akan ditampilkan di website'),
                    ])->columns(2),
            ]);
    }
}
