<?php

namespace App\Filament\Resources\ImprimerieExpressionBesoins\Pages;

use App\Filament\Resources\ImprimerieExpressionBesoins\ImprimerieExpressionBesoinResource;
use App\Filament\Widgets\ImprimerieExpressionStatsOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListImprimerieExpressionBesoins extends ListRecords
{
    protected static string $resource = ImprimerieExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return [
            
   ImprimerieExpressionStatsOverview::class,


        ];
    }


}
