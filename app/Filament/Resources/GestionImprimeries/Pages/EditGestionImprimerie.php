<?php

namespace App\Filament\Resources\GestionImprimeries\Pages;

use App\Filament\Resources\GestionImprimeries\GestionImprimerieResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGestionImprimerie extends EditRecord
{
    protected static string $resource = GestionImprimerieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
