<?php

namespace App\Filament\Widgets;

use App\Models\GestionImpression;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GestionImpressionStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalImpressions = GestionImpression::count();
        $totalQuantiteDemandee = GestionImpression::sum('quantite_demandee');
        $totalQuantiteImprimee = GestionImpression::sum('quantite_imprimee');

        $impressionsTerminees = GestionImpression::where('statut', 'terminé')->count();
        $impressionsEnCours = GestionImpression::where('statut', 'en cours')->count();
        $impressionsEnAttente = GestionImpression::where('statut', 'en attente')->count();

        $tauxRealisation = $totalQuantiteDemandee > 0
            ? round(($totalQuantiteImprimee / $totalQuantiteDemandee) * 100, 1)
            : 0;

        return [
            Stat::make('Total des impressions', $totalImpressions)
                ->description('Tâches d\'impression')
                ->descriptionIcon('heroicon-m-printer')
                ->color('primary')
                ->chart($this->getImpressionsChartData()),

            Stat::make('Impressions terminées', $impressionsTerminees)
                ->description(round(($impressionsTerminees / max($totalImpressions, 1)) * 100, 1) . '% du total')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('En cours', $impressionsEnCours)
                ->description('Impressions en production')
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
        return [8, 12, 15, 18, 22, 25, 20];
    }
}