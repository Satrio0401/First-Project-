<?php

namespace App\Filament\Resources\Komisariats;

use App\Filament\Resources\Komisariats\Pages\CreateKomisariat;
use App\Filament\Resources\Komisariats\Pages\EditKomisariat;
use App\Filament\Resources\Komisariats\Pages\ListKomisariats;
use App\Filament\Resources\Komisariats\Schemas\KomisariatForm;
use App\Filament\Resources\Komisariats\Tables\KomisariatsTable;
use App\Models\Komisariat;
use Illuminate\Database\Eloquent\Builder; 
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KomisariatResource extends Resource
{
    protected static ?string $model = Komisariat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;

    protected static ?string $navigationLabel = 'Komisariat';

    protected static ?string $modelLabel = 'Komisariat';

    protected static ?string $pluralModelLabel = 'Komisariat';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return KomisariatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KomisariatsTable::configure($table);
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
            'index' => ListKomisariats::route('/'),
            'create' => CreateKomisariat::route('/create'),
            'edit' => EditKomisariat::route('/{record}/edit'),
        ];
    }

    //Batasan akses
    public static function canAccess(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        return $user?->hasRole('Super Admin') ?? false;
    }
}
