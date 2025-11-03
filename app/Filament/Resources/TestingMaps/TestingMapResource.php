<?php

namespace App\Filament\Resources\TestingMaps;

use App\Filament\Resources\TestingMaps\Pages\CreateTestingMap;
use App\Filament\Resources\TestingMaps\Pages\EditTestingMap;
use App\Filament\Resources\TestingMaps\Pages\ListTestingMaps;
use App\Filament\Resources\TestingMaps\Schemas\TestingMapForm;
use App\Filament\Resources\TestingMaps\Tables\TestingMapsTable;
use App\Models\TestingMap;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TestingMapResource extends Resource
{
    protected static ?string $model = TestingMap::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'TestingMap';

    public static function form(Schema $schema): Schema
    {
        return TestingMapForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestingMapsTable::configure($table);
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
            'index' => ListTestingMaps::route('/'),
            'create' => CreateTestingMap::route('/create'),
            'edit' => EditTestingMap::route('/{record}/edit'),
        ];
    }
}
