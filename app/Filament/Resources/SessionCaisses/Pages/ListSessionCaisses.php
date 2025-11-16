<?php

namespace App\Filament\Resources\SessionCaisses\Pages;

use App\Filament\Resources\SessionCaisses\SessionCaisseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\SessionCaisseStatsOverview;
class ListSessionCaisses extends ListRecords
{
    protected static string $resource = SessionCaisseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }



    protected function getHeaderWidgets(): array
    {
        return [
       SessionCaisseStatsOverview::class,
        ];
    }




}
