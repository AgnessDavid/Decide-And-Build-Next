<?php

namespace App\Filament\Resources\MouvementStocks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MouvementStocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('produit.id')
                    ->searchable(),
                TextColumn::make('date_mouvement')
                    ->date()
                    ->sortable(),
                TextColumn::make('numero_bon')
                    ->searchable(),
                TextColumn::make('type_mouvement'),
                TextColumn::make('quantite')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_resultant')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('en_commande')
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
