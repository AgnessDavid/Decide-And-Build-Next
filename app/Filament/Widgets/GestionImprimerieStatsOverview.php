<?php

namespace App\Filament\Widgets;

use App\Models\GestionImprimerie;
use App\Models\Produit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GestionImprimerieStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalMouvements = GestionImprimerie::count();
        $totalEntrees = GestionImprimerie::where('type_mouvement', 'entrée')->sum('quantite_entree');
        $totalSorties = GestionImprimerie::where('type_mouvement', 'sortie')->sum('quantite_sortie');

        // Stocks critiques (en dessous du stock minimum)
        $stocksCritiques = GestionImprimerie::where('stock_actuel', '<', \DB::raw('stock_minimum'))
            ->where('stock_minimum', '>', 0)
            ->count();

        $stockTotal = GestionImprimerie::sum('stock_actuel');
        $stockMinimal = GestionImprimerie::sum('stock_minimum');
        $tauxRemplissage = $stockMinimal > 0 ? round(($stockTotal / $stockMinimal) * 100, 1) : 0;

        return [
            Stat::make('Total mouvements', $totalMouvements)
                ->description('Entrées et sorties')
               
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

           
        ];
    }

    protected function getMouvementsChartData(): array
    {
        return [15, 22, 18, 25, 30, 28, 35];
    }
}