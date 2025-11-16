<?php

namespace App\Filament\Resources\SessionCaisses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SessionCaisseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Caissier'),

                TextEntry::make('solde_initial')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => number_format($state ?? 0, 0, ',', '.') . ' FCFA')
                    ->label('Solde Initial'),

                TextEntry::make('entrees')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => number_format($state ?? 0, 0, ',', '.') . ' FCFA')
                    ->label('Total Entrées'),

                TextEntry::make('sorties')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => number_format($state ?? 0, 0, ',', '.') . ' FCFA')
                    ->label('Total Sorties'),

                TextEntry::make('solde_final')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => number_format($state ?? 0, 0, ',', '.') . ' FCFA')
                    ->label('Solde Final'),

                TextEntry::make('statut')
                    ->label('Statut'),

                TextEntry::make('ouvert_le')
                    ->dateTime()
                    ->label('Ouvert le'),

                TextEntry::make('ferme_le')
                    ->dateTime()
                    ->label('Fermé le'),
            ]);
    }
}
