<?php

namespace App\Filament\Resources\Caisses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Models\Commande;

class CaisseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // Section 1 : Choix de la commande
                Section::make('Commande')
                    ->schema([
                        Select::make('commande_id')
                            ->relationship('commande', 'numero_commande')
                            ->label('Commande')
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $commande = Commande::with('client')->find($state);

                                    if ($commande) {
                                        $set('client_id', $commande->client_id);
                                        $set('user_id', $commande->user_id);
                                        $set('montant_ht', $commande->montant_ht);
                                        $set('montant_ttc', $commande->montant_ttc);
                                        $set('tva', 18.0);
                                    }
                                }
                            }),
                    ]),

                // Section 2 : Informations du client et de l'agent
                Section::make('Informations')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Agent')
                            ->required(),

                        Select::make('client_id')
                            ->relationship('client', 'nom')
                            ->label('Client')
                            ->required(),
                    ]),

                // Section 3 : Montants
                Section::make('Montants')
                    ->schema([
                        TextInput::make('montant_ht')
                            ->label('Montant HT')
                            ->required()
                            ->numeric(),

                        TextInput::make('tva')
                            ->label('TVA (%)')
                            ->required()
                            ->numeric()
                            ->default(18.0),

                        TextInput::make('montant_ttc')
                            ->label('Montant TTC')
                            ->required()
                            ->numeric(),
                    ]),
// Section 4 : Paiement
Section::make('Paiement')
    ->schema([
        TextInput::make('entree')
            ->label('Montant Entré')
            ->numeric()
            ->reactive()
            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                $montantTTC = $get('montant_ttc') ?? 0;

                // Calcul monnaie à rendre
                $set('sortie', max(0, $state - $montantTTC));

                // Mise à jour du statut
                if ($state >= $montantTTC && $montantTTC > 0) {
                    $set('statut_paiement', 'payé');
                } else {
                    $set('statut_paiement', 'impayé');
                }
            }),

        TextInput::make('sortie')
            ->label('Monnaie à rendre')
            ->numeric()
            ->disabled(),



    Select::make('statut_paiement')
    ->label('Statut paiement')
    ->options([
        'payé' => 'Payé',
        'impayé' => 'Impayé',
    ])
    ->default('impayé')
    ->disabled() // lecture seule
    ->dehydrated(true) // ⚡ forcé pour enregistrer en DB
    ->required()

    ]),

            ]);
    }
}
