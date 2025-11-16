<?php

namespace App\Filament\Resources\CaisseOnlines\Pages;

use App\Filament\Resources\CaisseOnlines\CaisseOnlineResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCaisseOnline extends ViewRecord
{
    protected static string $resource = CaisseOnlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
