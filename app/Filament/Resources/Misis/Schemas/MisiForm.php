<?php

namespace App\Filament\Resources\Misis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MisiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Misi')
                ->schema([
                    TextInput::make('deskripsi_misi')
                    ->label('Deksripsi')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                ])
            ]);
    }
}
