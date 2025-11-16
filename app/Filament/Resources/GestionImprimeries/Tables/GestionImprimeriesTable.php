<?php

namespace App\Filament\Resources\GestionImprimeries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GestionImprimeriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                /*
                TextColumn::make('produit.id')
                    ->searchable(),
               */
                    TextColumn::make('designation')
                    ->searchable(),
                TextColumn::make('quantite_entree')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantite_sortie')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date_mouvement')
                    ->date()
                    ->sortable(),
                TextColumn::make('numero_bon')
                    ->searchable(),
                TextColumn::make('type_mouvement')
                    ->searchable(),
                TextColumn::make('stock_resultant')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('imprimeries_expression_besoin_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantite_demandee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantite_imprimee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_minimum')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_maximum')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_actuel')
                    ->numeric()
                    ->sortable(),
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
