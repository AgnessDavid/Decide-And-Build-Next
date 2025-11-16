<?php

namespace App\Filament\Widgets;

use App\Models\CommandeOnline;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CommandeRevenueChart extends ChartWidget
{
    protected ?string $heading = 'Évolution du Chiffre d\'Affaire';

    protected function getData(): array
    {
        $data = $this->getRevenueData();

        return [
            'datasets' => [
                [
                    'label' => 'Chiffre d\'affaire (FCFA)',
                    'data' => $data['values'],
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getRevenueData(): array
    {
        $revenues = DB::table('commande_online')
            ->select(
                DB::raw("TO_CHAR(date_commande, 'YYYY-MM') as period"),
                DB::raw("TO_CHAR(date_commande, 'FMMonth') as month"),
                DB::raw("SUM(total_ttc) as total")
            )
            ->where('date_commande', '>=', now()->subMonths(6))
            ->groupBy('period', 'month')
            ->orderBy('period')
            ->get()
            ->map(function ($item) {
                // Traduire le mois en français
                $item->month = $this->formatFrenchMonth($item->month);
                return $item;
            });

        // Créer un tableau pour tous les mois de l'année
        $monthlyData = array_fill(1, 12, 0);
        $monthLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

        foreach ($revenues as $revenue) {
            $monthNumber = date('n', strtotime($revenue->month));
            $monthlyData[$monthNumber] = $revenue->total;
        }

        return [
            'values' => array_values($monthlyData),
            'labels' => $monthLabels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    // ===================== AJOUT DE LA METHODE =====================
    protected function formatFrenchMonth(string $month): string
    {
        $months = [
            'January' => 'Janvier',
            'February' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre',
        ];

        return $months[$month] ?? $month;
    }
}
