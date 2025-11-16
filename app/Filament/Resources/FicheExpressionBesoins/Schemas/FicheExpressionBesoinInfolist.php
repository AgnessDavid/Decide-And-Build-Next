<?php

namespace App\Filament\Resources\FicheExpressionBesoins\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FicheExpressionBesoinInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('nom_structure')->label('Nom de la structure'),
            TextEntry::make('type_structure')->label('Type de structure'),
            TextEntry::make('nom_interlocuteur')->label('Nom de l’interlocuteur'),
            TextEntry::make('fonction')->label('Fonction'),

            TextEntry::make('telephone')->label('Téléphone'),
            TextEntry::make('cellulaire')->label('Cellulaire'),
            TextEntry::make('fax')->label('Fax'),
            TextEntry::make('email')->label('Email'),

            TextEntry::make('nom_agent_bnetd')->label('Nom de l’agent BNETD'),
            TextEntry::make('date_entretien')->label('Date de l’entretien'),
            TextEntry::make('objectifs_vises')->label('Objectifs visés'),

            TextEntry::make('commande_ferme')->label('Commande fermée'),
            TextEntry::make('demande_facture_proforma')->label('Demande de facture proforma'),

            TextEntry::make('delai_souhaite')->label('Délai souhaité'),
            TextEntry::make('date_livraison_prevue')->label('Date de livraison prévue'),
            TextEntry::make('date_livraison_reelle')->label('Date de livraison réelle'),

            TextEntry::make('signature_client')->label('Signature client'),
            TextEntry::make('signature_agent_bnetd')->label('Signature agent BNETD'),

           TextEntry::make('produit_souhaite')->label('Produit souhaité'),
       
        ]);
    }
}
