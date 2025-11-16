<?php

namespace App\Filament\Resources\Livraisons\Pages;

use App\Filament\Resources\Livraisons\LivraisonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLivraisons extends ListRecords
{
    protected static string $resource = LivraisonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
