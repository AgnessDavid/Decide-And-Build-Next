<?php

namespace App\Filament\Resources\CaisseOnlines\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CaisseOnlineInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('commande.numero_commande')
                    ->numeric(),
                TextEntry::make('online.name')
                    ->label('Client')
                    ->numeric(),
                TextEntry::make('montant_ht')
                    ->numeric(),
                TextEntry::make('tva')
                    ->numeric(),
                TextEntry::make('montant_ttc')
                    ->numeric(),
                TextEntry::make('entree')
                    ->numeric(),
                TextEntry::make('sortie')
                    ->numeric(),
                TextEntry::make('statut_paiement'),
                TextEntry::make('methode_paiement'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
