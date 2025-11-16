<?php

namespace App\Filament\Widgets;

use App\Models\DemandeExpressionBesoin;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ServiceDemandesChart extends ChartWidget
{
    protected ?string $heading = 'Demandes par service';

    protected function getData(): array
    {
        $services = DemandeExpressionBesoin::select([
            'service',
            DB::raw('COUNT(*) as total_demandes'),
            DB::raw('SUM(quantite_demandee) as total_quantite'),
        ])
            ->groupBy('service')
            ->orderBy('total_demandes', 'desc')
            ->limit(8)
            ->get();

        $labels = $services->pluck('service')->toArray();
        $data = $services->pluck('total_demandes')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Nombre de demandes',
                    'data' => $data,
                    'backgroundColor' => '#3B82F6',
                    'borderColor' => '#2563EB',
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