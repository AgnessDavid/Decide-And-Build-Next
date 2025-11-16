<?php

namespace App\Filament\Resources\MouvementStocks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MouvementStockInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Produit associé
                TextEntry::make('produit.nom_produit')
                    ->label('Produit'),
                
                     

                Textentry::make('imprimerie_id')
                ->label('Imprimerie'),    
                // Date du mouvement
                TextEntry::make('date_mouvement')
                    ->label('Date du mouvement')
                    ->date(),

                // Numéro du bon
                TextEntry::make('numero_bon')
                    ->label('Numéro du bon'),

                // Type de mouvement avec badge
                TextEntry::make('type_mouvement')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state) => match($state) {
                        'entree' => 'success',    // Vert
                        'sortie' => 'danger',     // Rouge
                        default => 'gray',
                    }),

                // Quantités selon type
                TextEntry::make('quantite_entree')
                    ->numeric()
                    ->label('Quantité entrée'),

                TextEntry::make('quantite_sortie')
                    ->numeric()
                    ->label('Quantité sortie'),

                  
                // Stock actuel et stock restant
                TextEntry::make('produit.stock_actuel')
                    ->numeric()
                    ->label('Stock actuel'),

             TextEntry::make('stock_resultant')
                 ->numeric()
                 ->label('Stock restant'),

                // Dates de création et de mise à jour
                TextEntry::make('created_at')
                    ->label('Créé le')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Mis à jour le')
                    ->dateTime(),

                // Détails supplémentaires
                TextEntry::make('details')
                    ->label('Détails')
                    ->wrap(),
            ]);
    }
}
