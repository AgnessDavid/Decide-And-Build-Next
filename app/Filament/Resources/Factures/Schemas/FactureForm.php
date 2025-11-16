<?php

namespace App\Filament\Resources\Factures\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Models\Commande;

class FactureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section 1 : Informations générales
                Section::make('Informations générales')
                    ->schema([
                        Select::make('commande_id')
                            ->relationship('commande', 'numero_commande')
                            ->label('Commande')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $commande = Commande::with('client', 'user', 'produits.produit')->find($state);
                                    if ($commande) {
                                        $set('client_id', $commande->client_id);
                                        $set('user_id', $commande->user_id);
                                        $set('montant_ht', $commande->montant_ht);
                                        $set('tva', 18.0);
                                        $set('montant_ttc', $commande->montant_ttc);
                                        $set('notes', $commande->notes_internes);
                                    }
                                }
                            }),

                            
                        Select::make('client_id')
                            ->relationship('client', 'nom')
                            ->label('Client')
                            ->disabled()
                            ->dehydrated(false),

                        
Select::make('caisse_id')
    ->label('Caisse')
    ->relationship('caisse', 'id') // nom de la relation en minuscule + colonne à afficher
    ->getOptionLabelFromRecordUsing(fn($record) => "Caisse #{$record->id}") // personnaliser l'affichage
       // lecture seule
    ->dehydrated(false), // ne pas sauvegarder

                


                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Agent')
                            ->disabled()
                            ->dehydrated(false),

                        TextInput::make('numero_facture')
                            ->label('Numéro de facture')
                            ->required(),

                        DatePicker::make('date_facturation')
                            ->label('Date de facturation')
                            ->required(),

                     Select::make('statut_paiement')
    ->label('Statut paiement')
    ->options([
        'impayé' => 'Impayé',
        'payé' => 'Payé',
    ])
    ->afterStateHydrated(function ($state, $record, $set) {
        // Si la facture a une caisse associée
        if ($record?->caisse?->statut_paiement) {
            $set('statut_paiement', $record->caisse->statut_paiement);
        }
    }) 
    ->required(),


                    ])  ->columns(2),

                // Section 2 : Montants
                Section::make('Montants')
                    ->schema([
                        TextInput::make('montant_ht')
                            ->label('Montant HT')
                            ->disabled()
                            ->default(fn ($record) => $record?->montant_ht ?? 0)
                            ->required(),

                        TextInput::make('tva')
                            ->label('TVA (%)')
                            ->numeric()
                            ->disabled()
                            ->default(fn ($record) => $record?->tva ?? 0)
                            ->required(),

                        TextInput::make('montant_ttc')
                            ->label('Montant TTC')
                            ->disabled()
                            ->default(fn ($record) => $record?->montant_ttc ?? 0)
                            ->required(),
                    ]),

                // Section 3 : Produits commandés
                Section::make('Produits commandés')
                    ->schema([
                        Repeater::make('produits_lignes')
                            ->label('Produits')
                            ->schema([
                                TextInput::make('nom')->label('Produit')->disabled(),
                                TextInput::make('quantite')->label('Quantité')->disabled(),
                                TextInput::make('prix_unitaire_ht')->label('Prix unitaire HT')->disabled(),
                                TextInput::make('montant_ht')->label('Montant HT')->disabled(),
                                TextInput::make('montant_ttc')->label('Montant TTC')->disabled(),
                            ])
                            ->columns(3)
                            ->disabled()
                            ->dehydrated(false),
                    ]),

                // Section 4 : Notes internes
                Section::make('Notes')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notes')
                            ->disabled()
                            ->dehydrated(false),
                    ]),
            ]);
    }
}
