<?php

namespace App\Filament\Widgets;

use App\Models\Produit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProduitStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalProduits = Produit::count();
        $totalStock = Produit::sum('stock_actuel');
        $valeurStockTotal = Produit::sum(\DB::raw('stock_actuel * prix_unitaire_ht'));

        // Produits avec stock faible
        $produitsStockFaible = Produit::whereColumn('stock_actuel', '<', 'stock_minimum')
            ->where('stock_minimum', '>', 0)
            ->count();

        // Produits avec stock excessif
        $produitsStockExcessif = Produit::whereColumn('stock_actuel', '>', 'stock_maximum')
            ->where('stock_maximum', '>', 0)
            ->count();

        return [
            Stat::make('Total des produits', $totalProduits)
                ->description('Cartes géographiques')
                ->descriptionIcon('heroicon-m-map')
                ->color('primary')
                ->chart($this->getProduitsChartData()),

            Stat::make('Stock total', number_format($totalStock, 0, ',', ' '))
                ->description('Unités en stock')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('info'),

            Stat::make('Valeur du stock', number_format($valeurStockTotal, 0, ',', ' ') . ' F CFA')
                ->description('Valeur totale HT')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make('Alertes stock', $produitsStockFaible)
                ->description($produitsStockExcessif . ' stocks excessifs')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($produitsStockFaible > 0 ? 'danger' : 'success'),
        ];
    }

    protected function getProduitsChartData(): array
    {
        return [15, 22, 18, 25, 30, 28, 35, 40, 38, 42, 45, 50];
    }
}