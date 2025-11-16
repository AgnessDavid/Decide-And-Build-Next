<?php

namespace App\Filament\Widgets;

use App\Models\Caisse;
use Filament\Widgets\ChartWidget;

class CaissePieChart extends ChartWidget
{
    protected ?string $heading = 'Répartition entrées/sorties';

    protected function getData(): array
    {
        $totalEntree = Caisse::sum('nombre_total_entree');
        $totalSortie = Caisse::sum('nombre_total_sortie');

        return [
            'datasets' => [
                [
                    'label' => 'Montants (F CFA)',
                    'data' => [$totalEntree, $totalSortie],
                    'backgroundColor' => [
                        '#10B981', // Vert pour entrées
                        '#EF4444', // Rouge pour sorties
                    ],
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => ['Entrées', 'Sorties'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // ou 'pie' pour un camembert classique
    }
}