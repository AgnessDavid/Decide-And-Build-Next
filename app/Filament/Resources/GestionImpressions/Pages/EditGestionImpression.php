<?php

namespace App\Filament\Resources\GestionImpressions\Pages;

use App\Filament\Resources\GestionImpressions\GestionImpressionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGestionImpression extends EditRecord
{
    protected static string $resource = GestionImpressionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
