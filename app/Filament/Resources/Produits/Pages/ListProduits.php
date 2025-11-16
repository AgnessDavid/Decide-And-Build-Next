<?php

namespace App\Filament\Resources\Produits\Pages;

use App\Filament\Resources\Produits\ProduitResource;
use App\Filament\Widgets\ProduitsPlusVendusChart;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\ProduitStatsOverview;

class ListProduits extends ListRecords
{
    protected static string $resource = ProduitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }



    protected function getHeaderWidgets(): array
    {
        return [
      ProduitStatsOverview::class,
     // ProduitsPlusVendusChart::class,

        ];
    }




}
