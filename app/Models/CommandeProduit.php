<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommandeProduit extends Pivot
{
    use HasFactory;

    protected $table = 'commande_produit';

    protected $fillable = [
        'commande_id',
        'produit_id',
        'numero_com_prod',
        'quantite',
        'prix_unitaire_ht',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    protected static function booted()
    {
        // Générer un identifiant unique pour la ligne de commande si absent
        static::creating(function ($ligne) {
            if (empty($ligne->numero_com_prod)) {
                $ligne->numero_com_prod = 'CP-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));
            }
        });

        // ======================================
        // Quand une ligne de commande est créée
        // ======================================
        static::created(function ($ligne) {
            $produit = $ligne->produit;
            $quantite = (int) ($ligne->quantite ?? 0);

            if ($produit && $quantite > 0) {
                // Retirer la quantité commandée du stock
                $produit->retirerStock($quantite);

                // Historiser le mouvement de stock
                $produit->mouvements()->create([
                    'date_mouvement' => now(),
                    'type_mouvement' => 'sortie',
                    'quantite' => $quantite,
                    'stock_resultant' => $produit->stock_actuel,
                    'details' => "Commande n°{$ligne->commande_id}",
                ]);
            }



            
            // ===============================
            // Mise à jour / création de la caisse
            // ===============================
            $commande = $ligne->commande->load('produits');

            $montant_ht = $commande->produits->sum(fn($l) => $l->quantite * $l->prix_unitaire_ht);
            $montant_ttc = round($montant_ht * 1.18, 2);
            
            $caisse = $commande->caisse()->firstOrCreate(
                ['commande_id' => $commande->id],
                [
                    'client_id' => $commande->client_id,
                    'user_id' => $commande->user_id,
                    'montant_ht' => $montant_ht,
                    'tva' => 18,
                    'montant_ttc' => $montant_ttc,
                    'entree' => 0,
                    'sortie' => 0,
                    'statut_paiement' => 'impayé',
                ]
            );



            if (!$caisse->wasRecentlyCreated) {
                $caisse->update([
                    'montant_ht' => $montant_ht,
                    'montant_ttc' => $montant_ttc,
                ]);
            }

            // ===============================
            // Création / mise à jour de la facture
            // ===============================
            $facture = $commande->facture()->firstOrCreate(
                ['commande_id' => $commande->id],
                [
                    'client_id' => $commande->client_id,
                    'user_id' => $commande->user_id,
                    'caisse_id' => $caisse->id,
                    'date_facturation' => now(),
                    'statut_paiement' => $caisse->statut_paiement,
                    'montant_ht' => $montant_ht,
                    'tva' => 18,
                    'montant_ttc' => $montant_ttc,
                    'notes' => $commande->notes_internes,
                ]
            );

            if (!$facture->wasRecentlyCreated) {
                $facture->update([
                    'caisse_id' => $caisse->id,
                    'montant_ht' => $montant_ht,
                    'montant_ttc' => $montant_ttc,
                    'statut_paiement' => $caisse->statut_paiement,
                ]);
            }
        });

        // ======================================
        // Quand la caisse est mise à jour (statut payé)
        // ======================================
        // À mettre dans le modèle Caisse, pas ici ! Exemple :
        // static::saved(function ($caisse) { ... });

        // ======================================
        // Si une ligne est supprimée, restaurer le stock
        // ======================================
        static::deleted(function ($ligne) {
            $produit = $ligne->produit;
            if ($produit) {
                $produit->ajusterStock($ligne->quantite);

                $produit->mouvements()->create([
                    'date_mouvement' => now(),
                    'type_mouvement' => 'entree',
                    'quantite' => $ligne->quantite,
                    'stock_resultant' => $produit->stock_actuel,
                    'details' => "Annulation commande n°{$ligne->commande_id}",
                ]);
            }
        });
    }
}
