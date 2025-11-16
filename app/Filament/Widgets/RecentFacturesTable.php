<?php

namespace App\Filament\Widgets;

use App\Models\Facture;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
 use Filament\Tables\Actions\EditAction;
class RecentFacturesTable extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Facture::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('numero_facture')
                    ->label('N° Facture')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('client.nom')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('montant_ttc')
                    ->label('Montant TTC')
                    ->formatStateUsing(fn($state) => number_format($state, 0, ',', ' ') . ' F CFA')
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_facturation')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('statut_paiement')
                    ->label('Statut')
                    ->colors([
                        'success' => 'payé',
                        'danger' => 'impayé',
                        'warning' => 'partiel',
                    ])
                    ->sortable(),
                    ]);
      
    }
}