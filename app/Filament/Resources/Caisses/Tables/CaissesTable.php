<?php

namespace App\Filament\Resources\Caisses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

class CaissesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Utilisateur')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d-m-Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Mis à jour le')
                    ->dateTime('d-m-Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('numero_commande')
                    ->label('N° Commande')
                    ->searchable(),
                TextColumn::make('nom_client')
                    ->label('Client')
                    ->searchable(),
                TextColumn::make('montant_ht')
                    ->label('Montant HT')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', ' ') . ' FCFA'),
                TextColumn::make('tva')
                    ->label('TVA')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', ' ') . ' %'),
                TextColumn::make('montant_ttc')
                    ->label('Montant TTC')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', ' ') . ' FCFA'),
                TextColumn::make('entree')
                    ->label('Entrée')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', ' ') . ' FCFA'),
                TextColumn::make('sortie')
                    ->label('Sortie')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', ' ') . ' FCFA'),
                TextColumn::make('statut_paiement')
                    ->label('Statut Paiement'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()->label('Voir'),
                EditAction::make()->label('Modifier'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Supprimer'),
                    Action::make('export_pdf')
                        ->label('Exporter en PDF')
                        ->icon('heroicon-o-printer')
                        ->action(function ($records) {
                            $records->load(['user', 'commande.produits.produit', 'client']);
                            $pdf = Pdf::loadView('caisses.pdf', ['records' => $records]);
                            return response()->streamDownload(function () use ($pdf) {
                                echo $pdf->output();
                            }, 'caisses_export_' . now()->format('Ymd_His') . '.pdf');
                        })
                        ->requiresConfirmation()
                        ->color('success'),
                ]),
            ]);
    }
}