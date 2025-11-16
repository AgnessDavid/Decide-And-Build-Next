<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Important pour Auth
use Illuminate\Notifications\Notifiable;

class Online extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nom de la table si différent de "onlines"
    protected $table = 'onlines';

    // Colonnes autorisées à la création/mise à jour
    protected $fillable = [
        'name',       // nom de l'utilisateur
        'email',      // email
        'password',   // mot de passe
    ];

    // Cacher certains champs lors de la sérialisation (ex: API)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Type de données pour certains champs
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function paniers()
    {
        return $this->hasMany(PanierOnline::class);
    }

    public function commandes()
    {
        return $this->hasMany(CommandeOnline::class);
    }

    public function caisses()
    {
        return $this->hasMany(CaisseOnline::class);
    }

    public function paiements()
    {
        return $this->hasManyThrough(PaiementOnline::class, CaisseOnline::class);
    }

    public function livraisons()
    {
        return $this->hasMany(LivraisonOnline::class);
    }

    // Relation avec les commandes en ligne
    public function commandesOnline()
    {
        return $this->hasMany(CommandeOnline::class, 'online_id');
    }

    // Méthode pour récupérer la commande en cours
    public function commandeEnCoursOnline()
    {
        return $this->commandesOnline()->where('etat', 'en_cours');
    }



}
