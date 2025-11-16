<?php

namespace App\Filament\Resources\Validations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ValidationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ================== Informations sur le document ==================
                Section::make('Informations sur le document')
                    ->schema([
                        Select::make('type')
                            ->label('Type de document')
                            ->options([
                                'fiche_besoin' => 'Fiche de besoin',
                                'demande_impression' => 'Demande d\'impression',
                            ])
                            ->required()
                            ->reactive()
                            ->disabled(),

                        Select::make('document_id')
                            ->label('Document')
                            ->options(function (callable $get) {
                                $type = $get('type');
                                if ($type === 'fiche_besoin') {
                                    return \App\Models\FicheBesoin::pluck('nom_structure', 'id');
                                } elseif ($type === 'demande_impression') {
                                    return \App\Models\DemandeImpression::pluck('designation', 'id');
                                }
                                return [];
                            })
                            ->required()
                            ->disabled(),
                    ])
                    ->columns(2),

                // ================== Informations du validateur ==================
                Section::make('Informations du validateur')
                    ->schema([
                        Select::make('user_id')
                            ->label('Validateur')
                            ->relationship('user', 'name')
                            ->required(),

                        Select::make('statut')
                            ->label('Statut')
                            ->options([
                                'en_attente' => 'En attente',
                                'validée' => 'Validée',
                            ])
                            ->default('en_attente')
                            ->required(),
                    ])
                    ->columns(2),

                // ================== Notes et dates ==================
                Section::make('Notes et dates')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notes')
                            ->columnSpanFull(),

                        DatePicker::make('date_autorisation')
                            ->label('Date d\'autorisation')
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }
}
