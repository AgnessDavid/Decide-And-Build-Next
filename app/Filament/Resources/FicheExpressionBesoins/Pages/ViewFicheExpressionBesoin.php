<?php

namespace App\Filament\Resources\FicheExpressionBesoins\Pages;

use App\Filament\Resources\FicheExpressionBesoins\FicheExpressionBesoinResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFicheExpressionBesoin extends ViewRecord
{
    protected static string $resource = FicheExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
