<?php

namespace App\Filament\Resources\Depenses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DepenseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('designation'),
                TextEntry::make('montant')
                    ->numeric(),
                TextEntry::make('montant_total')
                    ->numeric(),
                TextEntry::make('date_depense')
                    ->date(),
                TextEntry::make('categorie'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
