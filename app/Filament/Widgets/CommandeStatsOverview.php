<?php

namespace App\Filament\Widgets;

use App\Models\CommandeOnline;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CommandeStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalCommandes = CommandeOnline::count();
        $chiffreAffaire = CommandeOnline::sum('total_ttc');
        $commandesEnCours = CommandeOnline::where('etat', 'en_cours')->count();
        $commandesLivrees = CommandeOnline::where('etat', 'livree')->count();

        return [
            Stat::make('Total Commandes', $totalCommandes)
                ->description('Toutes les commandes')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Chiffre d\'Affaire', number_format($chiffreAffaire, 2, ',', ' ') . ' FCFA')
                ->description('Total TTC')
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('success'),

            Stat::make('Commandes en Cours', $commandesEnCours)
                ->description('En attente de traitement')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Commandes Livrées', $commandesLivrees)
                ->description('Commandes terminées')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}