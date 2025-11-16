<?php

namespace App\Filament\Resources\DemandeProductions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class DemandeProductionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // 🧾 Section 1 : Référence & Type
            Section::make('Type et produit')
                ->schema([
                   /* Select::make('fiche_besoin_id')
                        ->label('Fiche de besoin associée')
                        ->relationship('ficheBesoin', 'nom_fiche_besoin')
                        ->searchable()
                        ->preload()
                        ->nullable(),
*/
                    Select::make('type_impression')
                        ->label('Type de production')
                        ->options([
                            'simple' => 'Simple',
                            'specifique' => 'Spécifique',
                        ])
                        ->required(),

                    Select::make('produit_id')
                        ->label('Produit')
                        ->relationship('produit', 'nom_produit')
                        ->searchable()
                        ->required(fn($get) => $get('type_impression') === 'simple'),

                    TextInput::make('numero_ordre')
                        ->label('Numéro d\'ordre')
                        ->disabled()
                        ->default(function () {
                            $prefix = 'ORD-IMP-';
                            $count = \App\Models\DemandeImpression::count() + 1;
                            return $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);
                        }),
                ]),

            // 🧾 Section 2 : Détails de la demande
            Section::make('Détails de la demande')
                ->schema([
                    TextInput::make('designation')
                        ->label('Désignation')
                        ->required(),

                    TextInput::make('quantite_demandee')
                        ->label('Quantité demandée')
                        ->numeric()
                        ->required(),

                    TextInput::make('quantite_imprimee')
                        ->label('Quantité produite')
                        ->numeric()
                        ->default(0),

                    DatePicker::make('date_demande')
                        ->label('Date de la demande')
                        ->required(),

                    DatePicker::make('date_impression')
                        ->label('Date de production'),
                ]),

            // 👤 Section 3 : Responsable et service
            Section::make('Responsable et service')
                ->schema([
                    TextInput::make('agent_commercial')
                        ->label('Agent commercial')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $set('service', $state);
                        }),

                    Select::make('service')
                        ->label('Service concerné')
                        ->options([
                            'commercial' => 'Commercial',
                            'production' => 'Production',
                            'logistique' => 'Logistique',
                            'qualite' => 'Qualité',
                            'administration' => 'Administration',
                        ])
                        ->required()
                        ->default(fn($get) => $get('agent_commercial')),
                ]),

            // 🧾 Section 4 : Validation
            /*
            Section::make('Validation et autorisation')
                ->schema([
                    
                    DatePicker::make('date_visa_chef_service')
                        ->label('Date visa chef de service'),

                    TextInput::make('nom_visa_chef_service')
                        ->label('Nom du chef de service'),

                    DatePicker::make('date_autorisation')
                        ->label('Date d\'autorisation (Chef informatique)'),

                    TextInput::make('nom_visa_autorisateur')
                        ->label('Nom de l\'autorisateur'),

                    Select::make('est_autorise_chef_informatique')
                        ->label('Autorisation du chef informatique')
                        ->options([
                            0 => 'Non autorisé',
                            1 => 'Autorisé',
                        ])
                        ->default(0),

                    Select::make('statut')
                        ->label('Statut de la demande')
                        ->options([
                            'en_attente' => 'En attente',
                            'en_cours' => 'En cours',
                            'terminee' => 'Terminée',
                        ])
                        ->default('en_attente'),
                ]),
*/
            // 🧾 Section 5 : Objet / remarque
            Section::make('Objet et remarques')
                ->schema([
                    Textarea::make('objet')->label('Objet de la demande'),
                ]),
        ]);
    }
}
