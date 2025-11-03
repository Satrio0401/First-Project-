<?php

namespace App\Filament\Resources\TestingMaps\Pages;

use App\Filament\Resources\TestingMaps\TestingMapResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTestingMap extends EditRecord
{
    protected static string $resource = TestingMapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
