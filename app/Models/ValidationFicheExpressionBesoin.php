<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\ActionGroup;
use App\Notifications\FicheValideeNotification;
class ValidationFicheExpressionBesoin extends Model
{
    use HasFactory;

    protected $table = 'validation_fiches_expression_besoin';

    protected $fillable = [
       
        'fiche_besoin_id',
        'user_id',
        'valide',
        'commentaire',
        'date_validation',
        'num_validation', 
    ];

    // Relation avec la fiche d'expression de besoin

    public function ficheBesoin()
    {
        return $this->belongsTo(FicheBesoin::class, 'fiche_besoin_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
    // Relation avec l'utilisateur qui valide
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔹 Relation vers la demande générée
    public function demandeExpression()
    {
        return $this->hasOne(DemandeExpressionBesoin::class, 'demandes_expression_besoin_id', 'fiche_besoin_id'  );
    }

    public function imprimerieExpressionBesoins(){

        return $this->hasMany(ImprimerieExpressionBesoin::class);
    }

    // 🔹 Synchroniser automatiquement avec DemandeExpressionBesoin
    protected static function booted()
    {


        static::updated(function ($validation) {
            if ($validation->valide && !DemandeExpressionBesoin::where('validation_fiches_expression_besoin_id', $validation->id)->exists()) {

                // Créer la demande d'expression de besoin
                $demandeExpressionBesoin = DemandeExpressionBesoin::create([
                    'fiche_besoin_id' => $validation->fiche_besoin_id,
                    'validation_fiches_expression_besoin_id' => $validation->id,
                    'produit_id' => null,
                    'quantite_demandee' => $validation->quantite_demandee,
                    'numero_ordre' => null,
                    'designation' => $validation->produit_souhaite,
                    'type_impression' => 'simple',
                    'date_demande' => now(),
                    'agent_commercial' => null,
                    'service' => null,
                    'objet' => $validation->objectifs_vises,
                ]);

                $ficheBesoin = FicheBesoin::find($validation->fiche_besoin_id);

                // ✅ Créer avec statut 'en_cours'
                $imprimerieExpression = ImprimerieExpressionBesoin::create([
                    'demande_expression_besoin_id' => $demandeExpressionBesoin->id,
                    'produit_id' => $ficheBesoin->produit_id ?? $validation->produit_id ?? null,
                    'nom_produit' => $ficheBesoin->produit_souhaite ?? $validation->produit_souhaite ?? null,
                    'quantite_demandee' => $ficheBesoin->quantite_demandee ?? $validation->quantite_demandee ?? 0,
                    'quantite_imprimee' => $ficheBesoin->quantite_imprimee ?? $validation->quantite_imprimee ?? 0,
                    'valide_par' => $validation->user?->name ?? 'Système',
                    'operateur' => null,
                    'date_impression' => null, // Pas encore imprimé
                    'type_impression' => $ficheBesoin->type_impression ?? 'simple',
                    'statut' => 'en_cours', // ✅ Commence en 'en_cours'
                    'agent_commercial' => $ficheBesoin->agent_commercial ?? null,
                    'service' => $ficheBesoin->service ?? 'Service informatique',
                    'objet' => $ficheBesoin->objet ?? $validation->objectifs_vises ?? null,
                    'date_demande' => now(),
                    'date_mouvement' => now(),
                    'numero_imprimerie_expression' => 'IMEX-' . now()->format('Ymd') . '-' . str_pad(ImprimerieExpressionBesoin::count() + 1, 4, '0', STR_PAD_LEFT),
                ]);



                // ✅ Notification de validation
                // ✅ Notification simplifiée sans action (Filament 4)
                // ✅ Envoyer la notification avec la méthode qui fonctionne
                if ($validation->user) {
                    $validation->user->notify(
                        new FicheValideeNotification($imprimerieExpression->numero_imprimerie_expression)
                    );
                }

            }
        });

 }
}
