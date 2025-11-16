<?php

namespace App\Filament\Widgets;

use App\Models\Depense;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DepenseStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalDepenses = Depense::sum('montant');
        $nombreDepenses = Depense::count();
        $moyenneDepenses = Depense::avg('montant') ?? 0;
        $dernierMontantTotal = Depense::latest('id')->value('montant_total') ?? 0;

        return [
            Stat::make('Total des dépenses', number_format($totalDepenses, 0, ',', ' ') . ' F CFA')
                ->description('Somme de toutes les dépenses')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('danger')
                ->chart($this->getDepensesChartData()),

            Stat::make('Nombre de dépenses', $nombreDepenses)
                ->description('Total des dépenses enregistrées')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Moyenne par dépense', number_format($moyenneDepenses, 0, ',', ' ') . ' F CFA')
                ->description('Montant moyen par dépense')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('info'),

            Stat::make('Montant total cumulé', number_format($dernierMontantTotal, 0, ',', ' ') . ' F CFA')
                ->description('Dernier montant total enregistré')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),
        ];
    }

    protected function getDepensesChartData(): array
    {
        // Données fictives pour le graphique
        return [50000, 75000, 60000, 90000, 80000, 120000, 110000];
    }
}