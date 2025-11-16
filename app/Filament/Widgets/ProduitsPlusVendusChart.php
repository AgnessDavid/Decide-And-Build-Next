<?php

namespace App\Filament\Widgets;

use App\Models\Produit;
use App\Models\MouvementStock;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProduitsPlusVendusChart extends ChartWidget
{
    protected ?string $heading = 'Top 10 des produits les plus vendus';

    protected function getData(): array
    {
        $produitsVendus = MouvementStock::select([
            'produit_id',
            DB::raw('SUM(quantite_sortie) as total_vendu'),
            DB::raw('COUNT(*) as nombre_ventes'),
        ])
            ->with('produit')
            ->sorties()
            ->where('date_mouvement', '>=', now()->subYear()) // 12 derniers mois
            ->groupBy('produit_id')
            ->having('total_vendu', '>', 0)
            ->orderBy('total_vendu', 'desc')
            ->limit(10)
            ->get();

        $labels = $produitsVendus->pluck('produit.nom_produit')->toArray();
        $quantites = $produitsVendus->pluck('total_vendu')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Quantité vendue',
                    'data' => $quantites,
                    'backgroundColor' => [
                        '#10B981',
                        '#059669',
                        '#047857',
                        '#065F46',
                        '#064E3B',
                        '#3B82F6',
                        '#2563EB',
                        '#1D4ED8',
                        '#1E40AF',
                        '#1E3A8A'
                    ],
                    'borderColor' => '#FFFFFF',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'PolarArea';
    }
}