<?php

namespace App\Filament\Widgets;

use App\Models\DemandeExpressionBesoin;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TypeImpressionChart extends ChartWidget
{
    protected ?string $heading = 'Répartition par type d\'impression';

    protected function getData(): array
    {
        $types = DemandeExpressionBesoin::select([
            'type_impression',
            DB::raw('COUNT(*) as total_demandes'),
            DB::raw('SUM(quantite_demandee) as total_quantite_demandee'),
        ])
            ->groupBy('type_impression')
            ->get();

        $labels = $types->pluck('type_impression')->toArray();
        $data = $types->pluck('total_demandes')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Nombre de demandes',
                    'data' => $data,
                    'backgroundColor' => [
                        '#3B82F6',
                        '#10B981',
                        '#F59E0B',
                        '#EF4444',
                        '#8B5CF6',
                        '#EC4899',
                        '#06B6D4',
                        '#84CC16',
                        '#F97316',
                        '#6366F1'
                    ],
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}