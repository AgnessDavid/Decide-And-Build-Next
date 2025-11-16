<?php

namespace App\Filament\Resources\GestionImpressions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Models\Imprimerie;

class GestionImpressionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // Section 1 : Sélection de l'imprimerie et de la demande
                Section::make('Informations de base')
                    ->schema([
                        Select::make('imprimerie_id')
                            ->relationship('imprimerie', 'id')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $imprimerie = Imprimerie::find($state);

                                    if ($imprimerie) {
                                        // ✅ Corrigé : demande_impression_id au lieu de demande_id
                                        $set('demande_impression_id', $imprimerie->demande_impression_id);
                                        $set('produit_id', $imprimerie->produit_id);
                                        $set('nom_produit', $imprimerie->nom_produit);
                                        $set('quantite_demandee', $imprimerie->quantite_demandee);
                                        $set('quantite_imprimee', $imprimerie->quantite_imprimee ?? 0);
                                        $set('type_impression', $imprimerie->type_impression);
                                        $set('statut', $imprimerie->statut ?? 'en_cours');
                                        $set('date_impression', $imprimerie->date_impression);
                                        $set('date_demande', $imprimerie->date_demande);
                                        $set('valide_par', $imprimerie->valide_par);
                                        $set('operateur', $imprimerie->operateur);
                                        $set('agent_commercial', $imprimerie->agent_commercial);
                                        $set('service', $imprimerie->service);
                                        $set('objet', $imprimerie->objet);
                                    }
                                }
                            }),

                        // ✅ Corrigé : demandeImpression au lieu de demande
                        Select::make('demande_impression_id')
                            ->relationship('demandeImpression', 'designation') // ou 'nom_demandes'
                            ->label('Demande d\'impression')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('produit_id')
                            ->relationship('produit', 'nom_produit')
                            ->label('Produit')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ]),

                // Section 2 : Détails du produit
                Section::make('Détails du produit')
                    ->schema([
                        TextInput::make('nom_produit')
                            ->label('Nom du produit')
                            ->required(),

                        TextInput::make('numero_gestion')
                            ->label('Numéro de gestion')
                            ->disabled() // ✅ En lecture seule car généré automatiquement
                            ->dehydrated(false), // ✅ Ne pas envoyer lors de la soumission


                        TextInput::make('quantite_demandee')
                            ->label('Quantité demandée')
                            ->required()
                            ->numeric()
                            ->default(0),

                        TextInput::make('quantite_imprimee')
                            ->label('Quantité imprimée')
                            ->numeric()
                            ->default(0),

                        Select::make('type_impression')
                            ->label('Type d\'impression')
                            ->options(['simple' => 'Simple', 'specifique' => 'Spécifique'])
                            ->required()
                            ->default('simple'),

                        Select::make('statut')
                            ->label('Statut')
                            ->options([
                                'en_cours' => 'En cours',
                                'terminee' => 'Terminée',
                            ])
                            ->default('en_cours')
                            ->required(),
                    ]),

                // Section 3 : Dates importantes
                Section::make('Dates')
                    ->schema([
                        DatePicker::make('date_demande')
                            ->label('Date de demande'),

                        DatePicker::make('date_impression')
                            ->label('Date d\'impression')
                            ->default(now()),
                    ]),

                // Section 4 : Informations supplémentaires
                Section::make('Informations supplémentaires')
                    ->schema([
                        TextInput::make('valide_par')
                            ->label('Validé par'),

                        TextInput::make('operateur')
                            ->label('Opérateur'),

                        TextInput::make('agent_commercial')
                            ->label('Agent commercial'),

                        TextInput::make('service')
                            ->label('Service'),

                        TextInput::make('objet')
                            ->label('Objet')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}