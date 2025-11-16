<?php

namespace App\Filament\Resources\Caisses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;


class CaisseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // Section 1 : Informations générales
                Section::make('Informations générales')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Utilisateur')
                     ,

                        TextEntry::make('commande.numero_commande')
                            ->label('Commande')
                        ,

                        TextEntry::make('client.nom')
                            ->label('Client')
                            ,
                    ]),

                // Section 2 : Montants
                Section::make('Montants')
                    ->schema([
                        TextEntry::make('montant_ht')
                            ->label('Montant HT')
                            ->numeric()
                            ->money('XOF', true),

                        TextEntry::make('tva')
                            ->label('TVA (%)')
                            ->numeric(),

                        TextEntry::make('montant_ttc')
                            ->label('Montant TTC')
                            ->numeric()
                            ->money('XOF', true),

                        TextEntry::make('entree')
                            ->label('Entrée')
                            ->numeric()
                            ->money('XOF', true),

                        TextEntry::make('sortie')
                            ->label('Sortie')
                            ->numeric()
                            ->money('XOF', true),
                    ]),

                // Section 3 : Paiement
                Section::make('Paiement')
                    ->schema([
                        TextEntry::make('statut_paiement')
                            ->label('Statut paiement')
                            ->badge(fn($state) => $state === 'payé' ? 'success' : 'danger'),
                    ]),

                // Section 4 : Dates
                Section::make('Dates')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Modifié le')
                            ->dateTime('d/m/Y H:i'),
                    ]),
            ]);
    }
}
