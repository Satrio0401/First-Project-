<?php

namespace App\Filament\Resources\TestingMaps\Pages;

use App\Filament\Resources\TestingMaps\TestingMapResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTestingMaps extends ListRecords
{
    protected static string $resource = TestingMapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
