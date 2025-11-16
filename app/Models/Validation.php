<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Validation extends Model
{
    protected $fillable = [
        'document_id',
        'type',
        'user_id',
        'statut',
        'date_visa_chef_service',
        'nom_visa_chef_service',
        'date_autorisation',
        'est_autorise_chef_informatique',
        'nom_visa_autorisateur',
        'date_impression',
        'notes',
        'imprimerie_id',
        'produit_id',
        'demande_impression_id',
    ];

    protected $casts = [
        'date_visa_chef_service' => 'date',
        'date_autorisation' => 'date',
        'date_impression' => 'date',
        'est_autorise_chef_informatique' => 'boolean',
    ];

    /**
     * 🔗 Relation polymorphe avec le document validé
     */
    public function document(): MorphTo
    {
        return $this->morphTo(null, 'type', 'document_id');
    }

    /**
     * 🔗 Relation avec l'utilisateur qui valide
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔗 Relation avec le produit (ajouté)
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    /**
     * 🔗 Relation avec l'imprimerie (ajouté)
     */

    /**
     * 🔗 Relation avec la demande d'impression (ajouté)
     */
    public function demandeImpression(): BelongsTo
    {
        return $this->belongsTo(DemandeImpression::class);
    }

    /**
     * 🔗 Si c'est une validation d'une demande d'expression de besoin
     */
    public function demandeExpressionBesoin(): BelongsTo
    {
        return $this->belongsTo(DemandeExpressionBesoin::class, 'document_id')
            ->where('type', 'demande_expression_besoin');
    }

    /**
     * 🔗 Une validation peut avoir plusieurs imprimeries (relation inverse corrigée)
     */
    public function imprimeries(): HasMany
    {
        return $this->hasMany(Imprimerie::class, 'validation_id');
    }

    /**
     * ⚙️ Crée automatiquement une Imprimerie après validation
     */
    protected static function booted()
    {
        static::updated(function ($validation) {
            if ($validation->isDirty('statut') && $validation->statut === 'validée') {
                $validation->loadMissing('document');

                // Gérer les demandes d'expression de besoin
                if (
                    $validation->type === 'demandes_impression' &&
                    $validation->document instanceof \App\Models\DemandeImpression
                ) {
                    $demande = $validation->document;

                    // ✅ Vérifier que produit_id existe
                    if ($demande && $demande->produit_id) {
                        $imprimerie = \App\Models\Imprimerie::where('validation_id', $validation->id)->first();

                        $data = [
                            'validation_id' => $validation->id,
                            'demande_impression_id' => $demande->id,
                            'produit_id' => $demande->produit_id, // ✅ Garanti non-null
                            'nom_produit' => $demande->designation ?? 'Sans nom',
                            'type_impression' => $demande->type_impression ?? 'simple',
                            'quantite_demandee' => $demande->quantite_demandee,
                            'quantite_imprimee' => $demande->quantite_imprimee ?? 0,
                            'agent_commercial' => $demande->agent_commercial,
                            'service' => $demande->service,
                            'objet' => $demande->objet,
                            'date_demande' => $demande->date_demande,
                            'date_impression' => now(),
                            'statut' => 'en_cours',
                            'valide_par' => $validation->user?->name ?? 'Système',
                        ];

                        if ($imprimerie) {
                            $imprimerie->update($data);
                        } else {
                            \App\Models\Imprimerie::create($data);
                        }

                        if ($demande->getConnection()->getSchemaBuilder()->hasColumn($demande->getTable(), 'date_validation')) {
                            $demande->update(['date_validation' => now()]);
                        }
                    } else {
                        // ✅ Logger l'erreur si pas de produit_id
                        \Log::warning("DemandeImpression #{$demande->id} sans produit_id - Imprimerie non créée");
                    }
                }

                // Gérer les demandes d'impression classiques
                if (
                    $validation->type === 'demande_impression' &&
                    $validation->document instanceof \App\Models\DemandeImpression
                ) {
                    $demande = $validation->document;

                    // ✅ Vérifier que produit_id existe
                    if ($demande && $demande->produit_id) {
                        $imprimerie = \App\Models\Imprimerie::where('validation_id', $validation->id)->first();

                        $data = [
                            'validation_id' => $validation->id,
                            'demande_impression_id' => $demande->id,
                            'produit_id' => $demande->produit_id, // ✅ Garanti non-null
                            'nom_produit' => $demande->designation ?? $demande->nom_demandes ?? 'Sans nom',
                            'type_impression' => $demande->type_impression ?? 'simple',
                            'quantite_demandee' => $demande->quantite_demandee,
                            'quantite_imprimee' => $demande->quantite_imprimee ?? 0,
                            'agent_commercial' => $demande->agent_commercial,
                            'service' => $demande->service,
                            'objet' => $demande->objet,
                            'date_demande' => $demande->date_demande,
                            'date_impression' => $demande->date_impression ?? now(),
                            'statut' => 'en_cours',
                            'valide_par' => $validation->user?->name ?? 'Système',
                            'operateur' => $demande->nom_imprimerie,
                        ];

                        if ($imprimerie) {
                            $imprimerie->update($data);
                        } else {
                            \App\Models\Imprimerie::create($data);
                        }
                    } else {
                        // ✅ Logger l'erreur si pas de produit_id
                        \Log::warning("DemandeImpression #{$demande->id} sans produit_id - Imprimerie non créée");
                    }
                }
            }
        });
    }
}