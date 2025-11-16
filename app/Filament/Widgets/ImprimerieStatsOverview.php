<?php

namespace App\Filament\Widgets;

use App\Models\Imprimerie;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ImprimerieStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalImpressions = Imprimerie::count();
        $impressionsTerminees = Imprimerie::where('statut', 'terminée')->count();
        $impressionsEnCours = Imprimerie::where('statut', 'en_cours')->count();

        $totalQuantiteDemandee = Imprimerie::sum('quantite_demandee');
        $totalQuantiteImprimee = Imprimerie::sum('quantite_imprimee');

        $tauxRealisation = $totalQuantiteDemandee > 0
            ? round(($totalQuantiteImprimee / $totalQuantiteDemandee) * 100, 1)
            : 0;

        return [
            Stat::make('Total impressions', $totalImpressions)
                ->description('Tâches d\'impression')
                ->descriptionIcon('heroicon-m-printer')
                ->color('primary')
                ->chart($this->getImpressionsChartData()),

            Stat::make('Impressions terminées', $impressionsTerminees)
                ->description(round(($impressionsTerminees / max($totalImpressions, 1)) * 100, 1) . '% du total')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('En cours', $impressionsEnCours)
                ->description('En production')
                ->descriptionIcon('heroicon-m-cog')
                ->color('warning'),

            Stat::make('Taux de réalisation', $tauxRealisation . '%')
                ->description(number_format($totalQuantiteImprimee, 0, ',', ' ') . ' / ' . number_format($totalQuantiteDemandee, 0, ',', ' '))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($tauxRealisation >= 80 ? 'success' : ($tauxRealisation >= 50 ? 'warning' : 'danger')),
        ];
    }

    protected function getImpressionsChartData(): array
    {
        return [10, 15, 12, 18, 22, 25, 30];
    }
}