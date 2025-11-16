<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DemandeImpression extends Model
{
    use HasFactory;

    protected $table = 'demandes_impression';

    use HasFactory;

    protected $fillable = [
        'produit_id',
        'validation_id',
        'imprimerie_id',
        'nom_imprimerie',
        'type_impression',
        'nom_demandes',
        'numero_ordre',
        'designation',
        'quantite_demandee',
        'quantite_imprimee',
        'date_demande',
        'agent_commercial',
        'service',
        'objet',
        'date_visa_chef_service',
        'nom_visa_chef_service',
        'date_autorisation',
        'est_autorise_chef_informatique',
        'nom_visa_autorisateur',
        'date_impression',
    ];


    // ================== RELATIONS ==================

    /**
     * La demande appartient à une fiche de besoin
     */

    public function gestionImpression(){

        return $this->hasMany(GestionImpression::class);

    }

public function imprimeries()
{
    return $this->hasMany(Imprimerie::class, 'demande_impression_id');
}


    /**
     * La demande est liée à un produit
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }


      // Une demande peut générer plusieurs enregistrements d'imprimerie

    /**
     * Toutes les validations liées à cette demande d'impression
     */
    public function validations(): HasMany
    {
        return $this->hasMany(Validation::class, 'document_id')
                    ->where('type', 'demande_impression');
    }

    protected static function booted()
    {
        static::created(function ($demande) {
            \App\Models\Validation::create([
                'document_id' => $demande->id,
                'type' => 'demande_impression',
                'statut' => 'en_attente',
            ]);
        });


        static::creating(function ($demande) {
            // 1️⃣ Génération automatique du numéro d'ordre
            // Préfixe fixe + incrémentation simple
            $prefix = 'ORD-IMP-';
            $count = static::count() + 1;
            $demande->numero_ordre = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);

            // 2️⃣ Assignation automatique du service à partir de l'agent commercial
            if (empty($demande->service) && !empty($demande->agent_commercial)) {
                $demande->service = $demande->agent_commercial;
            }
        });


    }


    
}
