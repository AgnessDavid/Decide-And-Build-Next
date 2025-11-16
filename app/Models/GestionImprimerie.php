<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produit;

class GestionImprimerie extends Model
{
    use HasFactory;

    protected $table = 'gestion_imprimeries';

    protected $fillable = [
        'produit_id',
        'designation',
        'quantite_entree',
        'quantite_sortie',
        'date_mouvement',
        'numero_bon',
        'type_mouvement',
        'stock_resultant',
        'details',
        'imprimeries_expression_besoin_id',
        'demande_expression_besoin_id', // ✅ Ajouté
        'quantite_demandee',
        'quantite_imprimee',
        'stock_minimum',
        'stock_maximum',
        'stock_actuel',
        'numero_impremerie_gestion',
       
    ];

    protected $casts = [
        'date_mouvement' => 'date',
        'date_impression' => 'date',
        'date_demande' => 'date',
    ];

    // ================== RELATIONS ==================

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function imprimerieExpressionBesoin()
    {
        return $this->belongsTo(ImprimerieExpressionBesoin::class, 'imprimeries_expression_besoin_id');
    }

    public function demandeExpressionBesoin()
    {
        return $this->belongsTo(DemandeExpressionBesoin::class, 'demande_expression_besoin_id');
    }

    // ================== MISE À JOUR AUTOMATIQUE DU STOCK ==================

    protected static function booted()
    {
        // Hook 1 : Génération automatique des numéros et remplissage des données
        static::saving(function ($gestion) {
            // Générer le numéro si nouveau ou vide
            if (empty($gestion->numero_impremerie_gestion)) {
                $gestion->numero_impremerie_gestion = 'GEST-' . now()->format('Ymd') . '-' . str_pad(GestionImprimerie::count() + 1, 4, '0', STR_PAD_LEFT);
            }

            // Générer la date de mouvement si vide
            if (empty($gestion->date_mouvement)) {
                $gestion->date_mouvement = now();
            }

            // Récupérer les données depuis ImprimerieExpressionBesoin si disponible
            if ($gestion->imprimeries_expression_besoin_id && !$gestion->exists) {
                $imprimerie = ImprimerieExpressionBesoin::with('demandeExpressionBesoin.ficheBesoin')
                    ->find($gestion->imprimeries_expression_besoin_id);

                if ($imprimerie) {
                    $ficheBesoin = $imprimerie->demandeExpressionBesoin?->ficheBesoin;

                    // Remplir automatiquement les données depuis fiche_besoin et imprimerie
                    $gestion->produit_id = $gestion->produit_id ?? $imprimerie->produit_id ?? $ficheBesoin?->produit_id;
                    $gestion->designation = $gestion->designation ?? $imprimerie->nom_produit ?? $ficheBesoin?->produit_souhaite;
                    $gestion->quantite_demandee = $gestion->quantite_demandee ?? $imprimerie->quantite_demandee ?? $ficheBesoin?->quantite_demandee;
                    $gestion->quantite_imprimee = $gestion->quantite_imprimee ?? $imprimerie->quantite_imprimee;
                }
            }

            if ($gestion->produit) {
                // Sécuriser les valeurs null -> 0
                $stockActuel = $gestion->stock_actuel ?? $gestion->produit->stock_actuel ?? 0;
                $stockMin = $gestion->stock_minimum ?? $gestion->produit->stock_minimum ?? 0;
                $stockMax = $gestion->stock_maximum ?? $gestion->produit->stock_maximum ?? 0;

                // Calcul du stock_resultant
                $gestion->stock_resultant = $stockActuel;

                // Mise à jour du produit
                $gestion->produit->update([
                    'stock_actuel' => $gestion->stock_resultant,
                    'stock_minimum' => $stockMin,
                    'stock_maximum' => $stockMax,
                ]);
            }
        });
    }
}