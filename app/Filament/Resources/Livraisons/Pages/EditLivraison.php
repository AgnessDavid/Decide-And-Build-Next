<?php

namespace App\Filament\Resources\Livraisons\Pages;

use App\Filament\Resources\Livraisons\LivraisonResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLivraison extends EditRecord
{
    protected static string $resource = LivraisonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
