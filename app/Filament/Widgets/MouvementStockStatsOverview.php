<?php

namespace App\Filament\Widgets;

use App\Models\MouvementStock;
use App\Models\Produit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MouvementStockStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalMouvements = MouvementStock::count();
        $totalEntrees = MouvementStock::entrees()->sum('quantite_entree');
        $totalSorties = MouvementStock::sorties()->sum('quantite_sortie');

        // Produits avec stock faible (moins de 10 unités)
        $produitsStockFaible = Produit::where('stock_actuel', '<', 10)->count();

        $stockTotal = Produit::sum('stock_actuel');
        $valeurStockMoyen = Produit::avg('stock_actuel') ?? 0;

        return [
            Stat::make('Total mouvements', $totalMouvements)
                ->description('Entrées et sorties')
                // ->descriptionIcon('heroicon-m-arrow-right-left')
                ->color('primary')
                ->chart($this->getMouvementsChartData()),

            Stat::make('Entrées totales', number_format($totalEntrees, 0, ',', ' '))
                ->description('Quantité entrée en stock')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('success'),

            Stat::make('Sorties totales', number_format($totalSorties, 0, ',', ' '))
                ->description('Quantité sortie du stock')
                ->descriptionIcon('heroicon-m-arrow-up-tray')
                ->color('danger'),

                /*
            Stat::make('Produits stock faible', $produitsStockFaible)
                ->description('Stock < 10 unités')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($produitsStockFaible > 0 ? 'danger' : 'success'),
                */
        ];
    }

    protected function getMouvementsChartData(): array
    {
        return [12, 18, 15, 22, 25, 30, 28];
    }
}