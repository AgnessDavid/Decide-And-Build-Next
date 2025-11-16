<?php

namespace App\Filament\Resources\ValidationFicheExpressionBesoins\Pages;

use App\Filament\Resources\ValidationFicheExpressionBesoins\ValidationFicheExpressionBesoinResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\ValidationFicheStatsOverview;
class ListValidationFicheExpressionBesoins extends ListRecords
{
    protected static string $resource = ValidationFicheExpressionBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }



    protected function getHeaderWidgets(): array
    {
        return [
            ValidationFicheStatsOverview::class,
        ];
    }


}
