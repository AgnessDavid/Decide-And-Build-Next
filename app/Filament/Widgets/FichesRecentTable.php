<?php

namespace App\Filament\Widgets;

use App\Models\FicheBesoin;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class FichesRecentTable extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => FicheBesoin::query())
            ->columns([
                TextColumn::make('nom_fiche_besoin')
                    ->searchable(),
                TextColumn::make('produit.id')
                    ->searchable(),
                TextColumn::make('produit_souhaite')
                    ->searchable(),
                TextColumn::make('quantite_demandee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nom_structure')
                    ->searchable(),
                TextColumn::make('type_structure'),
                TextColumn::make('nom_interlocuteur')
                    ->searchable(),
                TextColumn::make('fonction')
                    ->searchable(),
                TextColumn::make('telephone')
                    ->searchable(),
                TextColumn::make('cellulaire')
                    ->searchable(),
                TextColumn::make('fax')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('nom_agent_bnetd')
                    ->searchable(),
                TextColumn::make('date_entretien')
                    ->date()
                    ->sortable(),
                IconColumn::make('commande_ferme')
                    ->boolean(),
                IconColumn::make('demande_facture_proforma')
                    ->boolean(),
                TextColumn::make('delai_souhaite')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_livraison_prevue')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_livraison_reelle')
                    ->date()
                    ->sortable(),
                TextColumn::make('signature_client')
                    ->searchable(),
                TextColumn::make('signature_agent_bnetd')
                    ->searchable(),
                TextColumn::make('type_carte')
                    ->searchable(),
                TextColumn::make('echelle')
                    ->searchable(),
                TextColumn::make('orientation')
                    ->searchable(),
                TextColumn::make('auteur')
                    ->searchable(),
                TextColumn::make('symbole')
                    ->searchable(),
                TextColumn::make('type_element')
                    ->searchable(),
                TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nom_zone')
                    ->searchable(),
                TextColumn::make('type_zone')
                    ->searchable(),
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
