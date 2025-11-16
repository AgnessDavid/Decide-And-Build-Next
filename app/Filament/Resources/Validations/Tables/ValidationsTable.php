<?php

namespace App\Filament\Resources\Validations\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class ValidationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_id')
                    ->label('Document')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->type === 'fiche_besoin') {
                            return $record->document?->nom_structure;
                        } elseif ($record->type === 'demande_impression') {
                            return $record->document?->designation;
                        }
                        return '-';
                    })
                    ->sortable(),

             
                TextColumn::make('user.name')
                    ->label('Validateur')
                    ->sortable(),

               
                TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(50),

                TextColumn::make('date_autorisation')
                    ->label('Date d\'autorisation')
                    ->date(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Type de document')
                    ->options([
                        'fiche_besoin' => 'Fiche de besoin',
                        'demande_impression' => 'Demande d\'impression',
                    ]),
                SelectFilter::make('statut')
                    ->label('Statut')
                    ->options([
                        'en_attente' => 'En attente',
                        'validée' => 'Validée',
                    ]),
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
