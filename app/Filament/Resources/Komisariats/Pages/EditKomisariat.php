<?php

namespace App\Filament\Resources\Komisariats\Pages;

use App\Filament\Resources\Komisariats\KomisariatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKomisariat extends EditRecord
{
    protected static string $resource = KomisariatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
