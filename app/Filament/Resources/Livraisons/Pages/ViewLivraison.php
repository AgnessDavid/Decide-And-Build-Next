<?php

namespace App\Filament\Resources\Livraisons\Pages;

use App\Filament\Resources\Livraisons\LivraisonResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLivraison extends ViewRecord
{
    protected static string $resource = LivraisonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
