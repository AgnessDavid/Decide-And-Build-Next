<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Caisse extends Model
{
    protected $table = 'caisses';

    protected $fillable = [
        'commande_id',
        'session_caisse_id',
        'client_id',
        'user_id',
        'numero_caisse',
        'montant_ht',
        'tva',
        'montant_ttc',
        'entree',
        'sortie',
        'statut_paiement',
        'nombre_total_entree',
        'nombre_total_sortie',
    ];

    // ================== RELATIONS ==================

    public function sessionCaisse(): BelongsTo
    {
        return $this->belongsTo(SessionCaisse::class, 'session_caisse_id');
    }

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
public function facture()
{
    return $this->hasOne(Facture::class, 'caisse_id');
}

    public function sessionCaisses()
    {
        return $this->belongsTo(SessionCaisse::class, 'session_caisse_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ================== ACCESSORS ==================

    public function getNumeroCommandeAttribute(): ?string
    {
        return $this->commande?->numero_commande;
    }

    public function getNomClientAttribute(): ?string
    {
        return $this->client?->nom ?? $this->client?->prenom;
    }

    public function getMontantHtCommandeAttribute(): ?float
    {
        return $this->commande?->montant_ht;
    }

    public function getMontantTtcCommandeAttribute(): ?float
    {
        return $this->commande?->montant_ttc;
    }

    public function getProduitsCommandeAttribute(): array
    {
        if ($this->commande) {
            return $this->commande->produits->map(function ($ligne) {
                return [
                    'nom' => $ligne->produit?->nom_produit,
                    'quantite' => $ligne->quantite,
                    'prix_unitaire_ht' => $ligne->prix_unitaire_ht,
                    'montant_ht' => $ligne->quantite * $ligne->prix_unitaire_ht,
                    'montant_ttc' => $ligne->quantite * $ligne->prix_unitaire_ht * 1.18,
                ];
            })->toArray();
        }

        return [];
    }

    // ================== HOOKS ==================

protected static function booted()
{
    // Avant la création
    static::creating(function ($caisse) {
        // Générer numero_caisse si non défini
        if (!$caisse->numero_caisse) {
            $caisse->numero_caisse = 'CAISSE-' . now()->format('YmdHis');
        }

        if ($caisse->commande_id) {
            $commande = Commande::with('client')->find($caisse->commande_id);
            if ($commande) {
                $caisse->client_id = $commande->client_id;
                $caisse->user_id   = $commande->user_id;
                $caisse->montant_ht = $commande->montant_ht;
                $caisse->tva = 18.00;
                $caisse->montant_ttc = $commande->montant_ttc;
            }
        }

        // Initialiser les totaux à zéro si null
        $caisse->nombre_total_entree ??= 0;
        $caisse->nombre_total_sortie ??= 0;
    });

    // Avant sauvegarde (création ou mise à jour)
    static::saving(function ($caisse) {
        // Calcul automatique de la sortie si entrée et montant_ttc présents
        if (!is_null($caisse->entree) && !is_null($caisse->montant_ttc)) {
            $caisse->sortie = $caisse->entree - $caisse->montant_ttc;
        }

        // Stocker directement les montants dans les totaux
        $caisse->nombre_total_entree = $caisse->entree ?? 0;
        $caisse->nombre_total_sortie = $caisse->sortie ?? 0;
    });

    // Après sauvegarde
static::saved(function ($caisse) {
        // Vérifier si le statut de paiement est "payé" (insensible à la casse)
        if (strtolower($caisse->statut_paiement) === 'payé') {
            // Récupérer la facture associée à cette caisse
            $facture = $caisse->facture;
            
            if ($facture) {
                // Mettre à jour automatiquement le statut de paiement
                $facture->update([
                    'statut_paiement' => 'payé',
                ]);
            }

            // Optionnel : mettre aussi à jour la commande si besoin
            $commande = $caisse->commande;
            if ($commande) {
                $commande->update([
                    'statut_paiement' => 'payé',
                ]);
            }
        }
    });

}

}



