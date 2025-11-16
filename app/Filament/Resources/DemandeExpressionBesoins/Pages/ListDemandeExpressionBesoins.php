<?php

namespace App\Filament\Resources\DemandeExpressionBesoins\Pages;

use App\Filament\Resources\DemandeExpressionBesoins\DemandeExpressionBesoinResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\DemandeBesoinStatsOverview;
use App\Filament\Widgets\TypeImpressionChart;
use App\Filament\Widgets\ServiceDemandesChart;
class ListDemandeExpressionBesoins extends ListRecords
{
    protected static string $resource = DemandeExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return [
            DemandeBesoinStatsOverview::class,
            TypeImpressionChart::class,
           // ServiceDemandesChart::class,
        ];
    }


}
