<?php

namespace App\Filament\Widgets;

use App\Models\DemandeImpression;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DemandeImpressionStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalDemandes = DemandeImpression::count();
        $totalQuantiteDemandee = DemandeImpression::sum('quantite_demandee');
        $totalQuantiteImprimee = DemandeImpression::sum('quantite_imprimee');

        $demandesAutorisees = DemandeImpression::where('est_autorise_chef_informatique', true)->count();
        $demandesEnAttente = DemandeImpression::whereNull('est_autorise_chef_informatique')->count();

        $tauxImpression = $totalQuantiteDemandee > 0
            ? round(($totalQuantiteImprimee / $totalQuantiteDemandee) * 100, 1)
            : 0;

        return [
            Stat::make('Total des demandes', $totalDemandes)
                ->description('Demandes d\'impression')
                ->descriptionIcon('heroicon-m-printer')
                ->color('primary')
                ->chart($this->getDemandesChartData()),
/*
            Stat::make('Demandes autorisées', $demandesAutorisees)
                ->description(round(($demandesAutorisees / max($totalDemandes, 1)) * 100, 1) . '% du total')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('En attente', $demandesEnAttente)
                ->description('En attente d\'autorisation')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Taux d\'impression', $tauxImpression . '%')
                ->description(number_format($totalQuantiteImprimee, 0, ',', ' ') . ' / ' . number_format($totalQuantiteDemandee, 0, ',', ' '))
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($tauxImpression >= 80 ? 'success' : ($tauxImpression >= 50 ? 'warning' : 'danger')),
                */
        ];
    }

    protected function getDemandesChartData(): array
    {
        return [3, 7, 12, 8, 15, 20, 18];
    }
}