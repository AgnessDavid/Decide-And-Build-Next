<?php

namespace App\Filament\Resources\CommandeOnlines\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CommandeOnlineInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('online.name')
                    ->numeric(),
                
                TextEntry::make('numero_commande'),
                TextEntry::make('total_ht')
                    ->numeric(),
                TextEntry::make('total_ttc')
                    ->numeric(),
                TextEntry::make('etat'),
                TextEntry::make('statut_paiement'),
                TextEntry::make('date_commande')
                    ->dateTime(),
             /*   TextEntry::make('adresse_livraison_id')
                    ->numeric(),*/
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
