<?php

namespace App\Filament\Resources\Imprimeries\Pages;

use App\Filament\Resources\Imprimeries\ImprimerieResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditImprimerie extends EditRecord
{
    protected static string $resource = ImprimerieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
