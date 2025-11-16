<?php

namespace App\Filament\Resources\Imprimeries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ImprimerieInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
         // TextEntry::make('demande.id')->label('ID Demande'),
        //  TextEntry::make('produit.nom_produit')->label('Produit'),
            TextEntry::make('nom_produit')->label('Nom produit'),
            TextEntry::make('type_impression')->label('Type de production'),
            TextEntry::make('numero_impression')->label('N° impression'),
            TextEntry::make('quantite_demandee')->label('Quantité demandée'),
            TextEntry::make('quantite_imprimee')->label('Quantité imprimée'),
            TextEntry::make('agent_commercial')->label('Agent commercial'),
            TextEntry::make('service')->label('Service'),
            TextEntry::make('objet')->label('Objet'),
            TextEntry::make('date_demande')->label('Date de demande')->date(),
            TextEntry::make('date_impression')->label('Date d’impression')->date(),
            TextEntry::make('statut')->label('Statut de production'),
        ]);
    }
}
