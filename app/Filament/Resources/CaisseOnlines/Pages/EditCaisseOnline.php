<?php

namespace App\Filament\Resources\CaisseOnlines\Pages;

use App\Filament\Resources\CaisseOnlines\CaisseOnlineResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCaisseOnline extends EditRecord
{
    protected static string $resource = CaisseOnlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
