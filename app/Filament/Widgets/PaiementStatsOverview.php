<?php

namespace App\Filament\Widgets;

use App\Models\PaiementOnline;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaiementStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Paiements Total', PaiementOnline::count() . ' ')
                ->description('Total des paiements en ligne')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('success'),

            Stat::make('Paiements Réussis', PaiementOnline::where('statut', 'réussi')->count())
                ->description('Paiements validés')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Paiements En Attente', PaiementOnline::where('statut', 'en_attente')->count())
                ->description('En attente de traitement')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Paiements Échoués', PaiementOnline::where('statut', 'échoué')->count())
                ->description('Paiements refusés')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}