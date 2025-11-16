<?php

namespace App\Filament\Resources\DemandeProductions\Pages;

use App\Filament\Resources\DemandeProductions\DemandeProductionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDemandeProduction extends ViewRecord
{
    protected static string $resource = DemandeProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
