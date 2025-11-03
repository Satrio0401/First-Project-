<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class MapLocationPickerJsVanilla extends Field
{
    protected string $view = 'filament.forms.components.map-location-picker-js-vanilla';
    protected string $latitudeId = 'latitude-input';
    protected string $longitudeId = 'longitude-input';

    public function latitudeId(string $id): static
    {
        $this->latitudeId = $id;
        return $this;
    }

    public function longitudeId(string $id): static
    {
        $this->longitudeId = $id;
        return $this;
    }

    public function getLatitudeId(): string
    {
        return $this->latitudeId;
    }

    public function getLongitudeId(): string
    {
        return $this->longitudeId;
    }
}
