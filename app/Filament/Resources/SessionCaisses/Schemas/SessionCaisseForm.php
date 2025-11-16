<?php

namespace App\Filament\Resources\SessionCaisses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class SessionCaisseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section 1 : Caissier et ouverture
                Section::make('Informations du caissier')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->label('Caissier'),

                        DateTimePicker::make('ouvert_le')
                            ->required()
                            ->label('Ouvert le'),

                        DateTimePicker::make('ferme_le')
                            ->label('Fermé le'),

                        TextInput::make('statut')
                            ->disabled()
                            ->default('ouvert'), // Changé à 'ouvert' par défaut
                    ]),

                // Section 2 : Solde (champs à sauvegarder)
                Section::make('Solde et mouvements')
                    ->schema([
                        TextInput::make('solde_initial')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Solde initial')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $soldeFinal = ($state ?? 0) + ($get('entrees') ?? 0) - ($get('sorties') ?? 0);
                                $set('solde_final', $soldeFinal);
                            })
                            ->formatStateUsing(fn($state) => number_format($state ?? 0, 0, ',', '.') . ' F CFA'),

                        TextInput::make('entrees')
                            ->numeric()
                            ->default(0)
                            ->label('Entrées')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $soldeFinal = ($get('solde_initial') ?? 0) + ($state ?? 0) - ($get('sorties') ?? 0);
                                $set('solde_final', $soldeFinal);
                            })
                            ->formatStateUsing(fn($state) => number_format($state ?? 0, 0, ',', '.') . ' F CFA'),

                        TextInput::make('sorties')
                            ->numeric()
                            ->default(0)
                            ->label('Sorties')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $soldeFinal = ($get('solde_initial') ?? 0) + ($get('entrees') ?? 0) - ($state ?? 0);
                                $set('solde_final', $soldeFinal);
                            })
                            ->formatStateUsing(fn($state) => number_format($state ?? 0, 0, ',', '.') . ' F CFA'),

                        TextInput::make('solde_final')
                            ->numeric()
                            ->disabled()
                            ->label('Solde final')
                            ->default(0)
                            ->formatStateUsing(fn($state) => number_format($state ?? 0, 0, ',', '.') . ' F CFA'),
                    ]),

                // Section 3 : Statistiques globales (affichage seulement)
                Section::make('Statistiques globales de toutes les caisses')
                    ->schema([
                        TextInput::make('total_entrees_toutes_caisses')
                            ->label('Total entrées toutes caisses')
                            ->disabled()
                            ->dehydrated(false) // Ne pas sauvegarder
                            ->default(fn() => number_format(\App\Models\Caisse::sum('nombre_total_entree'), 0, ',', '.') . ' F CFA'),

                        TextInput::make('total_sorties_toutes_caisses')
                            ->label('Total sorties toutes caisses')
                            ->disabled()
                            ->dehydrated(false) // Ne pas sauvegarder
                            ->default(fn() => number_format(\App\Models\Caisse::sum('nombre_total_sortie'), 0, ',', '.') . ' F CFA'),

                        TextInput::make('solde_total_toutes_caisses')
                            ->label('Solde total toutes caisses')
                            ->disabled()
                            ->dehydrated(false) // Ne pas sauvegarder
                            ->default(fn() => number_format(
                                \App\Models\Caisse::sum('nombre_total_entree') - \App\Models\Caisse::sum('nombre_total_sortie'),
                                0,
                                ',',
                                '.'
                            ) . ' F CFA'),
                    ]),

                // Section 4 : Statistiques des dépenses (affichage seulement)
                Section::make('Statistiques globales des dépenses')
                    ->schema([
                        TextInput::make('total_depenses')
                            ->label('Total général des dépenses') // Libellé corrigé
                            ->disabled()
                            ->dehydrated(false) // Ne pas sauvegarder
                            ->default(fn() => number_format(\App\Models\Depense::sum('montant'), 0, ',', '.') . ' F CFA'), // Utilisation de sum('montant') plus fiable
                    ]),

                // Section 5 : Total combiné (affichage seulement)
                Section::make('Total des sorties et dépenses')
                    ->schema([
                        TextInput::make('total_sorties_et_depenses')
                            ->label('Total sorties caisses + dépenses')
                            ->disabled()
                            ->dehydrated(false) // Ne pas sauvegarder
                            ->default(function () {
                                $totalSortiesCaisses = \App\Models\Caisse::sum('nombre_total_sortie');
                                $totalDepenses = \App\Models\Depense::sum('montant');
                                $totalCombined = $totalSortiesCaisses + $totalDepenses;

                                return number_format($totalCombined, 0, ',', '.') . ' F CFA';
                            }),
                    ]),
            ]);
    }
}