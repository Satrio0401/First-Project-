<?php

namespace App\Filament\Resources\Penguruses\Pages;

use App\Filament\Resources\Penguruses\PengurusResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePengurus extends CreateRecord
{
    protected static string $resource = PengurusResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
