<?php

namespace App\Filament\Resources\Misis\Pages;

use App\Filament\Resources\Misis\MisiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMisis extends ListRecords
{
    protected static string $resource = MisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
