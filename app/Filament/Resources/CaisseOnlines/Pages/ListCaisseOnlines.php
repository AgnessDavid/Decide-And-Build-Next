<?php

namespace App\Filament\Resources\CaisseOnlines\Pages;

use App\Filament\Resources\CaisseOnlines\CaisseOnlineResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\CaisseOnlineStatsOverview;


class ListCaisseOnlines extends ListRecords
{
    protected static string $resource = CaisseOnlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }



    protected function getHeaderWidgets(): array
    {
        return [
            CaisseOnlineStatsOverview::class,
         
        ];
    }


}
