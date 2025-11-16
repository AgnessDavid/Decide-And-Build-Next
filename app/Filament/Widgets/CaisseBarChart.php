<?php

namespace App\Filament\Widgets;

use App\Models\Caisse;
use Filament\Widgets\ChartWidget;

class CaisseBarChart extends ChartWidget
{
    // CORRECTION : Supprimer "static"
    protected ?string $heading = 'Totaux des mouvements de caisse';

    // CORRECTION : Supprimer "static"
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $totalEntree = Caisse::sum('nombre_total_entree');
        $totalSortie = Caisse::sum('nombre_total_sortie');
        $solde = $totalEntree - $totalSortie;

        return [
            'datasets' => [
                [
                    'label' => 'Montants (F CFA)',
                    'data' => [$totalEntree, $totalSortie, $solde],
                    'backgroundColor' => [
                        '#10B981', // Vert pour entrées
                        '#EF4444', // Rouge pour sorties  
                        '#3B82F6', // Bleu pour solde
                    ],
                ],
            ],
            'labels' => ['Entrées', 'Sorties', 'Solde'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}