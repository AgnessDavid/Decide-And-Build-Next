<?php

namespace App\Filament\Widgets;

use App\Models\PaiementOnline;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPaiementsTable extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PaiementOnline::with('caisse')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('reference_transaction')
                    ->label('Référence')
                    ->searchable(),

                TextColumn::make('montant')
                    ->label('Montant')
                    ->money('eur')
                    ->sortable(),

                BadgeColumn::make('mode_paiement')
                    ->label('Mode de paiement')
                    ->colors([
                        'primary' => 'carte',
                        'success' => 'virement',
                        'warning' => 'paypal',
                    ]),

                BadgeColumn::make('statut')
                    ->label('Statut')
                    ->colors([
                        'success' => 'réussi',
                        'warning' => 'en_attente',
                        'danger' => 'échoué',
                    ]),

                TextColumn::make('categorie')
                    ->label('Catégorie'),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ]);
    }
}