<?php

namespace App\Filament\Resources\Penguruses\Pages;

use App\Filament\Resources\Penguruses\PengurusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenguruses extends ListRecords
{
    protected static string $resource = PengurusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
