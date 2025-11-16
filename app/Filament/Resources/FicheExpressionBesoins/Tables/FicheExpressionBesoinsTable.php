<?php

namespace App\Filament\Resources\FicheExpressionBesoins\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FicheExpressionBesoinsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom_structure')->label('Nom de la structure')->searchable(),
                TextColumn::make('type_structure')->label('Type de structure'),
                TextColumn::make('nom_interlocuteur')->label('Interlocuteur'),
                TextColumn::make('fonction')->label('Fonction'),
                TextColumn::make('telephone')->label('Téléphone'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('date_entretien')->label('Date entretien')->dateTime(),
                TextColumn::make('objectifs_vises')->label('Objectifs visés')->limit(50),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
