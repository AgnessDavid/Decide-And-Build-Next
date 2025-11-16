<?php

namespace App\Filament\Widgets;

use App\Models\Facture;
use App\Models\Caisse;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
class FactureStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $startDate = Carbon::now()->startOfDay();
        $query = Caisse::query();

        $query->where('created_at', '>=', $startDate);

        $totalFactures = Facture::count();
        $totalMontantTTC = Facture::sum('montant_ttc');
        $totalEntree = $query->sum('nombre_total_entree');
        $facturesPayees = Facture::where('statut_paiement', 'payé')->count();
        $facturesImpayees = Facture::where('statut_paiement', 'impayé')->count();

        $tauxPaiement = $totalFactures > 0 ? round(($facturesPayees / $totalFactures) * 100, 1) : 0;

        return [
            Stat::make('Total des factures', $totalFactures)
                ->description('Nombre total de factures')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart($this->getFacturesChartData()),

            Stat::make('Chiffre d\'affaires', number_format($totalEntree, 2) . ' FCFA ')
                ->description('Montant total des entrées')

                ->color('success')
                ->chart([7, 3, 10, 5, 8, 15, 12]), // Exemple de données pour un petit graphique (adaptez)


    

            Stat::make('Factures payées', $facturesPayees)
                ->description($tauxPaiement . '% du total')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Factures impayées', $facturesImpayees)
                ->description(($totalFactures > 0 ? round(($facturesImpayees / $totalFactures) * 100, 1) : 0) . '% du total')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }

    protected function getFacturesChartData(): array
    {
        return [5, 8, 12, 10, 15, 18, 20];
    }
}