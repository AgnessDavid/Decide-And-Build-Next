<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Imprimerie extends Model
{
    protected $fillable = [
        'validation_id',
        'demande_impression_id',  // ← Corrigé
        'produit_id',
        'numero_impression',      // ← Ajouté
        'nom_fiche_besoin',
        'nom_produit',
        'type_impression',
        'quantite_demandee',
        'quantite_imprimee',
        'agent_commercial',
        'service',
        'objet',
        'date_demande',
        'date_impression',
        'statut',
        'valide_par',
        'operateur',              // ← Ajouté
    ];

    protected $casts = [
        'date_demande' => 'date',
        'date_impression' => 'date',
    ];

    // ================== RELATIONS ==================

    public function demandeImpression(): BelongsTo
    {
        return $this->belongsTo(DemandeImpression::class, 'demande_impression_id');
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function validation(): BelongsTo
    {
        return $this->belongsTo(Validation::class);
    }

    public function gestionImpressions(): HasMany
    {
        return $this->hasMany(GestionImpression::class, 'imprimerie_id');
    }

    // ================== LIFECYCLE HOOKS ==================

    protected static function booted()
    {
        static::creating(function ($imprimerie) {
            if ($imprimerie->demande_impression_id) {
                $demande = DemandeImpression::find($imprimerie->demande_impression_id);
                if ($demande) {
                    $imprimerie->produit_id = $demande->produit_id;
                    $imprimerie->nom_produit = $demande->designation;
                    $imprimerie->type_impression = $demande->type_impression;
                    $imprimerie->quantite_demandee = $demande->quantite_demandee;
                    $imprimerie->quantite_imprimee = $demande->quantite_imprimee ?? 0;
                    $imprimerie->agent_commercial = $demande->agent_commercial;
                    $imprimerie->service = $demande->service;
                    $imprimerie->objet = $demande->objet;
                    $imprimerie->date_demande = $demande->date_demande;
                    $imprimerie->date_impression = now();
                    $imprimerie->statut = 'en_cours';
                }
            }
        });


        static::creating(function ($imprimerie) {
            if (empty($imprimerie->numero_impression)) {
                $imprimerie->numero_impression = 'IMP-' . now()->format('Ymd') . '-' . str_pad(
                    Imprimerie::count() + 1, // ✅ Utiliser Imprimerie, pas ImprimerieExpressionBesoin
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });

        // ✅ Synchroniser à chaque création OU mise à jour
        static::saved(function ($imprimerie) {
            // Ne synchroniser que si le statut est "terminee"
            if ($imprimerie->statut === 'terminee') {

                $data = [
                    'imprimerie_id' => $imprimerie->id,
                    'demande_impression_id' => $imprimerie->demande_impression_id,
                    'produit_id' => $imprimerie->produit_id,
                    'nom_produit' => $imprimerie->nom_produit,
                    'quantite_demandee' => $imprimerie->quantite_demandee,
                    'quantite_imprimee' => $imprimerie->quantite_imprimee,
                    'type_impression' => $imprimerie->type_impression,
                    'statut' => $imprimerie->statut,
                    'date_impression' => $imprimerie->date_impression ?? now(),
                    'date_demande' => $imprimerie->date_demande,
                    'valide_par' => $imprimerie->valide_par,
                    'operateur' => $imprimerie->operateur,
                    'agent_commercial' => $imprimerie->agent_commercial,
                    'service' => $imprimerie->service,
                    'objet' => $imprimerie->objet,
                ];

                GestionImpression::updateOrCreate(
                    ['imprimerie_id' => $imprimerie->id],
                    $data
                );
            }
        });


 

    }
}