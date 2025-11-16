<?php

namespace App\Filament\Resources\DemandeExpressionBesoins\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DemandeExpressionBesoinInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('produit.id'),
                TextEntry::make('type_impression'),
                TextEntry::make('numero_ordre'),
                TextEntry::make('designation'),
                TextEntry::make('quantite_demandee')
                    ->numeric(),
                TextEntry::make('quantite_imprimee')
                    ->numeric(),
                TextEntry::make('date_demande')
                    ->date(),
                TextEntry::make('agent_commercial'),
                TextEntry::make('service'),
                TextEntry::make('objet'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
