<?php

namespace App\Filament\Resources\DemandeProductions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DemandeProductionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('designation')->label('Désignation')->searchable(),
                TextColumn::make('produit.nom_produit')->label('Produit')->searchable(),
                TextColumn::make('quantite_demandee')->label('Quantité demandée'),
                TextColumn::make('quantite_imprimee')->label('Quantité produite'),
                TextColumn::make('date_demande')->label('Date de demande')->dateTime(),
                TextColumn::make('date_impression')->label('Date production')->dateTime(),
            ])
            ->filters([
                //
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
