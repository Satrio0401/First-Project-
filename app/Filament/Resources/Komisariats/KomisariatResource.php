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

    protected static ?string $recordTitleAttribute = 'komisariat';

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
        return auth()->user()?->hasRole('Super Admin');
    }
}
