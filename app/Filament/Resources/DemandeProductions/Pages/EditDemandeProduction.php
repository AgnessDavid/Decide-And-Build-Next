<?php

namespace App\Filament\Resources\DemandeProductions\Pages;

use App\Filament\Resources\DemandeProductions\DemandeProductionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDemandeProduction extends EditRecord
{
    protected static string $resource = DemandeProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
