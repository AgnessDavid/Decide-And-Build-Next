<?php

namespace App\Filament\Widgets;

use App\Models\ValidationFicheExpressionBesoin;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ValidationFicheStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalValidations = ValidationFicheExpressionBesoin::count();
        $validationsValidees = ValidationFicheExpressionBesoin::where('valide', true)->count();
        $validationsEnAttente = ValidationFicheExpressionBesoin::where('valide', false)->count();
        $validationsAvecCommentaire = ValidationFicheExpressionBesoin::whereNotNull('commentaire')->count();

        $tauxValidation = $totalValidations > 0
            ? round(($validationsValidees / $totalValidations) * 100, 1)
            : 0;

        return [
            Stat::make('Total validations', $totalValidations)
                ->description('Fiches à valider')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('primary')
                ->chart($this->getValidationsChartData()),

            Stat::make('Fiches validées', $validationsValidees)
                ->description($tauxValidation . '% du total')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('En attente', $validationsEnAttente)
                ->description('En cours de validation')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Avec commentaires', $validationsAvecCommentaire)
                ->description(round(($validationsAvecCommentaire / max($totalValidations, 1)) * 100, 1) . '% du total')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('info'),
        ];
    }

    protected function getValidationsChartData(): array
    {
        return [5, 8, 12, 10, 15, 18, 20, 22, 25, 28, 30, 32];
    }
}