<?php

namespace App\Filament\Resources\PaiementOnlines\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaiementOnlineInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('caisse_online_id')
                    ->numeric(),
                TextEntry::make('montant')
                    ->numeric(),
                TextEntry::make('mode_paiement'),
                TextEntry::make('statut'),
                TextEntry::make('reference_transaction'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('categorie'),
            ]);
    }
}
