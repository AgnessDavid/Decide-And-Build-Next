<?php

namespace App\Filament\Resources\Caisses\Pages;

use App\Filament\Resources\Caisses\CaisseResource;
use Filament\Actions\CreateAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
// Ajoutez cette ligne pour inclure le widget
use App\Filament\Widgets\CaisseStatsOverview;
use App\Filament\Widgets\CaissePieChart;
use App\Filament\Widgets\CaisseBarChart;
class ListCaisses extends ListRecords
{
    protected static string $resource = CaisseResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nouvelle Caisse'),
        ];
    }



    protected function getHeaderWidgets(): array
    {
        return [
           CaisseStatsOverview::class,
           CaisseBarChart::class,
           CaissePieChart::class,
        ];
    }



    
}
