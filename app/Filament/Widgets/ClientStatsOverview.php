<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Client;
use Filament\Widgets\StatsOverviewWidget\Card;

class ClientStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Utilisation des scopes pour compter par type
        $totalClients = Client::count();
        $societes = Client::societes()->count();
        $organismes = Client::organismes()->count();
        $particuliers = Client::particuliers()->count();
        
        // Par usage (si renseigné)
        $personnel = Client::where('usage', 'personnel')->count();
        $professionnel = Client::where('usage', 'professionnel')->count();
        
        // Exemple d'agrégation par ville (top 3 villes les plus courantes)
        $topVilles = Client::selectRaw('ville, COUNT(*) as count')
            ->groupBy('ville')
            ->orderBy('count', 'desc')
            ->limit(3)
            ->get();
        $villesCount = $topVilles->sum('count'); // Total pour les top villes

        return [
            Stat::make('Total Clients', $totalClients)
                ->description('Nombre total de clients')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart([5, 3, 8, 2, 7, 4, 6]), // Exemple de données pour sparkline (adaptez avec des données réelles si besoin)

            Stat::make('Sociétés', $societes)
                ->description('Clients de type société')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('success')
                ->chart([2, 4, 1, 5, 3, 6, 2]),

            Stat::make('Organismes', $organismes)
                ->description('Clients de type organisme')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('warning')
                ->chart([1, 3, 2, 4, 1, 5, 3]),

            Stat::make('Particuliers', $particuliers)
                ->description('Clients particuliers')
                ->descriptionIcon('heroicon-m-user')
                ->color('info')
                ->chart([3, 2, 5, 1, 4, 3, 6]),

            Stat::make('Usage Professionnel', $professionnel)
                ->description('Clients professionnels')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('success')
                ->chart([4, 5, 3, 6, 2, 7, 4]),

            Stat::make('Villes Principales', $villesCount)
                ->description('Clients dans les top 3 villes : ' . $topVilles->pluck('ville')->implode(', '))
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('secondary')
                ->chart([2, 3, 4, 1, 5, 2, 6]),
        ];
    }

    protected function getCards(): array
    {
        return []; // Optionnel : Ajoutez des cards personnalisées (e.g., pour un filtre par ville)
    }
}