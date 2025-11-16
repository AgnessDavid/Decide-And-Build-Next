<?php

namespace App\Filament\Resources\DemandeExpressionBesoins\Pages;

use App\Filament\Resources\DemandeExpressionBesoins\DemandeExpressionBesoinResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDemandeExpressionBesoin extends ViewRecord
{
    protected static string $resource = DemandeExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
