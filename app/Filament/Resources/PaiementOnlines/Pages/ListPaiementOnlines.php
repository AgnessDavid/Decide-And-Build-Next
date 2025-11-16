<?php

namespace App\Filament\Resources\PaiementOnlines\Pages;

use App\Filament\Resources\PaiementOnlines\PaiementOnlineResource;
use App\Filament\Widgets\LatestPaiementsTable;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\PaiementStatsOverview;

class ListPaiementOnlines extends ListRecords
{
    protected static string $resource = PaiementOnlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];

    }


    protected function getHeaderWidgets(): array
    {
        return [
            PaiementStatsOverview::class,
            LatestPaiementsTable::class,
        ];
    }





}
