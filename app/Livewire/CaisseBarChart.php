<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class CaisseBarChart extends ChartWidget
{
    protected ?string $heading = 'Caisse Bar Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
