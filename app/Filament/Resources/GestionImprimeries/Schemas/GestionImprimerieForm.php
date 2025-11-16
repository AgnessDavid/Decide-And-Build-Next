<?php

namespace App\Filament\Resources\GestionImprimeries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Models\ImprimerieExpressionBesoin;

class GestionImprimerieForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // Section 1 : Sélection et informations du produit
                Section::make('Produit et demande')
                    ->schema([
                        Select::make('imprimeries_expression_besoin_id')
                            ->label('Imprimerie Expression Besoin')
                            ->options(ImprimerieExpressionBesoin::all()->pluck('nom_produit', 'id'))
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set) {
                                $impr = ImprimerieExpressionBesoin::find($state);
                                if ($impr) {
                                    $set('produit_id', $impr->produit_id);
                                    $set('designation', $impr->nom_produit);
                                    $set('quantite_demandee', $impr->quantite_demandee);
                                    $set('quantite_imprimee', $impr->quantite_imprimee);
                                    $set('stock_minimum', $impr->produit->stock_minimum ?? 0);
                                    $set('stock_maximum', $impr->produit->stock_maximum ?? 0);
                                    $set('stock_actuel', $impr->produit->stock_actuel ?? 0);
                                }
                            }),

                        Select::make('produit_id')
                            ->relationship('produit', 'nom_produit')
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set) {
                                $produit = \App\Models\Produit::find($state);
                                if ($produit) {
                                    $set('stock_actuel', $produit->stock_actuel);
                                    $set('stock_minimum', $produit->stock_minimum);
                                    $set('stock_maximum', $produit->stock_maximum);
                                }
                            }),

                        TextInput::make('designation')->label('Désignation'),
                        TextInput::make('quantite_demandee')->numeric()->label('Quantité demandée'),
                        TextInput::make('quantite_imprimee')->numeric()->label('Quantité imprimée'),
                        TextInput::make('stock_minimum')->numeric()->label('Stock minimum'),
                        TextInput::make('stock_maximum')->numeric()->label('Stock maximum'),
                        TextInput::make('stock_actuel')->numeric()->label('Stock actuel'),
                    ]),

                // Section 2 : Mouvement de stock
                Section::make('Mouvement de stock')
                    ->schema([
                        TextInput::make('quantite_entree')->numeric()->label('Quantité entrée'),
                        TextInput::make('quantite_sortie')->numeric()->label('Quantité sortie'),
                        TextInput::make('stock_resultant')->numeric()->default(0)->label('Stock résultant'),
                        TextInput::make('numero_impremerie_gestion')->label('Numéro du bon'),
                        TextInput::make('type_mouvement')->required()->label('Type de mouvement'),
                        DatePicker::make('date_mouvement')->required()->label('Date du mouvement'),
                        Textarea::make('details')->columnSpanFull()->label('Détails'),
                    ]),
            ]);
    }
}
