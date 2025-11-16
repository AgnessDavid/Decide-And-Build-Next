<?php

namespace App\Filament\Resources\ValidationFicheExpressionBesoins\Pages;

use App\Filament\Resources\ValidationFicheExpressionBesoins\ValidationFicheExpressionBesoinResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditValidationFicheExpressionBesoin extends EditRecord
{
    protected static string $resource = ValidationFicheExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
