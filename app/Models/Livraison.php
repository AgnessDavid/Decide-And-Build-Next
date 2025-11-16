<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Livraison extends Model
{

    protected $table = 'livraisons';
    protected $fillable = [
        'fiche_besoin_id',
        'produit_id',
        'quantite_demandee',
        'quantite_delivree',
        'livreur',
        'date_livraison',
        'statut',
        'observation',
    ];

    public function ficheBesoin(): BelongsTo
    {
        return $this->belongsTo(FicheBesoin::class, 'fiche_besoin_id');
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
