<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GestionImpression extends Model
{
    use HasFactory;

    protected $table = 'gestion_impressions';

    protected $fillable = [
        'numero_gestion',
        'imprimerie_id',
        'demande_impression_id',  // ← Corrigé
        'produit_id',
        'nom_produit',
        'quantite_demandee',
        'quantite_imprimee',
        'type_impression',
        'statut',
        'date_impression',
        'date_demande',
        'valide_par',
        'operateur',
        'agent_commercial',
        'service',
        'objet',
    ];

    protected $casts = [
        'date_impression' => 'date',
        'date_demande' => 'date',
    ];

    // ================= RELATIONS =================


    public function imprimerie(): BelongsTo
    {
        return $this->belongsTo(Imprimerie::class,'imprimerie_id');
    }

    public function demandeImpression(): BelongsTo
    {
        return $this->belongsTo(DemandeImpression::class, 'demande_impression_id');
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }


    protected static function booted()
    {
        
        static::creating(function ($gestion) {
            if (empty($gestion->numero_gestion)) {
                $prefix = 'GI-';
                $count = static::count() + 1;
                $gestion->numero_gestion = $prefix . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
                // Exemple: GI-20251103-0001
            }
        });
    }






}