<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeProduitOnline extends Model
{
    use HasFactory;

    protected $table = 'commande_produit_online';

    protected $fillable = [
    'commande_online_id',
    'panier_id', 
    'produit_id',
    'quantite', 
    'prix_unitaire_ht',
    'montant_ht',
    'montant_ttc'];

    public function commande()
    {
        return $this->belongsTo(CommandeOnline::class, 'commande_online_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

   public function panier()
    {
        return $this->belongsTo(PanierOnline::class, 'panier_id');
    }


    
}
