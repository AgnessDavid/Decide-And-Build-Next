<?php

namespace App\Filament\Resources\CommandeOnlines\Pages;

use App\Filament\Resources\CommandeOnlines\CommandeOnlineResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\CommandeRevenueChart;
use App\Filament\Widgets\CommandeStatsOverview;
use App\Filament\Widgets\CommandeRevenueLastChart;
class ListCommandeOnlines extends ListRecords
{
    protected static string $resource = CommandeOnlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CommandeStatsOverview::class,
            CommandeRevenueChart::class,
            CommandeRevenueLastChart::class,
          
        ];
    }


}
