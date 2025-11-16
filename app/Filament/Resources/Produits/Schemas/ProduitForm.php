<?php

namespace App\Filament\Resources\Produits\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput as SpatieTagsInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProduitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ================== Informations générales ==================
                Section::make('Informations générales')
                    ->schema([
                        TextInput::make('reference_produit')
                            ->label('Référence')
                            ->required()
                            ->columnSpan(2),

                        TextInput::make('nom_produit')
                            ->label('Nom du produit')
                            ->required()
                            ->columnSpan(2),

                        Textarea::make('description')
                            ->label('Description')
                            ->columnSpanFull(),


                        TextInput::make('stock_actuel')
                            ->label('Stock actuel')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->columnSpan(1),

                        TextInput::make('stock_minimum')
                            ->label('Stock minimum')
                            ->numeric()
                            ->columnSpan(1),

                        TextInput::make('stock_maximum')
                            ->label('Stock maximum')
                            ->numeric()
                            ->columnSpan(1),


                        Select::make('type_support')
                            ->label('Type de support')
                            ->options([
                                'papier' => 'Papier',
                                'numerique' => 'Numérique',
                            ])
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('format', null))
                            ->columnSpan(2),

                        Select::make('format')
                            ->label('Format')
                            ->options(function (callable $get) {
                                $type = $get('type_support');
                                if ($type === 'papier') {
                                    return [
                                        'A0+' => 'A0+',
                                        'A0' => 'A0',
                                        'A3' => 'A3',
                                        'A4' => 'A4',
                                    ];
                                } elseif ($type === 'numerique') {
                                    return [
                                        'image' => 'Image',
                                    ];
                                }
                                return [
                                    'A0+' => 'A0+',
                                    'A0' => 'A0',
                                    'A3' => 'A3',
                                    'A4' => 'A4',
                                    'image' => 'Image',
                                ];
                            })
                            ->required()
                            ->reactive()
                            ->columnSpan(2),

                        TextInput::make('prix_unitaire_ht')
                            ->label('Prix unitaire HT')
                            ->required()
                            ->numeric()
                            ->prefix('FCFA')
                            ->default(0)
                            ->columnSpan(2),

                        TextInput::make('prix_promotion')
                            ->label('Prix promotionnel TTC')
                            ->numeric()
                            ->prefix('FCFA')
                            ->minValue(0)
                            ->columnSpan(2),

                        FileUpload::make('photo')
                            ->label('Photos du produit')
                            ->directory('produits')
                            ->disk('public')
                            ->image()
                            ->maxSize(10240)
                            ->reorderable()
                            ->columnSpanFull()
                            ->storeFileNamesIn('photo_names'), // Stocke les noms dans une colonne séparée
                    ])
                    ->columns(4),




             




                    
                // ================== Informations de la carte ==================
                Section::make('Informations de la carte')
                    ->schema([
                        TextInput::make('type')
                            ->label('Type de carte')
                            ->placeholder('ex: Ville, Région, Pays, Continent')
                            ->columnSpan(2),

                        Textarea::make('categorie')
                            ->label('Categorie')
                            ->columnSpanFull(),

                        TextInput::make('echelle')
                            ->label('Échelle')
                            ->placeholder('ex: 1:50000')
                            ->columnSpan(1),

               
                        TextInput::make('auteur')
                            ->label('Auteur / Source')
                            ->columnSpan(2),

     
                        TextInput::make('nom_zone')
                            ->label('Nom de la zone')
                            ->columnSpan(2),

                        TextInput::make('type_zone')
                            ->label('Type de zone')
                            ->placeholder('ex: Région, Département, Pays')
                            ->columnSpan(2),

                        TextInput::make('date_creation')
                            ->label('Date de création')
                            ->type('date')
                            ->columnSpan(2),
                    ])
                    ->columns(4),

                // ================== Attributs de la carte ==================
                Section::make('Attributs de la carte')
                    ->schema([
                        SpatieTagsInput::make('tags')
                            ->label('Tags / Mots-clés')
                            ->placeholder('Ajouter un tag')
                            ->helperText('Appuyez sur Entrée pour ajouter')
                            ->columnSpanFull(),

                        Toggle::make('est_actif')
                            ->label('Produit actif')
                            ->default(true)
                            ->inline(false)
                            ->columnSpan(1),

                        Toggle::make('est_en_promotion')
                            ->label('En promotion')
                            ->live()
                            ->columnSpan(1),

                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->maxLength(255)
                            ->placeholder('Généré automatiquement')
                            ->helperText('Laissez vide pour génération automatique')
                            ->columnSpan(2),
                    ])
                    ->columns(4),

                // ================== État et Conservation ==================
                Section::make('État et Conservation')
                    ->description('Informations sur l\'état physique de la carte')
                    ->schema([
                        Select::make('etat_conservation')
                            ->label('État de conservation')
                            ->options([
                                'excellent' => 'Excellent',
                                'tres_bon' => 'Très bon',
                                'bon' => 'Bon',
                                'moyen' => 'Moyen',
                                'passable' => 'Passable',
                                'mauvais' => 'Mauvais',
                                'restaure' => 'Restauré',
                            ])
                            ->default('bon')
                            ->columnSpan(2),

                        Textarea::make('notes_conservation')
                            ->label('Notes sur la conservation')
                            ->placeholder('Détails sur l\'état, défauts, restaurations...')
                            ->rows(3)
                            ->columnSpan(2),
                    ])
                    ->columns(4)
                    ->collapsible()
                    ->collapsed(),



                    
         
         
         
                ]);
    }
}
