<?php

namespace App\Filament\Resources\GestionImpressions\Pages;

use App\Filament\Resources\GestionImpressions\GestionImpressionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\GestionImpressionStatsOverview;
class ListGestionImpressions extends ListRecords
{
    protected static string $resource = GestionImpressionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return [
           GestionImpressionStatsOverview::class,
            
        ];
    }

}
