<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DemandeExpressionBesoin extends Model
{
    use HasFactory;

    protected $table = 'demandes_expression_besoins';

    protected $fillable = [
        'validation_fiche_expression_besoin_id', // CORRIGÉ
        'produit_id',
        'quantite_demandee',
        'numero_ordre',
        'designation',
        'type_impression',
        'date_demande',
        'agent_commercial',
        'service',
        'objet',
        'quantite_imprimee',
    ];

    protected $casts = [
        'date_demande' => 'date',
    ];

    public function ficheBesoin()
    {
        return $this->belongsTo(FicheBesoin::class, 'fiche_besoin_id');
    }
    // RELATION : Appartient à une validation
    public function validationFiche(): BelongsTo
    {
        return $this->belongsTo(
            ValidationFicheExpressionBesoin::class,
            'validation_fiche_expression_besoin_id' // CORRIGÉ
        );
    }

    // RELATION : Appartient à un produit
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    // RELATION : A plusieurs impressions
    public function imprimeries(): HasMany
    {
        return $this->hasMany(ImprimerieExpressionBesoin::class, 'demande_expression_besoin_id');
    }

    // ACCESSEUR : Statut de la demande
    public function getStatutAttribute(): string
    {
        return $this->validationFiche?->valide ? 'Validée' : 'En attente';
    }

    // MÉTHODE : Est-ce que c'est imprimé ?
    public function estImprimee(): bool
    {
        return $this->quantite_imprimee > 0;
    }
}