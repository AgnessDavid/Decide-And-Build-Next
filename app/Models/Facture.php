<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'client_id',
        'user_id',
        'caisse_id',
        'numero_facture',
        'date_facturation',
        'montant_ht',
        'tva',
        'montant_ttc',
        'statut_paiement',
        'notes',
    ];

    protected $casts = [
        'date_facturation' => 'date',
        'montant_ht' => 'decimal:2',
        'tva' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
    ];

    // --------------------------
    // RELATIONS
    // --------------------------
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function caisse()
    {
    return $this->belongsTo(Caisse::class,'caisse_id');

    }



    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }


public function getMontantHtAttribute(): float
{
    return $this->commande ? $this->commande->montant_ht : 0;
}

public function getMontantTtcAttribute(): float
{
    return $this->commande ? $this->commande->montant_ttc : 0;
}

public static function genererNumeroFacture(): string
{
    $prefix = 'FAC-';

    // Récupérer le dernier numéro
    $lastFacture = static::orderBy('id', 'desc')->first();
    
    if (!$lastFacture) {
        $next = 1;
    } else {
        // Extraire le chiffre du dernier numéro
        $dernierNumero = (int) str_replace($prefix, '', $lastFacture->numero_facture);
        $next = $dernierNumero + 1;
    }

    return $prefix . str_pad($next, 2, '0', STR_PAD_LEFT);
}




protected static function booted()
{
    static::creating(function ($facture) {
        if (empty($facture->numero_facture)) {
            $facture->numero_facture = self::genererNumeroFacture();
        }
    });
}

    // --------------------------
    // PRODUITS LIGNES POUR INFOLIST
    // --------------------------
    public function getProduitsLignesAttribute(): array
    {
        if (!$this->commande || !$this->commande->produits) {
            return [];
        }

        return $this->commande->produits->map(fn($ligne) => [
            'nom' => $ligne->produit->nom_produit ?? 'Produit inconnu',
            'quantite' => $ligne->quantite,
            'prix_unitaire_ht' => $ligne->prix_unitaire_ht,
            'montant_ht' => $ligne->quantite * $ligne->prix_unitaire_ht,
            'produit_non_satisfait' => $ligne->produit_non_satisfait ?? 0,
            'montant_ttc' => $ligne->quantite * $ligne->prix_unitaire_ht * 1.18, 
            'statut_paiement_commande' => $this->caisse?->statut_paiement ?? 'impayé',
            // juste pour affichage
        ])->toArray();
    }
}
