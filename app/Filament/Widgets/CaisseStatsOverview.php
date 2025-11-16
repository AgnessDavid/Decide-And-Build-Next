<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Caisse;
use App\Models\SessionCaisse;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget\Card;

class CaisseStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Détection de la session actuelle (adaptez à votre logique, e.g., via auth ou session)
        $sessionId = session('current_session_caisse_id') ?? null;

        // Période par défaut : aujourd'hui (vous pouvez ajouter un filtre via un Select dans le dashboard si besoin)
        $startDate = Carbon::now()->startOfDay(); // Changez pour 'week' ou 'month' si fixe

        $query = Caisse::query();

        if ($sessionId) {
            $query->where('session_caisse_id', $sessionId);
        }

        $query->where('created_at', '>=', $startDate);

        $totalEntree = $query->sum('nombre_total_entree');
        $totalSortie = $query->sum('nombre_total_sortie');
        $totalPaye = $query->where('statut_paiement', 'payé')->count();
        $totalOperations = $query->count();
        $solde = $totalEntree - $totalSortie;

        return [
            Stat::make('Chiffre d\'affaires', number_format($totalEntree, 2) . ' FCFA ')
                ->description('Montant total des entrées')
 
                ->color('success')
                ->chart([7, 3, 10, 5, 8, 15, 12]), // Exemple de données pour un petit graphique (adaptez)

            Stat::make('Paiements Effectués', $totalPaye)
                ->description('Nombre de paiements "payé"')
                //->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([1, 2, 1, 3, 2, 4, 3]),

            Stat::make('Opérations Totales', $totalOperations)
                ->description('Nombre total d\'opérations')
                //->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart([3, 4, 2, 5, 3, 6, 4]),
        ];
    }

    protected function getCards(): array
    {
        return []; // Optionnel : Ajoutez des cards personnalisées si besoin
    }
}