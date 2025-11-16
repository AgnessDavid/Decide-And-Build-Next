<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Notifications\ImpressionTermineeNotification;
class ImprimerieExpressionBesoin extends Model
{
    use HasFactory;

    protected $table = 'imprimeries_expression_besoins';

    protected $fillable = [
        'demande_expression_besoin_id',
        'produit_id',
        'nom_produit',
        'quantite_demandee',
        'quantite_imprimee',
        'valide_par',
        'operateur',
        'date_impression',
        'type_impression',
        'statut',
        'agent_commercial',
        'service',
        'objet',
        'date_demande',
        'numero_imprimerie_expression',
    ];

    protected $casts = [
        'date_demande' => 'date',
        'date_impression' => 'date',
    ];

    // ================== RELATIONS ==================
    public function demandeExpressionBesoin(): BelongsTo
    {
        return $this->belongsTo(DemandeExpressionBesoin::class, 'demande_expression_besoin_id');
    }

    public function gestionImprimeries()
    {
        return $this->hasMany(GestionImprimerie::class, 'imprimeries_expression_besoin_id');
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validationExpression()
    {
        return $this->belongsTo(ValidationFicheExpressionBesoin::class);
    }

    // ================== AUTOMATISATION ==================

    protected static function booted()
    {
        // Hook 1 : Générer le numéro d'imprimerie expression automatiquement
        static::creating(function ($imprimerieExpression) {
            if (empty($imprimerieExpression->numero_imprimerie_expression)) {
                $imprimerieExpression->numero_imprimerie_expression = 'IMEX-' . now()->format('Ymd') . '-' . str_pad(
                    ImprimerieExpressionBesoin::count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });

        // Hook 2 : Créer une fiche dans GestionImprimerie quand statut = 'terminee'
        static::updated(function ($imprimerieExpression) {
            // Vérifier si le statut vient de changer vers 'terminee'
            if (
                $imprimerieExpression->isDirty('statut') &&
                $imprimerieExpression->statut === 'terminee' &&
                $imprimerieExpression->produit_id
            ) {

                $data = [
                    'imprimeries_expression_besoin_id' => $imprimerieExpression->id,
                    'demande_expression_besoin_id' => $imprimerieExpression->demande_expression_besoin_id,
                    'produit_id' => $imprimerieExpression->produit_id,
                    'designation' => $imprimerieExpression->nom_produit,
                    'quantite_demandee' => $imprimerieExpression->quantite_demandee,
                    'quantite_imprimee' => $imprimerieExpression->quantite_imprimee,
                    'date_mouvement' => now(),
                ];

                // Créer uniquement si n'existe pas déjà
                GestionImprimerie::firstOrCreate(
                    ['imprimeries_expression_besoin_id' => $imprimerieExpression->id],
                    $data
                );

                // ✅ Notification (à l'intérieur du hook updated)
              /*  if (auth()->check()) {
                    auth()->user()->notify(
                        (new ImpressionTermineeNotification($imprimerieExpression->numero_imprimerie_expression))
                            ->delay(now()->addHours(2))
                    );
                } */
            }
        });
    }





    
}