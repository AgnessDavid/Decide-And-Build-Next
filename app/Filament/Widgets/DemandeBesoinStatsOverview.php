<?php

namespace App\Filament\Widgets;

use App\Models\DemandeExpressionBesoin;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DemandeBesoinStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalDemandes = DemandeExpressionBesoin::count();
        $totalQuantiteDemandee = DemandeExpressionBesoin::sum('quantite_demandee');
        $totalQuantiteImprimee = DemandeExpressionBesoin::sum('quantite_imprimee');
        $tauxImpression = $totalQuantiteDemandee > 0
            ? round(($totalQuantiteImprimee / $totalQuantiteDemandee) * 100, 1)
            : 0;

        return [
            Stat::make('Total des demandes', $totalDemandes)
                ->description('Demandes enregistrées')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart($this->getDemandesChartData()),

            Stat::make('Quantité demandée', number_format($totalQuantiteDemandee, 0, ',', ' '))
                ->description('Total des quantités demandées')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),

            Stat::make('Quantité imprimée', number_format($totalQuantiteImprimee, 0, ',', ' '))
                ->description($tauxImpression . '% du total demandé')
                ->descriptionIcon('heroicon-m-printer')
                ->color('success'),

            Stat::make('Taux d\'impression', $tauxImpression . '%')
                ->description('Progression de l\'impression')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($tauxImpression >= 80 ? 'success' : ($tauxImpression >= 50 ? 'warning' : 'danger')),
        ];
    }

    protected function getDemandesChartData(): array
    {
        return [5, 8, 12, 10, 15, 18, 20];
    }
}