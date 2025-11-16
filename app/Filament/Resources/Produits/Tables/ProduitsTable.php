<?php

namespace App\Filament\Resources\Produits\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;


class ProduitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('reference_produit')
                    ->searchable(),
                TextColumn::make('nom_produit')
                    ->searchable(),
                TextColumn::make('stock_minimum')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_maximum')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_actuel')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('photo')
                    ->label('Photo')
                    ->square()
                    ->size(60),
                TextColumn::make('type_support')
                    ->label('Support')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'papier' => 'Papier',
                        'numerique' => 'Numérique',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'papier' => 'primary',
                        'numerique' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'papier' => 'heroicon-o-document-text',
                        'numerique' => 'heroicon-o-computer-desktop',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('format')
                    ->label('Format')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-rectangle-stack')
                    ->sortable()
                    ->searchable(),

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
