<?php

namespace App\Filament\Widgets;

use App\Models\FicheBesoin;
use App\Models\DemandeExpressionBesoin;
use App\Models\DemandeImpression;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FicheBesoinStatsOverview extends BaseWidget
{

    /*
    protected function getStats(): array
    {
        $totalFiches = FicheBesoin::count();
        $totalQuantiteDemandee = FicheBesoin::sum('quantite_demandee');

        // Fiches avec demandes d'expression de besoin
        $fichesAvecExpression = FicheBesoin::has('DemandeExpressionBesoin')->count();

        // Fiches avec demandes d'impression
        $fichesAvecImpression = FicheBesoin::has('demandesImpression')->count();

        // Fiches livrées
        $fichesLivrees = FicheBesoin::has('livraisons')->count();

        $tauxExpression = $totalFiches > 0 ? round(($fichesAvecExpression / $totalFiches) * 100, 1) : 0;
        $tauxImpression = $totalFiches > 0 ? round(($fichesAvecImpression / $totalFiches) * 100, 1) : 0;
        $tauxLivraison = $totalFiches > 0 ? round(($fichesLivrees / $totalFiches) * 100, 1) : 0;

        return [
            Stat::make('Total des fiches', $totalFiches)
                ->description('Fiches de besoin créées')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart($this->getFichesChartData()),

                /*
            Stat::make('Expression de besoin', $fichesAvecExpression)
                ->description($tauxExpression . '% des fiches')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info'),

            Stat::make('Demandes d\'impression', $fichesAvecImpression)
                ->description($tauxImpression . '% des fiches')
                ->descriptionIcon('heroicon-m-printer')
                ->color('warning'),
*/
           // Stat::make('Fiches livrées', $fichesLivrees)
                //->description($tauxLivraison . '% des fiches')
                //->descriptionIcon('heroicon-m-truck')
                //->color('success'),
        //];
   // }
/*
  protected function getFichesChartData(): array
    {
        return [5, 12, 8, 15, 20, 25, 18, 22, 30, 28, 35, 32];
  }
        */


}