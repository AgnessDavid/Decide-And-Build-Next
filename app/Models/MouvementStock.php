<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Support\Facades\Notification;
use App\Notifications\StockLowNotification;


class MouvementStock extends Model
{
    use HasFactory;

    protected $table = 'mouvements_stock';

    protected $fillable = [
        'produit_id',
        'imprimerie_id',
        'demande_impression_id',
        'designation',
        'date_mouvement',
        'type_mouvement',
        'quantite_entree',
        'quantite_demandee',
        'quantite_imprimee',
        'numero_bon',
        'quantite_sortie',
        'stock_resultant',
        'details',
    ];

    protected $casts = [
        'date_mouvement' => 'date',
        'quantite_entree' => 'integer',
        'quantite_sortie' => 'integer',
        'stock_resultant' => 'integer',
    ];

    // ================== RELATIONS ==================

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
    public function imprimerie()
    {
        return $this->belongsTo(Imprimerie::class);
    }

    public function demandeImpression(): BelongsTo
    {
        return $this->belongsTo(DemandeImpression::class);
    }

    // ================== SCOPES ==================

    public function scopeEntrees($query)
    {
        return $query->where('type_mouvement', 'entree');
    }


    public function scopeSorties($query)
    {
        return $query->where('type_mouvement', 'sortie');
    }

    public function scopePourProduit($query, $produitId)
    {
        return $query->where('produit_id', $produitId);
    }

    // ================== ACCESSORS ==================

    public function getTypeMouvementLabelAttribute(): string
    {
        return match($this->type_mouvement) {
            'entree' => 'Entrée',
            'sortie' => 'Sortie',
            default => $this->type_mouvement,
        };
    }

    // ================== MÉTHODES ==================

    /**
     * Définit automatiquement la quantité entrée ou sortie
     */
    public function setQuantiteAttribute($value)
    {
        $value = abs($value);
        if ($this->type_mouvement === 'entree') {
            $this->attributes['quantite_entree'] = $value;
            $this->attributes['quantite_sortie'] = 0;
        } elseif ($this->type_mouvement === 'sortie') {
            $this->attributes['quantite_sortie'] = $value;
            $this->attributes['quantite_entree'] = 0;
        }
    }


public static function genererNumero(): string
{
    $prefix = 'BON-';
    $last = static::latest('id')->first();
    $count = $last ? $last->id + 1 : 1;
    return $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);
}



    /**
     * Calcul automatique du stock résultant avant sauvegarde
     */
    protected static function booted()
    {
        static::saving(function ($mouvement) {
            if ($mouvement->produit) {
                $stockActuel = $mouvement->produit->stock_actuel ?? 0;

                $mouvement->stock_resultant = $stockActuel 
                    + ($mouvement->quantite_entree ?? 0) 
                    - ($mouvement->quantite_sortie ?? 0);

                // Mettre à jour le stock actuel du produit
                $mouvement->produit->stock_actuel = $mouvement->stock_resultant;
                $mouvement->produit->save();
            }


            
        });




        
    }
}
