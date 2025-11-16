<?php

namespace App\Filament\Resources\Livraisons\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LivraisonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('fiche_besoin_id')
                    ->relationship('ficheBesoin', 'id')
                    ->required(),
                Select::make('produit_id')
                    ->relationship('produit', 'nom_produit'),
                TextInput::make('quantite_demandee')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('quantite_delivree')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('livreur'),
                DatePicker::make('date_livraison'),
                Select::make('statut')
                    ->options([
            'en_attente' => 'En attente',
            'en_cours' => 'En cours',
            'livree' => 'Livree',
            'incomplete' => 'Incomplete',
        ])
                    ->default('en_attente')
                    ->required(),
                Textarea::make('observation')
                    ->columnSpanFull(),
            ]);
    }
}
