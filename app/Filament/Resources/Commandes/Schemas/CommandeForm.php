<?php

namespace App\Filament\Resources\Commandes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Notifications\Notification;

class CommandeForm
{
public static function configure(Schema $schema): Schema
{
    return $schema
        ->components([
            // Section 1 : Informations générales
            Section::make('Informations générales')
                ->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->label('Agent')
                          ->searchable()
                        ->required(),

                    Select::make('client_id')
                        ->relationship('client', 'nom')
                        ->label('Client')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('nom')->label('Nom')->required(),
                            Select::make('type')->label('Type')->options(\App\Models\Client::TYPES)->required(),
                            TextInput::make('nom_interlocuteur')->label('Nom interlocuteur'),
                            TextInput::make('fonction')->label('Fonction'),
                            TextInput::make('telephone')->label('Téléphone'),
                            TextInput::make('cellulaire')->label('Cellulaire'),
                            TextInput::make('fax')->label('Fax'),
                            TextInput::make('email')->label('Email')->email(),
                            TextInput::make('ville')->label('Ville'),
                            TextInput::make('quartier_de_residence')->label('Quartier de résidence'),
                            Select::make('usage')->label('Usage')->options(\App\Models\Client::USAGES),
                            TextInput::make('domaine_activite')->label('Domaine d’activité'),
                        ]),

                    DatePicker::make('date_commande')->label('Date de commande')->required(),

                    TextInput::make('numero_commande')
                        ->label('Numéro de commande')
                        ->disabled()
                        ->default(fn () => 'CMD-BNET-XX')
                        ->required(),
                    ]),






                // Section 2 : Produits commandés
                Section::make('Produits commandés')
                    ->schema([
                        Repeater::make('produits')
                            ->label('Produits ')
                            // Utiliser la relation hasMany 'lignesCommande' (CommandeProduit)
                            // afin que le répéteur crée/édite des lignes de commande (pivot)
                            ->relationship('lignesCommande')
                            ->schema([
                                Select::make('produit_id')
                                 

                                    // ✅ REMPLACEZ par :
                                    ->options(\App\Models\Produit::pluck('nom_produit', 'id'))
                                    ->label('Produit')
                                    ->required()
                                    ->searchable()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        if ($state) {
                                            $produit = \App\Models\Produit::find($state);
                                            if ($produit) {

                                                $set('type_support', $produit->type_support);
                                                $set('format', $produit->format);
                                                // $set('echelle', $produit->echelle);
                                               
                                                $set('prix_unitaire_ht', $produit->prix_unitaire_ht);


                                                // Montants initiaux
                                                $quantite = $get('quantite') ?? 1;
                                                $set('montant_ht', $produit->prix_unitaire_ht * $quantite);
                                                $set('montant_ttc', $produit->prix_unitaire_ht * $quantite * 1.18);

                                                // Stocks
                                                $set('stock_actuel', $produit->stock_actuel);
                                                $set('stock_minimum', $produit->stock_minimum);
                                                $set('stock_maximum', $produit->stock_maximum);

                                                // Vérification des seuils
                                                $stockActuel = $produit->stock_actuel;
                                                $stockMin = $produit->stock_minimum;

                                                if ($stockActuel == $stockMin) {
                                                    Notification::make()
                                                        ->title('⚠️ Réapprovisionnement nécessaire')
                                                        ->body("Le stock actuel est égal au stock minimum ({$stockMin}). Pensez à réapprovisionner.")
                                                        ->warning()
                                                        ->duration(300000)
                                                        ->send();
                                                } elseif ($stockActuel < $stockMin) {
                                                    Notification::make()
                                                        ->title('🚨 Stock critique')
                                                        ->body("Le stock actuel ({$stockActuel}) est inférieur au minimum ({$stockMin}) ! Réapprovisionnement obligatoire.")
                                                        ->danger()
                                                        ->duration(300000)
                                                        ->send();
                                                } elseif ($stockActuel <= $stockMin + ($stockMin * 0.3)) {
                                                    Notification::make()
                                                        ->title('🔔 Stock en baisse')
                                                        ->body("Le stock actuel ({$stockActuel}) se rapproche du minimum ({$stockMin}). Anticipez un réapprovisionnement.")
                                                        ->warning()
                                                        ->duration(300000)
                                                        ->send();
                                                }

                                                // Validation quantité vs stock
                                                if ($quantite > $stockActuel) {
                                                    Notification::make()
                                                        ->title('Stock insuffisant')
                                                        ->body("La quantité demandée ({$quantite}) dépasse le stock disponible ({$stockActuel}) !")
                                                        ->danger()
                                                        ->duration(300000)
                                                        ->send();
                                                }
                                            }
                                        }
                                    })
                                    ->columnSpan(2),

                                TextInput::make('quantite')
                                    ->label('Quantité')
                                    ->numeric()
                                    ->default(1)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        $prixUnitaire = $get('prix_unitaire_ht') ?? 0;
                                        $set('montant_ht', $state * $prixUnitaire);
                                        $set('montant_ttc', $state * $prixUnitaire * 1.18);
                                    })
                                    ->columnSpan(2),

                                TextInput::make('stock_actuel')
                                    ->label('Stock actuel')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->columnSpan(2),

                                TextInput::make('prix_unitaire_ht')
                                    ->label('Prix unitaire HT')
                                    ->numeric()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        $quantite = $get('quantite') ?? 1;
                                        $set('montant_ht', $quantite * ($state ?? 0));
                                        $set('montant_ttc', $quantite * ($state ?? 0) * 1.18);
                                    })
                                    ->columnSpan(2),

                                TextInput::make('montant_ht')
                                    ->label('Montant HT')
                                    ->disabled()
                                    ->default(0)
                                    ->dehydrated(false)
                                    ->columnSpan(2),
                                
                                TextInput::make('type_support')
                                    ->label('Type de support')
                                    ->disabled()
                                    ->columnSpan(2),

                                TextInput::make('format')
                                    ->label('Format')
                                    ->disabled()
                                    ->columnSpan(2),


                                TextInput::make('montant_ttc')
                                    ->label('Montant TTC')
                                    ->disabled()
                                    ->default(0)
                                    ->dehydrated(false)
                                    ->columnSpan(2),
                            ])
                            ->columns(6)
                            ->createItemButtonLabel('Ajouter un produit'),
                    ]),

            // Section 3 : Informations supplémentaires
            Section::make('Informations supplémentaires')
                ->schema([
                    TextInput::make('produit_non_satisfait')->label('Produit non satisfait'),
                    Textarea::make('notes_internes')->label('Notes internes'),
                ]),

            // Section 4 : Paiement
                // Section 4 : Paiement
                Section::make('Paiement')
                    ->schema([
                        Select::make('moyen_de_paiement')
                            ->label('Mode de paiement')
                            ->options([
                                'en_ligne' => 'En ligne',
                                'especes' => 'Espèces',
                                'cheque' => 'Chèque',
                                'virement_bancaire' => 'Virement bancaire',
                            ])
                            ->required(),

                        Select::make('statut_paiement')
                            ->label('Statut paiement')
                            ->options([
                                'impayé' => 'Impayé',  // ✅ Minuscule
                                'payé' => 'Payé',
                            ])
                            ->default('impayé')  // ✅ Minuscule
                            ->required(),
                    ]),
        ]);
}
}


