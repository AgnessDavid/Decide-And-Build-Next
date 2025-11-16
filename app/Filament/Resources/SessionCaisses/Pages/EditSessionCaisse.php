<?php

namespace App\Filament\Resources\SessionCaisses\Pages;

use App\Filament\Resources\SessionCaisses\SessionCaisseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSessionCaisse extends EditRecord
{
    protected static string $resource = SessionCaisseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
