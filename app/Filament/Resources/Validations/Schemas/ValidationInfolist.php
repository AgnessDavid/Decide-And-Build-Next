<?php

namespace App\Filament\Resources\Validations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\DateEntry;
use Filament\Schemas\Schema;

class ValidationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type')
                    ->label('Type de document'),
                
                TextEntry::make('document.nom_structure') // pour fiche besoin
                    ->label('Nom de la structure')
                    ->visible(fn($record) => $record->type === 'fiche_besoin'),

                TextEntry::make('document.designation') // pour demande impression
                    ->label('Désignation')
                    ->visible(fn($record) => $record->type === 'demande_impression'),

                TextEntry::make('user.name')->label('Validateur'),
                TextEntry::make('statut')->label('Statut'),
                TextEntry::make('date_autorisation')->label('Date d\'autorisation'),
                TextEntry::make('notes')->label('Notes'),
            ]);
    }
}
