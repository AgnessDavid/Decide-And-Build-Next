<?php

namespace App\Filament\Resources\Imprimeries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Models\DemandeProduction;
use App\Models\Produit;
use App\Models\DemandeImpression;

class ImprimerieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // Section 1 : Sélection de la demande
            Section::make('Demande de production')
                ->schema([
                    Select::make('demande_id')
                        ->label('Demande de production')
                        ->options(function () {
                            return DemandeImpression::pluck('designation', 'id');
                        })
                        ->reactive()
                        ->afterStateUpdated(function ($set, $state) {
                            $demande = DemandeImpression::find($state);
                            if ($demande) {
                                $set('produit_id', $demande->produit_id);
                                $set('nom_produit', $demande->designation);
                                $set('type_impression', $demande->type_impression);
                                $set('quantite_demandee', $demande->quantite_demandee);
                                $set('agent_commercial', $demande->agent_commercial);
                                $set('service', $demande->service);
                                $set('objet', $demande->objet);
                                $set('date_demande', $demande->date_demande);
                            }
                        })
                        ->required(),
/*
                    Select::make('produit_id')
                        ->label('Produit')
                        ->relationship('produit', 'nom_produit')
                        ->disabled(),
*/

                    TextInput::make('nom_produit')
                        ->label('Nom du produit')
                        ->disabled(),

                    Select::make('type_impression')
                        ->label('Type de production')
                        ->options([
                            'simple' => 'Simple',
                            'specifique' => 'Spécifique',
                        ])
                        ->disabled(),

                    TextInput::make('quantite_demandee')
                        ->label('Quantité demandée')
                        ->disabled(),

                    TextInput::make('numero_impression')
                        ->label('Numéro d’impression')
                        ->disabled(),


                    TextInput::make('agent_commercial')
                        ->label('Agent commercial')
                        ->disabled(),

                    TextInput::make('service')
                        ->label('Service')
                        ->disabled(),

                    TextInput::make('objet')
                        ->label('Objet')
                        ->disabled(),

                    DatePicker::make('date_demande')
                        ->label('Date de demande')
                        ->disabled(),
                ]),

            // Section 2 : Production
            Section::make('Production')
                ->schema([
                    TextInput::make('quantite_imprimee')
                        ->label('Quantité imprimée')
                        ->numeric()
                        ->required(),
/*
                    TextInput::make('valide_par')
                        ->label('Validé par')
                        ->disabled(),
*/
                    DatePicker::make('date_impression')
                        ->label('Date d’impression')
                        ->default(now()),

                    Select::make('statut')
                        ->label('Statut de production')
                        ->options([
                            'en_cours' => 'En cours',
                            'terminee' => 'Terminée',
                        ])
                        ->required(),
                ]),
        ]);
    }
}
