<?php

namespace App\Filament\Resources\ValidationFicheExpressionBesoins\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ValidationFicheExpressionBesoinInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ficheBesoin.nom_fiche_besoin')
                ->label('Fiche de besoin'),

                TextEntry::make('user.name')
                    ->label('Utilisateur'),

               // TextEntry::make('Produit.nom_produit')
                 //   ->label('Nom du produit'),


                IconEntry::make('valide')
                    ->boolean(),
               
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
