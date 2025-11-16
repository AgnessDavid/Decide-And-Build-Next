<?php

namespace App\Filament\Resources\Commandes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use App\Models\Produit;

class CommandeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Agent'),

                TextEntry::make('client.nom')
                    ->label('Client'),

                TextEntry::make('numero_commande')
                    ->label('Numéro de commande'),

                TextEntry::make('date_commande')
                    ->label('Date de commande')
                    ->date(),

                TextEntry::make('montant_ht')
                    ->label('Montant HT')
                    ->getStateUsing(fn($record) => number_format(round($record->montant_ht), 0, ',', ' ') . ' FCFA'),

                TextEntry::make('tva')
                    ->label('TVA (%)')
                    ->numeric(),

                TextEntry::make('produit_non_satisfait')
                    ->label('Produit non satisfait'),

                TextEntry::make('produits_support')
                    ->label('Type(s) de support')
                    ->getStateUsing(function ($record) {
                        $supports = $record->produits
                            ->pluck('type_support')
                            ->unique()
                            ->filter()
                            ->map(fn($support) => match ($support) {
                                'papier' => 'Papier',
                                'numerique' => 'Numérique',
                                default => $support,
                            });

                        return $supports->isEmpty() ? 'Non défini' : $supports->implode(', ');
                    })
                    ->badge()
                    ->color('primary'),

                TextEntry::make('produits_formats')
                    ->label('Format(s)')
                    ->getStateUsing(function ($record) {
                        $formats = $record->produits
                            ->pluck('format')
                            ->unique()
                            ->filter();

                        return $formats->isEmpty() ? 'Non défini' : $formats->implode(', ');
                    })
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-rectangle-stack'),


                TextEntry::make('montant_ttc')
                    ->label('Montant TTC')
                    ->getStateUsing(fn($record) => number_format(round($record->montant_ttc), 0, ',', ' ') . ' FCFA'),

                TextEntry::make('moyen_de_paiement')->label('Moyen de paiement'),
                TextEntry::make('statut_paiement')->label('Statut paiement'),

                TextEntry::make('created_at')->label('Créé le')->dateTime(),
                TextEntry::make('updated_at')->label('Mis à jour le')->dateTime(),

                // Liste des produits commandés avec multi-lignes et mise en forme
                TextEntry::make('produits_lignes')
                    ->label('Produits commandés')
                    ->getStateUsing(function ($record) {
                        return $record->produits->map(function ($ligne) {
                            $quantite = $ligne->quantite ?? 0;
                            $prixUnitaire = $ligne->prix_unitaire_ht ?? 0;
                            $montantHt = $quantite * $prixUnitaire;
                            $nomProduit = $ligne->produit ? $ligne->produit->nom_produit : '[Produit indisponible]';

                            return "• Produit : {$nomProduit}\n"
                                 . "  Quantité : {$quantite}\n"
                                 . "  Prix unitaire : " . number_format(round($prixUnitaire), 0, ',', ' ') . " FCFA\n"
                                 . "  Montant HT : " . number_format(round($montantHt), 0, ',', ' ') . " FCFA\n";
                        })->implode("\n"); // chaque produit sur plusieurs lignes
                    })
                , // optionnel pour custom Blade si besoin
            ]);
    }
}
