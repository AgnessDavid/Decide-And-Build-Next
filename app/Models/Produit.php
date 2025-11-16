<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produit extends Model
{
    use HasFactory; //SoftDeletes;

    protected $fillable = [
        // Informations de base
        'reference_produit',
        'nom_produit',
        'description',
        'stock_minimum',
        'stock_maximum',
        'stock_actuel',
        'prix_unitaire_ht',
        'prix_unitaire_ttc',
        'est_en_promotion',
        'prix_promotion',
        'photo',
        'slug',
        'est_actif',
        'nombre_vues',
        'nombre_ventes',
        'tags',

        // Métadonnées cartes
        'titre',
        'type_carte',
        'echelle',
        'date_creation',
        'auteur',
        'categorie',
        'type_element',
        'nom_zone',
        'type_zone',
        'etat_conservation',
        'notes_conservation',

        'type_support',
        'format',
    ];

    protected $casts = [
        'prix_unitaire_ht' => 'decimal:2',
        'prix_unitaire_ttc' => 'decimal:2',
        'prix_promotion' => 'decimal:2',
        'est_en_promotion' => 'boolean',
        'est_actif' => 'boolean',
        'tags' => 'array',
        'date_creation' => 'date',
            
    ];

    // ================== RELATIONS ==================

    /** Commandes liées via pivot */
    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class, 'commande_produit')
            ->withPivot(['quantite', 'prix_unitaire_ht'])
            ->withTimestamps()
            ->using(CommandeProduit::class);
    }

    public function lignesCommande(): HasMany
    {
        return $this->hasMany(CommandeProduit::class, 'produit_id');
    }



    public function mouvements(): HasMany
    {
        return $this->hasMany(MouvementStock::class, 'produit_id');
    }

    public function livraisons(): HasMany
    {
        return $this->hasMany(Livraison::class, 'produit_id');
    }

    public function demandesExpressionBesoin(): HasMany
    {
        return $this->hasMany(DemandeExpressionBesoin::class, 'produit_id');
    }

    public function imprimerieExpressionBesoin(): HasMany
    {
        return $this->hasMany(ImprimerieExpressionBesoin::class, 'produit_id');
    }

    public function gestionImpression(): HasMany
    {
        return $this->hasMany(GestionImpression::class, 'produit_id');
    }

    public function gestionImprimerie(): HasMany
    {
        return $this->hasMany(GestionImprimerie::class, 'produit_id');
    }

    // ================== SCOPES ==================

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }

    public function scopeEnPromotion($query)
    {
        return $query->where('est_en_promotion', true)
            ->whereNotNull('prix_promotion');
    }

    public function scopeEnStock($query)
    {
        return $query->where('stock_actuel', '>', 0);
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type_carte', $type);
    }

    public function scopeParZone($query, $zone)
    {
        return $query->where('nom_zone', 'LIKE', "%{$zone}%");
    }

    // ================== ACCESSEURS ==================

    public function getPrixAffichageAttribute()
    {
        return $this->est_en_promotion && $this->prix_promotion
            ? $this->prix_promotion
            : $this->prix_unitaire_ttc;
    }

    public function getEstEnStockAttribute(): bool
    {
        return $this->stock_actuel > 0;
    }

    public function getEconomieAttribute(): float
    {
        if ($this->est_en_promotion && $this->prix_promotion) {
            return $this->prix_unitaire_ttc - $this->prix_promotion;
        }
        return 0;
    }

    public function getPourcentagePromotionAttribute(): int
    {
        if ($this->est_en_promotion && $this->prix_promotion && $this->prix_unitaire_ttc > 0) {
            return round((($this->prix_unitaire_ttc - $this->prix_promotion) / $this->prix_unitaire_ttc) * 100);
        }
        return 0;
    }

    public function getDimensionsAttribute(): ?string
    {
        if ($this->largeur_cm && $this->hauteur_cm) {
            return "{$this->largeur_cm} × {$this->hauteur_cm} cm";
        }
        return $this->format;
    }

    public function getCoordonneesAttribute(): ?string
    {
        if ($this->latitude_centre && $this->longitude_centre) {
            return "{$this->latitude_centre}, {$this->longitude_centre}";
        }
        return null;
    }

    public function getCarteCompleteAttribute(): string
    {
        return implode(' | ', array_filter([
            $this->titre,
            $this->type_carte,
            $this->echelle,
            $this->orientation,
            $this->nom_zone,
            $this->type_zone,
            $this->symbole,
            $this->type_element,
        ]));
    }



    // Dans Produit.php

    // Stock coloré
    public function getStockLabelAttribute(): string
    {
        if ($this->stock_actuel <= 0) {
            return 'Rupture de stock';
        } elseif ($this->stock_actuel <= ($this->stock_minimum ?? 5)) {
            return "Article : {$this->stock_actuel} restant(s)";
        }
        return "{$this->stock_actuel} article(s) disponible(s)";
    }

    public function getStockColorAttribute(): string
    {
        if ($this->stock_actuel <= 0) {
            return 'text-red-600';
        } elseif ($this->stock_actuel <= ($this->stock_minimum ?? 5)) {
            return 'text-orange-500';
        }
        return 'text-green-600';
    }

    // Vues et ventes
    public function getVuesLabelAttribute(): string
    {
        return "{$this->nombre_vues} vue(s)";
    }

    public function getVentesLabelAttribute(): string
    {
        return "{$this->nombre_ventes} vente(s)";
    }

    /*
    // Dans Produit.php
    public function getEtatConservationColorAttribute(): string
    {
        return match ($this->etat_conservation) {
            1 => 'text-green-600',   // Bon état
            2 => 'text-orange-500',  // État moyen
            3 => 'text-red-600',     // Mauvais état
            default => 'text-gray-500',
        };
    }

*/
    // ================== MÉTHODES ==================

    public function incrementerVues(): void
    {
        $this->increment('nombre_vues');
    }

    public function decrementerStock(int $quantite = 1): void
    {
        $this->decrement('stock_actuel', $quantite);
    }

    public function ajusterStock(int $quantite): void
    {
        $this->increment('stock_actuel', $quantite);
    }

    public function retirerStock(int $quantite): void
    {
        $this->decrement('stock_actuel', $quantite);
    }

    public function isEnRuptureStock(): bool
    {
        return $this->stock_actuel <= ($this->stock_minimum ?? 0);
    }

    // ================== BOOT ==================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produit) {
            if (empty($produit->slug)) {
                $produit->slug = \Str::slug($produit->nom_produit);
            }
            if (empty($produit->prix_unitaire_ttc)) {
                $produit->prix_unitaire_ttc = $produit->prix_unitaire_ht * (1 + ($produit->taux_tva / 100));
            }
        });
    }

    /** URL publique de la photo */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }





    
}
