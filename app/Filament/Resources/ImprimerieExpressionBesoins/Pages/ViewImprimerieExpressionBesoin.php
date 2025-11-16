<?php

namespace App\Filament\Resources\ImprimerieExpressionBesoins\Pages;

use App\Filament\Resources\ImprimerieExpressionBesoins\ImprimerieExpressionBesoinResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewImprimerieExpressionBesoin extends ViewRecord
{
    protected static string $resource = ImprimerieExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
