<?php

namespace App\Filament\Resources\Komisariats\Pages;

use App\Filament\Resources\Komisariats\KomisariatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKomisariats extends ListRecords
{
    protected static string $resource = KomisariatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
