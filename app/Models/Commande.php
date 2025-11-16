<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';
    protected $fillable = [
        'user_id',
        'client_id',
        'produit_id',
        'etat',
        'numero_commande',
        'date_commande',
        'montant_ht',       
        'tva',              
        'montant_ttc',       
        'produit_non_satisfait',
        'moyen_de_paiement',
        'statut_paiement',
        'notes_internes',
        'reference_produit',
    ];

    protected $casts = [
        'date_commande' => 'date',
        'montant_ht' => 'decimal:2',    // ✅ AJOUTEZ
        'tva' => 'decimal:2',           // ✅ AJOUTEZ
        'montant_ttc' => 'decimal:2',   // ✅ AJOUTEZ
        'produit_non_satisfait' => 'integer',
    ];
    // ================== RELATIONS ==================
   
   
   
   
    public function ventes(): HasMany
    {
        return $this->hasMany(Vente::class);
    }

    public function caisse(): HasOne
    {
        return $this->hasOne(Caisse::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // Dans le modèle Commande



    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produit')
            ->withPivot('quantite', 'prix_unitaire_ht', 'montant_ht', 'montant_ttc')
            ->using(CommandeProduit::class)
            ->withTimestamps();
    }

    /**
     * Lignes de commande (modèle pivot CommandeProduit)
     */
    public function lignesCommande(): HasMany
    {
        return $this->hasMany(CommandeProduit::class, 'commande_id');
    }

    public function facture(): HasOne
    {
        return $this->hasOne(Facture::class);
    }

    // ================== ACCESSORS ==================
    public function getMontantHtAttribute(): float
    {
        return $this->produits->sum(
            fn($produit) =>
            $produit->pivot->quantite * $produit->pivot->prix_unitaire_ht
        );
    }

    public function getMontantTtcAttribute(): float
    {
        return round($this->montant_ht * 1.18, 2); // TVA 18%
    }

    public function getNomProduitsAttribute(): string
    {
        return $this->produits->pluck('nom_produit')->implode(', ');
    }

    // ================== EVENTS ==================
    protected static function booted()
    {
        // Générer automatiquement le numéro de commande
        static::creating(function ($commande) {
            if (empty($commande->numero_commande)) {
                $prefix = 'CMD-BNET-';
                $last = static::latest('id')->first();
                $count = $last ? $last->id + 1 : 1;
                $commande->numero_commande = $prefix . str_pad($count, 2, '0', STR_PAD_LEFT);
            }
        });


    }
}
