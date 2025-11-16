<?php

namespace App\Filament\Resources\ValidationFicheExpressionBesoins\Pages;

use App\Filament\Resources\ValidationFicheExpressionBesoins\ValidationFicheExpressionBesoinResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewValidationFicheExpressionBesoin extends ViewRecord
{
    protected static string $resource = ValidationFicheExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
