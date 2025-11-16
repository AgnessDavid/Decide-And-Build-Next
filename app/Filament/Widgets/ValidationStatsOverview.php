<?php

namespace App\Filament\Widgets;

use App\Models\Validation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ValidationStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalValidations = Validation::count();
        $validationsApprouvees = Validation::where('statut', 'validée')->count();
        $validationsEnAttente = Validation::where('statut', 'en_attente')->count();
        $validationsRefusees = Validation::where('est_autorise_chef_informatique', false)->count();

        $tauxValidation = $totalValidations > 0
            ? round(($validationsApprouvees / $totalValidations) * 100, 1)
            : 0;

        return [
            Stat::make('Total validations', $totalValidations)
                ->description('Documents à valider')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('primary')
                ->chart($this->getValidationsChartData()),

            Stat::make('Validées', $validationsApprouvees)
                ->description($tauxValidation . '% du total')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('En attente', $validationsEnAttente)
                ->description('En cours de validation')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Refusées', $validationsRefusees)
                ->description('Documents non approuvés')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }

    protected function getValidationsChartData(): array
    {
        return [8, 12, 15, 18, 22, 25, 30];
    }
}