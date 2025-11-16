<?php

namespace App\Filament\Widgets;

use App\Models\Commande;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsCommandesWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Récupérer les données du modèle Commande
        $totalCommandes = Commande::count(); // Nombre total de commandes
        $commandesPayees = Commande::where('statut_paiement', 'paye')->count(); // Commandes payées
        $montantTotalTTC = Commande::sum('montant_ttc'); // Somme des montants TTC (via accessor)
        $commandesRecentes = Commande::where('date_commande', '>=', now()->subDays(7))->count(); // Commandes de la semaine

        return [
            // Stat 1 : Total des commandes
            Stat::make('Total Commandes', $totalCommandes)
                ->description('Toutes les commandes créées')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),

        
            // Stat 4 : Commandes récentes
            Stat::make('Commandes Semaine', $commandesRecentes)
                ->description('Nouvelles commandes')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }

    // Optionnel : Ajouter un lien vers la page de liste des commandes
    protected function getViewData(): array
    {
        return [
            'commandesUrl' => route('filament.admin.resources.commandes.index'), // Assurez-vous d'avoir une Resource pour Commande
        ];
    }
}
