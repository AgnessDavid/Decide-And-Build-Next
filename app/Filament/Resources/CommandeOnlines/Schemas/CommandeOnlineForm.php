<?php

namespace App\Filament\Resources\CommandeOnlines\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CommandeOnlineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('online.name')
                    ->required()
                    ->numeric(),
                TextInput::make('numero_commande')
                    ->required(),
                TextInput::make('total_ht')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_ttc')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('etat')
                    ->options(['en_cours' => 'En cours', 'validee' => 'Validee', 'annulee' => 'Annulee'])
                    ->default('en_cours')
                    ->required(),
                Select::make('statut_paiement')
                    ->options(['impayé' => 'Impayé', 'partiellement payé' => 'Partiellement payé', 'payé' => 'Payé'])
                    ->default('impayé')
                    ->required(),
                DateTimePicker::make('date_commande')
                    ->required(),
                TextInput::make('adresse_livraison_id')
                    ->numeric(),
            ]);
    }
}
