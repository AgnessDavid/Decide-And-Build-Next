<?php

namespace App\Filament\Resources\ValidationFicheExpressionBesoins\Schemas;

use App\Models\FicheBesoin;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ValidationFicheExpressionBesoinForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // FICHE DE BESOIN (sélection + affichage en lecture seule)
            Select::make('fiche_besoin_id')
                ->label('Fiche d\'expression de besoin')
                ->required()
                ->options(FicheBesoin::pluck('nom_fiche_besoin', 'id')->map(fn($name) => $name ?? 'Sans nom'))
                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn($state, $set) => $set('fiche_data', $state ? FicheBesoin::find($state) : null))
                ->helperText('Sélectionnez la fiche à valider'),

            // AFFICHAGE CONTEXTUEL DE LA FICHE (lecture seule)
            Section::make('Détails de la fiche sélectionnée')
                ->schema(fn($get) => $get('fiche_data') ? self::ficheDetailsSchema($get('fiche_data')) : [])
                ->collapsible()
                ->collapsed()
                ->visible(fn($get) => $get('fiche_besoin_id') !== null),

            // VALIDATEUR
            Select::make('user_id')
                ->label('Validateur')
                ->required()
                ->options(User::pluck('name', 'id'))
                ->searchable()
                ->default(fn() => auth()->id())
                ->helperText('Utilisateur qui effectue la validation'),

            // ÉTAT DE VALIDATION
            Section::make('Décision de validation')
                ->schema([
                    Toggle::make('valide')
                        ->label('Approuvée ?')
                        ->required()
                        ->reactive()
                        ->helperText('Cochez si la demande est validée'),

                    Textarea::make('commentaire')
                        ->label('Commentaire / Motif')
                        ->placeholder('Ex: Demande incomplète, besoin de précisions...')
                        ->rows(3)
                        ->columnSpanFull()
                        ->visible(fn($get) => $get('valide') === false), // Obligatoire si refus
                ]),

            // DATE DE VALIDATION (auto ou manuelle)
            DatePicker::make('date_validation')
                ->label('Date de validation')
                ->default(now())
                ->maxDate(now())
                ->helperText('Date à laquelle la validation a été effectuée'),
        ]);
    }

    /**
     * Génère les champs en lecture seule avec les données de la fiche
     */
    private static function ficheDetailsSchema(FicheBesoin $fiche): array
    {
        return [
            Grid::make(2)->schema([
                Placeholder::make('nom_structure')
                    ->label('Structure')
                    ->content($fiche->nom_structure),

                Placeholder::make('type_structure')
                    ->label('Type')
                    ->content(ucfirst($fiche->type_structure)),

                Placeholder::make('nom_interlocuteur')
                    ->label('Interlocuteur')
                    ->content($fiche->nom_interlocuteur),

                Placeholder::make('fonction')
                    ->label('Fonction')
                    ->content($fiche->fonction ?? 'Non renseignée'),
            ]),

            Grid::make(2)->schema([
                Placeholder::make('produit_souhaite')
                    ->label('Produit souhaité')
                    ->content($fiche->produit_souhaite ?? $fiche->produit?->nom_produit ?? 'Non spécifié'),

                Placeholder::make('quantite_demandee')
                    ->label('Quantité')
                    ->content($fiche->quantite_demandee . ' unité(s)'),

                Placeholder::make('echelle')
                    ->label('Échelle')
                    ->content($fiche->echelle ?? 'Non définie'),

                Placeholder::make('nom_zone')
                    ->label('Zone')
                    ->content($fiche->nom_zone ?? 'Non définie'),
            ]),

            Grid::make(2)->schema([
                Placeholder::make('date_entretien')
                    ->label('Date d\'entretien')
                    ->content($fiche->date_entretien?->format('d/m/Y') ?? 'Non planifiée'),

                Placeholder::make('nom_agent_bnetd')
                    ->label('Agent BNETD')
                    ->content($fiche->nom_agent_bnetd),
            ]),

            Placeholder::make('objectifs_vises')
                ->label('Objectifs')
                ->content($fiche->objectifs_vises ?? 'Aucun objectif spécifié')
                ->columnSpanFull(),
        ];
    }
}