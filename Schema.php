<?php

namespace App\Filament\Resources\MouvementStocks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Models\Produit;
use App\Models\Imprimerie;

class MouvementStockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Produit')
                    ->schema([
                        Select::make('produit_id')
                            ->relationship('produit', 'nom_produit')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('imprimerie_id', null); // réinitialise imprimerie si produit change
                                $set('stock_actuel', Produit::find($state)?->stock_actuel ?? 0);
                            }),

                        Select::make('imprimerie_id')
                            ->label('Imprimerie')
                            ->options(function (callable $get) {
                                $produitId = $get('produit_id');
                                return $produitId
                                    ? Imprimerie::where('produit_id', $produitId)
                                        ->pluck('nom_produit', 'id')
                                    : [];
                            })
                            ->nullable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $imprimerie = Imprimerie::with('produit')->find($state);
                                    if ($imprimerie) {
                                        $set('produit_id', $imprimerie->produit_id);
                                        $set('quantite_demandee', $imprimerie->quantite_demandee);
                                        $set('quantite_imprimee', $imprimerie->quantite_imprimee);
                                        $set('quantite_entree', $imprimerie->quantite_imprimee ?? 0);
                                        $set('stock_resultant', ($imprimerie->produit?->stock_actuel ?? 0) + ($imprimerie->quantite_imprimee ?? 0));
                                    }
                                }
                            }),

                        TextInput::make('stock_actuel')
                            ->label('Stock actuel')
                            ->numeric()
                            ->disabled(),


Select::make('type_mouvement')
    ->label('Type de mouvement')
    ->options([
        'entree' => 'Entrée',
        'sortie' => 'Sortie',
    ])
    ->required()
    ->default('entree') // tu peux mettre entrée par défaut
    ->reactive(),

                        TextInput::make('stock_resultant')
                            ->label('Stock après mouvement')
                            ->numeric()
                            ->disabled(),
                    ]),

                Section::make('Quantités')
                    ->schema([
                        TextInput::make('quantite_demandee')
                            ->label('Quantité demandée')
                            ->numeric()
                            ->disabled(),

                        TextInput::make('quantite_imprimee')
                            ->label('Quantité imprimée')
                            ->numeric()
                            ->disabled(),

                        TextInput::make('quantite_entree')
                            ->label('Quantité entrée')
                            ->numeric(),

                        TextInput::make('quantite_sortie')
                            ->label('Quantité sortie')
                            ->numeric(),
                    ]),

                Section::make('Informations complémentaires')
                    ->schema([
                        DatePicker::make('date_mouvement')
                            ->label('Date du mouvement')
                            ->required(),

                        TextInput::make('numero_bon')
                            ->label('Numéro du bon')
                            ->default(fn () => \App\Models\MouvementStock::genererNumero())
                            ->disabled(),

                        TextInput::make('details')
                            ->label('Détails'),
                            
                    ]),
            ]);
    }
}
