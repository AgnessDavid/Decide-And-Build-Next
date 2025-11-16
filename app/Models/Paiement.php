<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'facture_id',
        'user_id',
        'client_id',
        'numero_recu',
        'date_paiement',
        'montant_paye',
        'moyen_de_paiement',
        'reference_paiement',
        'objet',
    ];

    protected $casts = [
        'date_paiement' => 'date',
        'montant_paye' => 'decimal:2',
    ];

    // Relations
    public function facture(): BelongsTo
    {
        return $this->belongsTo(Facture::class);
    }

    public function client()
{
    return $this->belongsTo(Client::class);
}


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accesseurs
    public function getFormattedMontantPayeAttribute(): string
    {
        return number_format($this->montant_paye, 2, ',', ' ') . ' FCFA';
    }

    public function getMoyenDePaiementLabelAttribute(): string
    {
        return match($this->moyen_de_paiement) {
            'especes' => 'Espèces',
            'cheque' => 'Chèque',
            'virement_bancaire' => 'Virement bancaire',
            'en_ligne' => 'Paiement en ligne',
            default => 'Inconnu'
        };
    }

    public function getDatePaiementFormattedAttribute(): string
    {
        return $this->date_paiement->format('d/m/Y');
    }

    // Mutateurs
    public function setNumeroRecuAttribute($value): void
    {
        $this->attributes['numero_recu'] = strtoupper($value);
    }

    public function setReferencePaiementAttribute($value): void
    {
        $this->attributes['reference_paiement'] = $value ? strtoupper($value) : null;
    }

    // Méthodes utilitaires
    public function estEspeces(): bool
    {
        return $this->moyen_de_paiement === 'especes';
    }

    public function estCheque(): bool
    {
        return $this->moyen_de_paiement === 'cheque';
    }

    public function estVirement(): bool
    {
        return $this->moyen_de_paiement === 'virement_bancaire';
    }

    public function estEnLigne(): bool
    {
        return $this->moyen_de_paiement === 'en_ligne';
    }

    public function necessiteReference(): bool
    {
        return in_array($this->moyen_de_paiement, ['cheque', 'virement_bancaire', 'en_ligne']);
    }

    // Scopes
    public function scopeParMoyenPaiement($query, $moyen)
    {
        return $query->where('moyen_de_paiement', $moyen);
    }

    public function scopeParFacture($query, $factureId)
    {
        return $query->where('facture_id', $factureId);
    }

    public function scopeParPeriode($query, $dateDebut, $dateFin)
    {
        return $query->whereBetween('date_paiement', [$dateDebut, $dateFin]);
    }

    public function scopeParAgent($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeEspeces($query)
    {
        return $query->where('moyen_de_paiement', 'especes');
    }

    public function scopeCheques($query)
    {
        return $query->where('moyen_de_paiement', 'cheque');
    }

    public function scopeVirements($query)
    {
        return $query->where('moyen_de_paiement', 'virement_bancaire');
    }

    public function scopeEnLigne($query)
    {
        return $query->where('moyen_de_paiement', 'en_ligne');
    }

    // Méthodes de calcul
    public static function totalParPeriode($dateDebut, $dateFin)
    {
        return static::whereBetween('date_paiement', [$dateDebut, $dateFin])
            ->sum('montant_paye');
    }

    public static function totalParMoyenPaiement($moyen, $dateDebut = null, $dateFin = null)
    {
        $query = static::where('moyen_de_paiement', $moyen);
        
        if ($dateDebut && $dateFin) {
            $query->whereBetween('date_paiement', [$dateDebut, $dateFin]);
        }
        
        return $query->sum('montant_paye');
    }

    // Événements du modèle
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($paiement) {
            // Générer automatiquement le numéro de reçu si non fourni
            if (empty($paiement->numero_recu)) {
                $paiement->numero_recu = 'REC-' . date('Y') . '-' . str_pad(
                    static::whereYear('created_at', date('Y'))->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }

            // Générer automatiquement l'objet si non fourni
            if (empty($paiement->objet) && $paiement->facture) {
                $paiement->objet = "Paiement Facture N° {$paiement->facture->numero_facture}";
            }
        });

        static::created(function ($paiement) {
            // Mettre à jour le statut de paiement de la facture
            $paiement->updateStatutFacture();
        });

        static::updated(function ($paiement) {
            // Mettre à jour le statut de paiement de la facture
            $paiement->updateStatutFacture();
        });

        static::deleted(function ($paiement) {
            // Mettre à jour le statut de paiement de la facture
            $paiement->updateStatutFacture();
        });
    }

    // Méthode pour mettre à jour le statut de la facture
    protected function updateStatutFacture(): void
    {
        $facture = $this->facture;
        if (!$facture) return;

        $totalPaiements = $facture->paiements()->sum('montant_paye');
        
        if ($totalPaiements == 0) {
            $statutPaiement = 'non_paye';
        } elseif ($totalPaiements >= $facture->montant_ttc) {
            $statutPaiement = 'paye';
        } else {
            $statutPaiement = 'partiellement_paye';
        }

        $facture->update(['statut_paiement' => $statutPaiement]);
    }

public static function genererNumeroRecu(): string
{
    $count = static::whereYear('created_at', now()->year)->count() + 1;
    return 'REC-' . now()->year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
}



    // Méthode pour générer un numéro de reçu unique
    protected static function generateNumeroRecu(): string
    {
        do {
            $numero = 'REC-' . date('Y') . '-' . str_pad(
                static::whereYear('created_at', date('Y'))->count() + 1 + rand(0, 999),
                4,
                '0',
                STR_PAD_LEFT
            );
        } while (static::where('numero_recu', $numero)->exists());

        return $numero;
    }
}