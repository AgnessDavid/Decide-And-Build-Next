<?php

namespace App\Filament\Resources\CaisseOnlines\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CaisseOnlineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('commande_online_id')
                    ->required()
                    ->numeric(),
                TextInput::make('online_id')
                    ->required()
                    ->numeric(),

              

                TextInput::make('montant_ht')
                    ->required()
                    ->numeric(),
                TextInput::make('tva')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('montant_ttc')
                    ->required()
                    ->numeric(),
                TextInput::make('entree')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('sortie')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('statut_paiement')
                    ->options(['impayé' => 'Impayé', 'partiellement payé' => 'Partiellement payé', 'payé' => 'Payé'])
                    ->default('impayé')
                    ->required(),
                Select::make('methode_paiement')
                    ->options(['carte' => 'Carte', 'paypal' => 'Paypal', 'mobile_money' => 'Mobile money', 'mixed' => 'Mixed']),
            ]);
    }
}
