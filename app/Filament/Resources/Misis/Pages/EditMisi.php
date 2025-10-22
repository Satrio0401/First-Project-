<?php

namespace App\Filament\Resources\Misis\Pages;

use App\Filament\Resources\Misis\MisiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMisi extends EditRecord
{
    protected static string $resource = MisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
