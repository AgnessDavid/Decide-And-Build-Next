<?php

namespace App\Filament\Resources\GestionImprimeries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GestionImprimerieInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextEntry::make('produit.id'),
                TextEntry::make('designation'),

                TextEntry::make('quantite_entree')
                    ->numeric(),
                TextEntry::make('quantite_sortie')
                    ->numeric(),
                TextEntry::make('date_mouvement')
                    ->date(),
                TextEntry::make('numero_impremerie_gestion'),
                TextEntry::make('type_mouvement'),
                TextEntry::make('stock_resultant')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('imprimeries_expression_besoin_id')
                    ->numeric(),
                TextEntry::make('quantite_demandee')
                    ->numeric(),
                TextEntry::make('quantite_imprimee')
                    ->numeric(),
                TextEntry::make('stock_minimum')
                    ->numeric(),
                TextEntry::make('stock_maximum')
                    ->numeric(),
                TextEntry::make('stock_actuel')
                    ->numeric(),
            ]);
    }
}
