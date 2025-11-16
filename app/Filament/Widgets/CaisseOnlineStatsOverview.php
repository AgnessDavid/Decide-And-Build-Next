<?php

namespace App\Filament\Widgets;

use App\Models\CaisseOnline;
use App\Models\Caisse;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CaisseOnlineStatsOverview extends BaseWidget
{

    
    protected function getStats(): array
    {


        $startDate = Carbon::now()->startOfDay();
        $query = Caisse::query();



        $totalOnline = CaisseOnline::sum('online_id');
        $totalMontant_ttc = CaisseOnline::sum('montant_ttc');
        $soldeActuel = $totalMontant_ttc;
        $soldeTotalActuel = $totalMontant_ttc + $query->sum('nombre_total_entree') ;
        $totalTransactions = CaisseOnline::count();

        return [
            Stat::make('Solde Actuel', number_format($soldeActuel, 2, ',', ' ') . ' FCFA')
                ->description('Solde de la caisse en ligne')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($soldeActuel >= 0 ? 'success' : 'danger'),


            Stat::make('Solde Actuel', number_format($soldeTotalActuel, 2, ',', ' ') . ' FCFA')
                ->description('Solde des caisses en ligne / physique')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($soldeTotalActuel >= 0 ? 'success' : 'danger'),


            Stat::make('Comandes en ligne', $totalOnline)
                ->description('Nombre total de comandes en ligne')
                ->descriptionIcon('heroicon-m-document-chart-bar')
                ->color('primary'),

            Stat::make('Transactions', $totalTransactions)
                ->description('Nombre total d\'opérations')
                ->descriptionIcon('heroicon-m-document-chart-bar')
                ->color('primary'),
        ];
    }
}