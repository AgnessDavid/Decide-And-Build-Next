<?php

namespace App\Filament\Resources\MouvementStocks\Pages;

use App\Filament\Resources\MouvementStocks\MouvementStockResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMouvementStock extends ViewRecord
{
    protected static string $resource = MouvementStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
