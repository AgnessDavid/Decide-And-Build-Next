<?php

namespace App\Filament\Resources\Imprimeries\Pages;

use App\Filament\Resources\Imprimeries\ImprimerieResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewImprimerie extends ViewRecord
{
    protected static string $resource = ImprimerieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
