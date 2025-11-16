<?php

namespace App\Filament\Resources\CommandeOnlines\Pages;

use App\Filament\Resources\CommandeOnlines\CommandeOnlineResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCommandeOnline extends EditRecord
{
    protected static string $resource = CommandeOnlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
