<?php

namespace App\Filament\Resources\PaiementOnlines\Pages;

use App\Filament\Resources\PaiementOnlines\PaiementOnlineResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPaiementOnline extends ViewRecord
{
    protected static string $resource = PaiementOnlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
