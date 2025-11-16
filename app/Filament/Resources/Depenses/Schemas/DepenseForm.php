<?php

namespace App\Filament\Resources\Depenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class DepenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // Section 1 : Informations générales
                Section::make('Informations générales')
                    ->schema([
                        TextInput::make('designation')
                            ->label('Désignation')
                            ->required(),

                        TextInput::make('categorie')
                            ->label('Catégorie'),

                        DatePicker::make('date_depense')
                            ->label('Date de dépense')
                            ->required(),
                    ]),

                // Section 2 : Montants
                Section::make('Montant')
                    ->schema([
                        Grid::make()
                            ->columns(2)
                            ->schema([
                                TextInput::make('montant')
                                    ->label('Montant')
                                    ->required()
                                    ->numeric(),

                                TextInput::make('montant_total')
                                    ->label('Montant total')
                                    ->required()
                                    ->numeric()
                                    ->disabled()
                                    ->default(function () {
                                        $dernierTotal = \App\Models\Depense::latest('id')->value('montant_total') ?? 0;
                                        return $dernierTotal;
                                    }),
                            ]),
                    ]),

                // Section 3 : Détails supplémentaires
                Section::make('Détails')
                    ->schema([
                        Textarea::make('details')
                            ->label('Détails')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
