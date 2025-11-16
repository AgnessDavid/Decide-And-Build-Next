<?php

namespace App\Filament\Resources\DemandeExpressionBesoins\Pages;

use App\Filament\Resources\DemandeExpressionBesoins\DemandeExpressionBesoinResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDemandeExpressionBesoin extends EditRecord
{
    protected static string $resource = DemandeExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
