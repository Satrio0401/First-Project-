<?php

namespace App\Filament\Resources\ProgramKerjas;

use App\Filament\Resources\ProgramKerjas\Pages\CreateProgramKerja;
use App\Filament\Resources\ProgramKerjas\Pages\EditProgramKerja;
use App\Filament\Resources\ProgramKerjas\Pages\ListProgramKerjas;
use App\Filament\Resources\ProgramKerjas\Schemas\ProgramKerjaForm;
use App\Filament\Resources\ProgramKerjas\Tables\ProgramKerjasTable;
use App\Models\ProgramKerja;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProgramKerjaResource extends Resource
{
    protected static ?string $model = ProgramKerja::class;
    protected static string | UnitEnum | null $navigationGroup = 'Konten';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static ?string $navigationLabel = 'Program Kerja';

    protected static ?string $modelLabel = 'Program Kerja';

    protected static ?string $pluralModelLabel = 'Program Kerja';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ProgramKerjaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgramKerjasTable::configure($table);
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
            'index' => ListProgramKerjas::route('/'),
            'create' => CreateProgramKerja::route('/create'),
            'edit' => EditProgramKerja::route('/{record}/edit'),
        ];
    }
}
