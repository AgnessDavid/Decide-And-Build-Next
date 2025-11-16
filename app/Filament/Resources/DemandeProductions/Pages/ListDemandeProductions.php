<?php

namespace App\Filament\Resources\DemandeProductions\Pages;

use App\Filament\Resources\DemandeProductions\DemandeProductionResource;
use App\Filament\Widgets\DemandeImpressionStatsOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDemandeProductions extends ListRecords
{
    protected static string $resource = DemandeProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return [
            DemandeImpressionStatsOverview::class,
           
            // ServiceDemandesChart::class,
        ];
    }




}
