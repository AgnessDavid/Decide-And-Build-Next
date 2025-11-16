<?php

namespace App\Filament\Resources\FicheExpressionBesoins\Pages;

use App\Filament\Resources\FicheExpressionBesoins\FicheExpressionBesoinResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFicheExpressionBesoin extends EditRecord
{
    protected static string $resource = FicheExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
