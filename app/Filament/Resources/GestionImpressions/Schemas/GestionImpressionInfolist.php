<?php

namespace App\Filament\Resources\GestionImpressions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class GestionImpressionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // Section Relations
                Section::make('Relations')
                    ->schema([
                        // ✅ Corrigé : utiliser les bons noms de relations
                        TextEntry::make('imprimerie.numero_impression')
                            ->label('N° Imprimerie'),

                        TextEntry::make('demandeImpression.designation')
                            ->label('Demande'),


                        TextEntry::make('numero_gestion')
                            ->label('N° Imprimerie')
                            ->badge()
                            ->color('success')
                            ->copyable()
                            ->copyMessage('Numéro copié!'),



                        TextEntry::make('produit.nom_produit')
                            ->label('Produit'),
                    ])
                    ->columns(3),

                // Section Détails du produit
                Section::make('Détails du produit')
                    ->schema([
                        TextEntry::make('nom_produit')
                            ->label('Nom du produit'),

                        TextEntry::make('quantite_demandee')
                            ->label('Quantité demandée')
                            ->numeric(),

                        TextEntry::make('quantite_imprimee')
                            ->label('Quantité imprimée')
                            ->numeric(),

                        TextEntry::make('type_impression')
                            ->label('Type d\'impression')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'simple' => 'success',
                                'specifique' => 'warning',
                                default => 'gray',
                            }),

                        TextEntry::make('statut')
                            ->label('Statut')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'terminee' => 'success',
                                'en_cours' => 'warning',
                                default => 'gray',
                            }),
                    ])
                    ->columns(3),

                // Section Dates
                Section::make('Dates')
                    ->schema([
                        TextEntry::make('date_demande')
                            ->label('Date de demande')
                            ->date('d/m/Y'),

                        TextEntry::make('date_impression')
                            ->label('Date d\'impression')
                            ->date('d/m/Y'),
                    ])
                    ->columns(2),

                // Section Informations supplémentaires
                Section::make('Informations supplémentaires')
                    ->schema([
                        TextEntry::make('valide_par')
                            ->label('Validé par'),

                        TextEntry::make('operateur')
                            ->label('Opérateur'),

                        TextEntry::make('agent_commercial')
                            ->label('Agent commercial'),

                        TextEntry::make('service')
                            ->label('Service'),

                        TextEntry::make('objet')
                            ->label('Objet')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // Section Métadonnées
                Section::make('Métadonnées')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime('d/m/Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Modifié le')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}