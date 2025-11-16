<?php

namespace App\Filament\Resources\FicheExpressionBesoins\Pages;

use App\Filament\Resources\FicheExpressionBesoins\FicheExpressionBesoinResource;
use App\Filament\Widgets\FicheBesoinStatsOverview;
use App\Filament\Widgets\FichesRecentTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFicheExpressionBesoins extends ListRecords
{
    protected static string $resource = FicheExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
          FicheBesoinStatsOverview::class,
          //fichesRecentTable::class,
            // ServiceDemandesChart::class,
        ];
    }



}
