<?php

namespace App\Filament\Resources\PaiementOnlines\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaiementOnlineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('caisse_online_id')
                    ->required()
                    ->numeric(),
                TextInput::make('montant')
                    ->required()
                    ->numeric(),
                Select::make('mode_paiement')
                    ->options([
            'carte' => 'Carte',
            'paypal' => 'Paypal',
            'mobile_money' => 'Mobile money',
            'especes' => 'Especes',
            'wave' => 'Wave',
            'moov_money' => 'Moov money',
            'mtn_money' => 'Mtn money',
            'orange_money' => 'Orange money',
            'bitcoin' => 'Bitcoin',
            'ethereum' => 'Ethereum',
        ])
                    ->required(),
                Select::make('statut')
                    ->options(['en_attente' => 'En attente', 'réussi' => 'Réussi', 'échoué' => 'Échoué'])
                    ->default('en_attente')
                    ->required(),
                TextInput::make('reference_transaction'),
                Select::make('categorie')
                    ->options([
            'espèces' => 'Espèces',
            'mobile_money' => 'Mobile money',
            'en_ligne' => 'En ligne',
            'crypto' => 'Crypto',
        ]),
            ]);
    }
}
