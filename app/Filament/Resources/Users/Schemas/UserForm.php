<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use App\Models\Anggota;
use Filament\Infolists\Components\TextEntry;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // 🔹 Pilih Anggota (hanya yang belum punya user)
            Select::make('anggota_id')
                ->label('Anggota')
                ->options(
                    fn() => Anggota::whereDoesntHave('user')
                        ->pluck('nama', 'id')
                )
                ->searchable()
                ->preload()
                ->required()
                ->helperText('Hanya menampilkan anggota yang belum memiliki user. Nama user akan otomatis diambil dari sini.'),

            // 🔹 Email
            TextInput::make('email')
                ->label('Email')
                ->email()
                ->unique(ignoreRecord: true)
                ->required(),

            // 🔹 Komisariat
            Select::make('komisariat_id')
                ->label('Komisariat')
                ->relationship('anggota.komisariat', 'nama')
                ->searchable()
                ->preload(),

            // 🔹 Password
            TextInput::make('password')
                ->label('Password')
                ->password()
                ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                ->required(fn(string $context): bool => $context === 'create')
                ->revealable(),

            // 🔹 Role Spatie
            Select::make('roles')
                ->label('Role')
                ->multiple()
                ->relationship('roles', 'name')
                ->preload()
                ->required(),

            // 🔹 Nama Anggota ditampilkan otomatis (tidak bisa diedit)
            TextEntry::make('nama_anggota')
                ->label('Nama Anggota')
                ->state(fn($record) => $record?->anggota?->nama ?? '-') 
                ->dehydrated(false),
        ]);
    }
}
