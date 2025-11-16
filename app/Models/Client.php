<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nom',
        'type',
        'nom_interlocuteur',
        'fonction',
        'telephone',
        'cellulaire',
        'fax',
        'email',
        'ville',
        'quartier_de_residence',
        'usage',
        'domaine_activite',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'type' => 'string',
        'usage' => 'string',
    ];

    /**
     * Types de clients disponibles
     */
    public const TYPES = [
        'societe' => 'Société',
        'organisme' => 'Organisme',
        'particulier' => 'Particulier',
    ];

    /**
     * Types d'usage disponibles
     */
    public const USAGES = [
        'personnel' => 'Personnel',
        'professionnel' => 'Professionnel',
    ];

    /**
     * Relation avec les fiches de besoin
     */
    public function fichesBesoin(): HasMany
    {
        return $this->hasMany(FicheBesoin::class);
    }

    public function paiements()
{
    return $this->hasManyThrough(Paiement::class, Facture::class, 'commande_id', 'facture_id');
}


  

    /**
     * Scope pour filtrer par type de client
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope pour les sociétés
     */
    public function scopeSocietes($query)
    {
        return $query->where('type', 'societe');
    }

    /**
     * Scope pour les organismes
     */
    public function scopeOrganismes($query)
    {
        return $query->where('type', 'organisme');
    }

    /**
     * Scope pour les particuliers
     */
    public function scopeParticuliers($query)
    {
        return $query->where('type', 'particulier');
    }

    /**
     * Scope pour filtrer par ville
     */
    public function scopeVille($query, $ville)
    {
        return $query->where('ville', 'like', '%' . $ville . '%');
    }

    /**
     * Accessor pour afficher le type de client de façon lisible
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    /**
     * Accessor pour afficher l'usage de façon lisible
     */
    public function getUsageLabelAttribute(): ?string
    {
        return $this->usage ? (self::USAGES[$this->usage] ?? $this->usage) : null;
    }

    /**
     * Accessor pour obtenir le nom complet (nom + interlocuteur si existe)
     */
    public function getNomCompletAttribute(): string
    {
        if ($this->nom_interlocuteur) {
            return $this->nom . ' - ' . $this->nom_interlocuteur;
        }
        return $this->nom;
    }

    /**
     * Accessor pour obtenir le contact principal
     */
    public function getContactPrincipalAttribute(): ?string
    {
        return $this->cellulaire ?: $this->telephone;
    }

    /**
     * Mutateur pour formater le nom en titre
     */
    public function setNomAttribute($value)
    {
        $this->attributes['nom'] = ucwords(strtolower($value));
    }

    /**
     * Mutateur pour formater le nom de l'interlocuteur
     */
    public function setNomInterlocuteurAttribute($value)
    {
        $this->attributes['nom_interlocuteur'] = $value ? ucwords(strtolower($value)) : null;
    }

    /**
     * Mutateur pour formater l'email en minuscules
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value ? strtolower($value) : null;
    }

    /**
     * Mutateur pour formater la ville
     */
    public function setVilleAttribute($value)
    {
        $this->attributes['ville'] = $value ? ucwords(strtolower($value)) : null;
    }

    /**
     * Vérifier si le client est une société
     */
    public function isSociete(): bool
    {
        return $this->type === 'societe';
    }

    /**
     * Vérifier si le client est un organisme
     */
    public function isOrganisme(): bool
    {
        return $this->type === 'organisme';
    }

    /**
     * Vérifier si le client est un particulier
     */
    public function isParticulier(): bool
    {
        return $this->type === 'particulier';
    }

    /**
     * Obtenir les informations de contact formatées
     */
    public function getInfosContactAttribute(): array
    {
        $contacts = [];

        if ($this->telephone) $contacts[] = 'Tél: ' . $this->telephone;
        if ($this->cellulaire) $contacts[] = 'Cel: ' . $this->cellulaire;
        if ($this->email) $contacts[] = 'Email: ' . $this->email;
        if ($this->fax) $contacts[] = 'Fax: ' . $this->fax;

        return $contacts;
    }
}

