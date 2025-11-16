<?php

namespace App\Filament\Resources\DemandeExpressionBesoins\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class DemandeExpressionBesoinForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section 1 : Produit et type d'impression
                Section::make('Produit et impression')
                    ->schema([
                        Select::make('produit_id')
                            ->relationship('produit', 'nom_produit')
                            ->label('Produit'),

                        Select::make('type_impression')
                            ->options([
                                'simple' => 'Simple',
                                'specifique' => 'Spécifique',
                            ])
                            ->default('simple')
                            ->required()
                            ->label('Type d’impression'),

                        TextInput::make('numero_ordre')
                            ->label('Numéro d’ordre'),
                    ]),

                // Section 2 : Détails de la demande
                Section::make('Détails de la demande')
                    ->schema([
                        TextInput::make('designation')
                            ->label('Désignation'),

                        TextInput::make('quantite_demandee')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Quantité demandée'),

                        TextInput::make('quantite_imprimee')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Quantité imprimée'),

                        DatePicker::make('date_demande')
                            ->label('Date de la demande'),
                    ]),

                // Section 3 : Informations complémentaires
                Section::make('Informations complémentaires')
                    ->schema([
                        TextInput::make('agent_commercial')
                            ->label('Agent commercial'),

                        TextInput::make('service')
                            ->label('Service'),

                        TextInput::make('objet')
                            ->label('Objet'),
                    ]),
            ]);
    }
}
