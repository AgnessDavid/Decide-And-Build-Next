<?php

namespace App\Filament\Pages;


use Filament\Pages\Dashboard as BaseDashboard;

// use App\Filament\Widgets\CaisseBarChart;
class Dashboard extends BaseDashboard
{

    // Désactiver les widgets sur le dashboard
    public function getWidgets(): array
    {
        return [];
    }

    // Optionnel : désactiver aussi l'en-tête
    protected function getHeaderWidgets(): array
    {
        return [];
    }



}