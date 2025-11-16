<?php

namespace App\Filament\Resources\Livraisons\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LivraisonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ficheBesoin.id'),
                TextEntry::make('produit.id'),
                TextEntry::make('quantite_demandee')
                    ->numeric(),
                TextEntry::make('quantite_delivree')
                    ->numeric(),
                TextEntry::make('livreur'),
                TextEntry::make('date_livraison')
                    ->date(),
                TextEntry::make('statut'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
