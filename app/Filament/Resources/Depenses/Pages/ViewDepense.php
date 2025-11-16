<?php

namespace App\Filament\Resources\Depenses\Pages;

use App\Filament\Resources\Depenses\DepenseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDepense extends ViewRecord
{
    protected static string $resource = DepenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
