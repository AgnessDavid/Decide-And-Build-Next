<?php

namespace App\Filament\Resources\SessionCaisses\Pages;

use App\Filament\Resources\SessionCaisses\SessionCaisseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSessionCaisse extends ViewRecord
{
    protected static string $resource = SessionCaisseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
