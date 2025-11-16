<?php

namespace App\Filament\Resources\CommandeOnlines\Pages;

use App\Filament\Resources\CommandeOnlines\CommandeOnlineResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCommandeOnline extends ViewRecord
{
    protected static string $resource = CommandeOnlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
