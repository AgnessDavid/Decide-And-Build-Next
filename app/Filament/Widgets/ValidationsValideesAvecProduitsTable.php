<?php

namespace App\Filament\Widgets;

use App\Models\Validation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;

class ValidationsValideesAvecProduitsTable extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Validation::query()
                    ->where('statut', 'validée')
                    ->with(['document.produit', 'user'])
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Validation')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('document.reference')
                    ->label('Référence Demande')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('document.designation')
                    ->label('Désignation')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function ($state) {
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('document.produit.nom_produit')
                    ->label('Nom du Produit')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('document.quantite_demandee')
                    ->label('Quantité')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Validé par')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_autorisation')
                    ->label('Date validation')
                    ->date('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nom_visa_autorisateur')
                    ->label('Visa autorisateur')
                    ->searchable(),

                Tables\Columns\TextColumn::make('statut')
                    ->label('Statut')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn($state) => ucfirst($state)),
            ])
            ->actions([
                // Supprimer l'action ou utiliser une action simple sans route
                Action::make('view')
                    ->label('Voir')
                    ->icon('heroicon-o-eye')
                    ->disabled(), // Désactivé temporairement
            ])
            ->emptyStateHeading('Aucune validation trouvée')
            ->emptyStateDescription('Les validations approuvées apparaîtront ici.')
            ->emptyStateIcon('heroicon-o-check-badge');
    }
}