<?php

namespace App\Filament\Resources\Imprimeries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ImprimeriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                /*
                TextColumn::make('validation.id')
                    ->searchable(),
                TextColumn::make('demande_id')
                    ->numeric()
                    ->sortable(),
               */
                    TextColumn::make('nom_produit')
                    ->searchable(),
                TextColumn::make('quantite_demandee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('numero_impression')
                    ->numeric()
                    ->sortable(),
  //numero_impression

                TextColumn::make('valide_par')
                    ->searchable(),
                TextColumn::make('operateur')
                    ->searchable(),
                TextColumn::make('date_impression')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('produit.id')
                    ->searchable(),
                TextColumn::make('quantite_imprimee')
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
