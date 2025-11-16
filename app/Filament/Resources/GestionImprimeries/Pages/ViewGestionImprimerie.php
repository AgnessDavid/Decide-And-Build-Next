<?php

namespace App\Filament\Resources\GestionImprimeries\Pages;

use App\Filament\Resources\GestionImprimeries\GestionImprimerieResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGestionImprimerie extends ViewRecord
{
    protected static string $resource = GestionImprimerieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
