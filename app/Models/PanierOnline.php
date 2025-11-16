<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanierOnline extends Model
{
    use HasFactory;

    protected $table = 'panier_online';

    protected $fillable = ['online_id', 'produit_id', 'quantite', 'prix_unitaire_ht', 'session_id', 'statut'];

    public function online()
    {
        return $this->belongsTo(Online::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function commandeProduits()
    {
        return $this->hasMany(CommandeProduitOnline::class, 'panier_id');
    }
}
