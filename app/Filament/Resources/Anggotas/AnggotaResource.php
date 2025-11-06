<?php

namespace App\Filament\Resources\Anggotas;

use App\Filament\Resources\Anggotas\Pages\CreateAnggota;
use App\Filament\Resources\Anggotas\Pages\CreateUserFromAnggota;
use App\Filament\Resources\Anggotas\Pages\EditAnggota;
use App\Filament\Resources\Anggotas\Pages\ListAnggotas;
use App\Filament\Resources\Anggotas\Tables\AnggotasTable;
use App\Filament\Resources\Anggotas\Schemas\AnggotaForm;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Anggota;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AnggotaResource extends Resource
{
    protected static ?string $model = Anggota::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;

    protected static ?string $recordTitleAttribute = 'Anggota';

    public static function form(Schema $schema): Schema
    {
        return AnggotaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnggotasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAnggotas::route('/'),
            'create' => CreateAnggota::route('/create'),
            'edit' => EditAnggota::route('/{record}/edit'),
            'create-user-from-anggota' => CreateUserFromAnggota::route('/{record}/create-user-from-anggota'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        // Jika Super Admin, tampilkan semua data
        if ($user->hasRole('Super Admin')) {
            return parent::getEloquentQuery();
        }
        // Jika Admin Komisariat, filter berdasarkan komisariat_id mereka
        if ($user->hasRole('Admin Komisariat')) {
            $komisariatId = $user->anggota?->komisariat_id;
            if (!$komisariatId) {
                return parent::getEloquentQuery()->whereNull('id');
            }
            return parent::getEloquentQuery()->where('komisariat_id', $komisariatId);
        }

        // ==================================================
        // LOGIKA BARU UNTUK ROLE 'ANGGOTA'
        // ==================================================
        if ($user->hasRole('Anggota')) {
            return parent::getEloquentQuery()
                ->whereDoesntHave('user.roles', function (Builder $roleQuery) {
                    $roleQuery->whereIn('name', ['Admin Komisariat','Super Admin']);
                });
        }
        // Default, jangan tampilkan apa-apa untuk role lain
        return parent::getEloquentQuery()->whereNull('id');
    }
}
