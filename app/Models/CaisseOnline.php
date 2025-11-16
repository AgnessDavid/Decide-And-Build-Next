<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaisseOnline extends Model
{
    use HasFactory;

    protected $table = 'caisse_online';

    protected $fillable = [
        'commande_online_id',
        'online_id',
        'montant_ht',
        'tva',
        'montant_ttc',
        'entree',
        'sortie',
        'statut_paiement',
        'methode_paiement'
    ];


    public function online()
    {
        return $this->belongsTo(Online::class,'online_id');
    }


    public function commande()
    {
        return $this->belongsTo(CommandeOnline::class, 'commande_online_id');
    }

    public function paiement()
    {
        return $this->hasOne(PaiementOnline::class, 'caisse_online_id');
    }


}
