<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionCaisse extends Model
{
    protected $table = 'session_caisses';

    protected $fillable = [
        'user_id',
        'caisse_id',
        'numero_session_caisse',
        'solde_initial',
        'solde_final',
        'statut',
        'ouvert_le',
        'ferme_le',
        'entrees',
        'sorties',
    ];

    protected $casts = [
        'ouvert_le' => 'datetime',
        'ferme_le' => 'datetime',
        'solde_initial' => 'float',
        'solde_final' => 'float',
        'entrees' => 'float',
        'sorties' => 'float',
    ];

    // Relation avec l'utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // CORRECTION : Relation avec la caisse (au singulier)
    public function caisse(): BelongsTo
    {
        return $this->belongsTo(Caisse::class, 'caisse_id');
    }




    public function depenses()
    {
        return $this->hasMany(Depense::class, 'session_caisse_id');
    }


    // Supprimez ces méthodes si vous n'en avez pas besoin
    // ou corrigez-les si vous voulez vraiment une relation hasMany
    /*
    public function getTotalEntreeAttribute()
    {
        return $this->caisse->nombre_total_entree ?? 0;
    }

    public function getTotalSortieAttribute()
    {
        return $this->caisse->nombre_total_sortie ?? 0;
    }
    */

    // Hook pour calculer automatiquement le solde final
    protected static function booted()
    {
        // Génération automatique du numéro de session caisse
        static::creating(function ($session) {
            if (!$session->numero_session_caisse) {
                $session->numero_session_caisse = 'SC-' . now()->format('YmdHis');
            }
        });

        // Calcul automatique du solde final
        static::saving(function ($session) {
            $session->solde_final = (($session->solde_initial ?? 0) + ($session->entrees ?? 0)) - ($session->sorties ?? 0);
        });
    }
}