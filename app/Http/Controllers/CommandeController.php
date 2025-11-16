<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\CommandeOnline;
use App\Models\PanierOnline;
use App\Models\CommandeProduitOnline;
use App\Models\LivraisonOnline;
use App\Models\CaisseOnline;
use App\Models\PaiementOnline;
use App\Enums\CategoriePaiement;
use App\Enums\MoyenPaiement;

use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Afficher le panier de l'utilisateur connecté
     */
    public function afficherPanier()
    {
        if (!auth()->check()) {
            return redirect()->route('online.login')->with('error', 'Veuillez vous connecter pour voir votre panier.');
        }

        $client = auth()->user();

        $commande = $client->commandeEnCoursOnline()->first();

        if (!$commande) {
            $commande = CommandeOnline::create([
                'online_id' => $client->id,
                'etat' => 'en_cours',
            ]);
        }

        // Récupérer la livraison si elle existe
        $livraison = LivraisonOnline::where('online_id', $client->id)
            ->where('type', 'livraison')
            ->first();
        return view('panier', compact('commande', 'livraison'));
    }

    /**
     * Ajouter un produit au panier
     */
    public function ajouterQuantite(Request $request, Produit $produit)
    {
        $clientId = auth()->id();

        // Récupérer ou créer le panier en cours
        $panier = PanierOnline::firstOrCreate(
            ['online_id' => $clientId, 'produit_id' => $produit->id, 'statut' => 'actif'],
            ['quantite' => 0, 'prix_unitaire_ht' => $produit->prix_unitaire_ht]
        );

        // Incrémenter la quantité
        $panier->quantite += 1;
        $panier->save();

        // Créer ou récupérer la ligne de commande correspondante
        $ligne = CommandeProduitOnline::firstOrCreate(
            [
                'commande_online_id' => CommandeOnline::firstOrCreate(
                    ['online_id' => $clientId, 'etat' => 'en_cours']
                )->id,
                'produit_id' => $produit->id,
            ],
            [
                'quantite' => 0,
                'prix_unitaire_ht' => $produit->prix_unitaire_ht,
                'montant_ht' => 0,
                'montant_ttc' => 0,
                'panier_id' => $panier->id, // ⚡ lie la ligne au panier
            ]
        );

        // Mettre à jour les montants
        $ligne->quantite += 1;
        $ligne->montant_ht = $ligne->quantite * $ligne->prix_unitaire_ht;
        $ligne->montant_ttc = $ligne->montant_ht * 1.18; // TVA 18%
        $ligne->save();

        return redirect()->route('panier')->with('success', "Produit {$produit->nom_produit} ajouté au panier !");
    }


    /**
     * Réduire la quantité d’un produit
     */
    public function reduireQuantite(Request $request, Produit $produit)
    {
        // Récupère la commande en cours pour l'utilisateur
        $commande = CommandeOnline::where('online_id', auth()->id())
            ->where('etat', 'en_cours')
            ->first();

        if (!$commande) {
            return back()->with('error', 'Aucune commande en cours.');
        }

        // Récupère la ligne de commande correspondante
        $ligne = CommandeProduitOnline::where('commande_online_id', $commande->id)
            ->where('produit_id', $produit->id)
            ->first();

        if ($ligne) {
            // Quantité à réduire (par défaut 1)
            $quantite = (int) $request->input('quantite', 1);
            $ligne->quantite -= $quantite;

            if ($ligne->quantite <= 0) {
                // Supprime la ligne si quantité <= 0
                $ligne->delete();
            } else {
                // Recalcul automatique des montants
                $ligne->montant_ht = $ligne->quantite * $ligne->prix_unitaire_ht;
                $ligne->montant_ttc = $ligne->montant_ht * (1 + ($produit->taux_tva ?? 0) / 100);
                $ligne->save();
            }
        }
        return redirect()->route('panier')->with('success', "Produit {$produit->nom_produit} ajouté au panier !");
    }


    /**
     * Supprimer complètement un produit
     */
    public function supprimerProduit(Produit $produit)
    {
        $commande = CommandeOnline::where('online_id', auth()->id())
            ->where('etat', 'en_cours')
            ->first();

        if (!$commande)
            return back();

        $ligne = CommandeProduitOnline::where('commande_online_id', $commande->id)
            ->where('produit_id', $produit->id)
            ->first();

        if ($ligne)
            $ligne->delete();

        return back()->with('error', "{$produit->nom_produit} supprimé du panier");
    }

    /**
     * Vider tout le panier
     */
    public function viderPanier()
    {
        $commande = CommandeOnline::where('online_id', auth()->id())
            ->where('etat', 'en_cours')
            ->first();

        if ($commande) {
            $commande->produits()->detach(); // relation Many-to-Many
        }

        return back()->with('success', 'Panier vidé avec succès');
    }


    public function validerCommande(Request $request)
    {
        // Vérifie si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('online.login')->with('error', 'Veuillez vous connecter pour valider votre commande.');
        }

        $clientId = auth()->id();

        $request->validate([
            'adresse_livraison' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'numero_tel' => 'required|string|max:20',
            'instructions' => 'nullable|string|max:255',
            'mode_paiement' => 'required|in:' . implode(',', [
                MoyenPaiement::ESPECES->value,
                MoyenPaiement::WAVE->value,
                MoyenPaiement::MOOV_MONEY->value,
                MoyenPaiement::MTN_MONEY->value,
                MoyenPaiement::ORANGE_MONEY->value,
                MoyenPaiement::PAYPAL->value,
                MoyenPaiement::STRIPE->value,
                MoyenPaiement::CARTE->value,
                MoyenPaiement::BITCOIN->value,
                MoyenPaiement::ETHEREUM->value,
            ]),
        ]);

        // ✅ Définit $mode après validation
        $mode = $request->input('mode_paiement');

        // Récupère la commande en cours du client
        $commande = CommandeOnline::where('online_id', $clientId)
            ->where('etat', 'en_cours')
            ->first();

        if (!$commande) {
            return redirect()->route('panier')->with('error', 'Aucune commande en cours.');
        }

        if ($commande->produits()->count() === 0) {
            return redirect()->route('panier')->with('error', 'Votre panier est vide.');
        }

        // Enregistrer ou mettre à jour les informations de livraison
        $livraison = LivraisonOnline::updateOrCreate(
            [
                'online_id' => $clientId,
                'type' => 'livraison',
            ],
            [
                'adresse' => $request->adresse_livraison,
                'ville' => $request->ville,
                'code_postal' => $request->code_postal,
                'numero_tel' => $request->numero_tel,
                'instructions' => $request->instructions,
                'pays' => 'Côte d\'Ivoire', // tu peux aussi le récupérer via un champ formulaire
            ]
        );

        // Calcul du montant total
        $montantTotalHT = $commande->produits->sum(fn($produit) => $produit->pivot->quantite * $produit->pivot->prix_unitaire_ht);
        $montantTotalTTC = $montantTotalHT * 1.18;

        // Création de la caisse
        $caisse = CaisseOnline::create([
            'commande_online_id' => $commande->id,
            'online_id' => $clientId,
            'montant_ht' => $montantTotalHT,
            'tva' => $montantTotalHT * 0.18,
            'montant_ttc' => $montantTotalTTC,
            'statut_paiement' => 'impayé',
        ]);

        // Détermination de la catégorie correctement
        $categorie = null;
        if (in_array($mode, [MoyenPaiement::ESPECES->value])) {
            $categorie = CategoriePaiement::ESPECES->value;
        } elseif (
            in_array($mode, [
                MoyenPaiement::WAVE->value,
                MoyenPaiement::MOOV_MONEY->value,
                MoyenPaiement::MTN_MONEY->value,
                MoyenPaiement::ORANGE_MONEY->value
            ])
        ) {
            $categorie = CategoriePaiement::MOBILE_MONEY->value;
        } elseif (
            in_array($mode, [
                MoyenPaiement::PAYPAL->value,
                MoyenPaiement::STRIPE->value,
                MoyenPaiement::CARTE->value
            ])
        ) {
            $categorie = CategoriePaiement::EN_LIGNE->value;
        } elseif (
            in_array($mode, [
                MoyenPaiement::BITCOIN->value,
                MoyenPaiement::ETHEREUM->value
            ])
        ) {
            $categorie = CategoriePaiement::CRYPTO->value;
        }

        // Création du paiement
        $paiement = PaiementOnline::create([
            'caisse_online_id' => $caisse->id,
            'montant' => $caisse->montant_ttc,
            'mode_paiement' => $mode,
            'categorie' => $categorie,
            'statut' => 'en_attente',
            'reference_transaction' => 'TXN-' . strtoupper(uniqid()),
        ]);


        // 🔄 Mettre à jour la commande
        $commande->update([
            'etat' => 'validee',
            'total_ht' => $montantTotalHT,
            'total_ttc' => $montantTotalTTC,
            'numero_commande' => 'CMD-' . strtoupper(uniqid()),
            'adresse_livraison_id' => $livraison->id,
        ]);

        return redirect()->route('resume', ['id' => $commande->id])
            ->with('success', 'Votre commande a été validée avec succès !');
    }


    public function afficherPaiement($commandeId)
    {
        $commande = CommandeOnline::with([
            'produits',   // produits du panier
            'livraison',  // infos livraison
            'paiement',   // paiement associé
            'caisse'      // infos caisse
        ])->findOrFail($commandeId);

        $mode = $commande->paiement?->mode_paiement ?? null;

        // Résumé du panier
        $panierDetails = $commande->produits->map(function ($produit) {
            return [
                'nom' => $produit->nom,
                'quantite' => $produit->pivot->quantite ?? 1,
                'prix_unitaire' => $produit->prix ?? 0,
                'total' => ($produit->prix ?? 0) * ($produit->pivot->quantite ?? 1)
            ];
        });

        $showWaveQr = $mode === MoyenPaiement::WAVE->value;
       
        return view('paiement', compact('commande', 'mode', 'panierDetails', 'showWaveQr'));
    }

    private function synchroniserPaiementCommande(CaisseOnline $caisse, CommandeOnline $commande, $montantPaye = null)
    {
        $montantPaye ??= $commande->total_ttc;

        // 1️⃣ Mettre à jour la commande
        $commande->statut_paiement = 'payé';
        $commande->etat = 'validee';
        $commande->save();

        // 2️⃣ Mettre à jour ou créer la caisse
        $caisse->commande_online_id = $commande->id;
        $caisse->montant_ttc = $montantPaye;
        $caisse->statut_paiement = $commande->statut_paiement;
        $caisse->save();

        // 3️⃣ Mettre à jour ou créer le paiement associé
        $paiement = $caisse->paiement;
        if (!$paiement) {
            $paiement = PaiementOnline::create([
                'caisse_online_id' => $caisse->id,
                'montant' => $caisse->montant_ttc,
                'mode_paiement' => $commande->paiement?->mode_paiement ?? 'wave', // ✅ Valeur par défaut valide
                'categorie' => $commande->paiement?->categorie ?? 'en_ligne', // ✅ Valeur par défaut valide
                'statut' => 'réussi', // ✅ CORRIGÉ : 'réussi' au lieu de 'validée'
                'reference_transaction' => 'TXN-' . strtoupper(uniqid()),
            ]);
        } else {
            $paiement->statut = 'réussi';
            $paiement->save();
        }

        return [$commande, $caisse, $paiement];
    }

    public function traiterPaiement(Request $request, $id)
    {
        $commande = CommandeOnline::with(['caisse', 'paiement'])->findOrFail($id);

        $montantPaye = $request->filled('montant') ? $request->montant : $commande->total_ttc;

        if ($request->filled('montant') && $request->montant != $commande->total_ttc) {
            return back()->with('error', 'Le montant payé ne correspond pas au total de la commande.');
        }

        $caisse = $commande->caisse ?? new CaisseOnline();

        [$commande, $caisse, $paiement] = $this->synchroniserPaiementCommande($caisse, $commande, $montantPaye);

        return redirect()->route('confirmer.wave', ['commande' => $commande->id])
            ->with('success', 'Paiement confirmé et synchronisé !');
    }

    public function validerWave(Request $request, $commandeId)
    {
        $commande = CommandeOnline::with('caisse')->findOrFail($commandeId);

        $caisse = $commande->caisse ?? new CaisseOnline();

        [$commande, $caisse, $paiement] = $this->synchroniserPaiementCommande($caisse, $commande);

        return redirect()->route('confirmer.wave', ['commande' => $commande->id])
            ->with('success', 'Paiement Wave confirmé et synchronisé !');
    }



    public function confirmerWave($commandeId)
    {
        $commande = CommandeOnline::findOrFail($commandeId);

        // Vérifie que le mode de paiement est bien Wave
        if ($commande->paiement?->mode_paiement !== MoyenPaiement::WAVE->value) {
            return redirect()->route('paiement', $commandeId)
                ->with('error', 'Le mode de paiement sélectionné n’est pas Wave.');
        }

        return view('wave_confirmation', compact('commande'));
    }

    // Enregistre la confirmation de paiement




    /**
     * Afficher le résumé d’une commande validée
     */
    public function resume($id)
    {
        $commande = CommandeOnline::with(['produits', 'livraison', 'paiement'])->findOrFail($id);

        return view('resume', compact('commande'));
    }

}
