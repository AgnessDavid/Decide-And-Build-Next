<?php

namespace App\Filament\Resources\DemandeProductions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DemandeProductionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('type_impression')->label('Type de production'),
            TextEntry::make('produit.nom_produit')->label('Produit')->default('-'),
           
            TextEntry::make('numero_ordre')->label('Numéro d\'ordre'),
            TextEntry::make('designation')->label('Désignation'),
            TextEntry::make('quantite_demandee')->label('Quantité demandée'),
            TextEntry::make('quantite_imprimee')->label('Quantité produite'),
            TextEntry::make('date_demande')->label('Date de demande'),
            TextEntry::make('date_impression')->label('Date production'),
            TextEntry::make('agent_commercial')->label('Agent commercial')->default('-'),
            TextEntry::make('service')->label('Service concerné')->default('-'),
            TextEntry::make('objet')->label('Objet')->default('-'),
        ]);
    }
}
