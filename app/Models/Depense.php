<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $table = 'depenses'; // nom de la table au pluriel

    protected $fillable = [
        'designation',
        'montant',
        'montant_total',
        'date_depense',
        'categorie',
        'details',
    ];


    // Dans Depense.php  
    public function sessionCaisse()
    {
        return $this->belongsTo(SessionCaisse::class, 'session_caisse_id');
    }



    protected static function booted()
    {
        static::creating(function ($depense) {
            // Récupérer le dernier montant total
            $dernierMontantTotal = static::latest('id')->value('montant_total') ?? 0;

            // Calculer le nouveau montant total
            $depense->montant_total = $dernierMontantTotal + $depense->montant;
        });
    }
}
