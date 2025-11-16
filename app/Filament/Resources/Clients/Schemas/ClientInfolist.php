<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('nom'),
                TextEntry::make('type'),
                TextEntry::make('nom_interlocuteur'),
                TextEntry::make('fonction'),
                TextEntry::make('telephone'),
                TextEntry::make('cellulaire'),
                TextEntry::make('fax'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('ville'),
                TextEntry::make('quartier_de_residence'),
                TextEntry::make('usage'),
                TextEntry::make('domaine_activite'),
            ]);
    }
}
