<?php

namespace App\Filament\Widgets;

use App\Models\MouvementStock;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ProduitsAReapprovisionnerTable extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => MouvementStock::query())
            ->columns([
                TextColumn::make('nom_mouvements_stock')
                    ->searchable(),
                TextColumn::make('produit.id')
                    ->searchable(),
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
                TextColumn::make('imprimerie_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantite_demandee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantite_imprimee')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
