<?php

namespace App\Filament\Resources\ImprimerieExpressionBesoins\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class ImprimerieExpressionBesoinForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // Section 1 : Demande d'expression de besoin
            Section::make('Demande d\'expression de besoin')
                ->schema([
                    Select::make('demande_expression_besoin_id')
                        ->label('Demande d\'expression de besoin')
                        ->relationship('demandeExpressionBesoin', 'id')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, $set) {
                            if ($state) {
                                $demande = \App\Models\DemandeExpressionBesoin::with('produit')->find($state);
                                if ($demande) {
                                    $set('produit_id', $demande->produit_id);
                                    $set('nom_produit', $demande->produit?->nom_produit);
                                    $set('quantite_demandee', $demande->quantite_demandee);
                                    $set('Nom agent_informatique', $demande->agent_commercial);
                                    $set('service', $demande->service);
                                    $set('objet', $demande->objet);
                                    $set('date_demande', $demande->date_demande);
                                    $set('type_impression', $demande->type_impression);
                                }
                            }
                        }),
                    Select::make('produit_id')->relationship('produit', 'id'),
                    TextInput::make('nom_produit'),
                    TextInput::make('quantite_demandee')->numeric()->default(0),
                    TextInput::make('quantite_imprimee')->numeric()->default(0),
                   
                    TextInput::make('numero_imprimerie_expression')
                        ->label('Numéro d\'imprimerie')
                        ->disabled() // ✅ En lecture seule car généré automatiquement
                        ->dehydrated(false), // ✅ Ne pas envoyer lors de la soumission
                ]),

            // Section 2 : Validation et opérateur
            Section::make('Validation & Opérateur')
                ->schema([
                    TextInput::make('valide_par')->label('Validé par'),
                    TextInput::make('operateur')->label('Opérateur'),
                    DatePicker::make('date_impression')->label('Date d\'impression'),
                ]),

            // Section 3 : Type et statut
            Section::make('Type & Statut')
                ->schema([
                    Select::make('type_impression')
                        ->label('Type d\'impression')
                        ->options(['simple' => 'Simple', 'specifique' => 'Spécifique'])
                        ->required(),
                    Select::make('statut')
                        ->label('Statut')
                        ->options(['en_cours' => 'En cours', 'terminee' => 'Terminee'])
                        ->default('en_cours'),
                ]),

            // Section 4 : Informations complémentaires
            Section::make('Informations complémentaires')
                ->schema([
                    TextInput::make('Nom agent_informatique'),
                    TextInput::make('service'),
                    TextInput::make('objet'),
                    DatePicker::make('date_demande'),
                ]),
        ]);
    }
}
