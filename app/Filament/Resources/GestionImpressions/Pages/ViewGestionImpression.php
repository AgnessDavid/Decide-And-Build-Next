<?php

namespace App\Filament\Resources\GestionImpressions\Pages;

use App\Filament\Resources\GestionImpressions\GestionImpressionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGestionImpression extends ViewRecord
{
    protected static string $resource = GestionImpressionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
