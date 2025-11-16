<?php

namespace App\Filament\Resources\Depenses\Pages;

use App\Filament\Resources\Depenses\DepenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\DepenseStatsOverview;
class ListDepenses extends ListRecords
{
    protected static string $resource = DepenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }



    protected function getHeaderWidgets(): array
    {
        return [
            DepenseStatsOverview::class,
        ];
    }




}
