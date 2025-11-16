<?php

namespace App\Filament\Resources\PaiementOnlines\Pages;

use App\Filament\Resources\PaiementOnlines\PaiementOnlineResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPaiementOnline extends EditRecord
{
    protected static string $resource = PaiementOnlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
