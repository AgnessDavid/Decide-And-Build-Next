<?php

namespace App\Http\Controllers;

use App\Models\CommandeOnline;
use App\Models\CommandeProduitOnline;
use App\Models\PanierOnline;
use App\Models\Produit;
// use App\Models\PanierOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class PanierController extends Controller
{
    /**
     * Afficher le panier de l'utilisateur connecté
     */
    public function index()
    {
        $userId = Auth::id();

        $paniers = PanierOnline::with('produit')
            ->where('online_id', $userId)
            ->where('statut', 'actif')
            ->get();

        $total_ht = $paniers->sum(fn($item) => $item->quantite * $item->prix_unitaire_ht);
        $total_ttc = $total_ht * 1.18;

        return view('panier', compact('paniers', 'total_ht', 'total_ttc'));
    }


    public function count()
    {
        $userId = auth()->id();

        $count = \App\Models\PanierOnline::where('online_id', $userId)
            ->where('statut', 'actif')
            ->sum('quantite');

        return response()->json(['count' => $count]);
    }


    /**
     * Ajouter un produit au panier
     */
    public function ajouter(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        $request->validate([
            'quantite' => 'required|integer|min:1|max:' . $produit->stock_actuel
        ]);

        $quantite = $request->quantite;

        // Vérifier le stock
        if ($quantite > $produit->stock_actuel) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuffisant'
            ], 400);
        }

        // Récupérer le panier depuis la session
        $panier = session()->get('panier', []);

        // Ajouter ou mettre à jour le produit dans le panier
        if (isset($panier[$id])) {
            $panier[$id]['quantite'] += $quantite;
        } else {
            $panier[$id] = [
                'nom' => $produit->nom_produit,
                'prix' => $produit->est_en_promotion && $produit->prix_promotion
                    ? $produit->prix_promotion
                    : $produit->prix_unitaire_ht,
                'quantite' => $quantite,
                'photo' => $produit->photo
            ];
        }

        // Sauvegarder le panier dans la session
        session()->put('panier', $panier);

        // Si c'est une requête AJAX
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté au panier',
                'panier' => $panier,
                'redirect' => route('panier') // Ajout de l'URL de redirection
            ]);
        }

        // Sinon, redirection normale avec message flash
        return redirect()->route('panier')->with('success', 'Produit ajouté au panier !');
    }
    /**
     * Supprimer un produit du panier
     */
    public function supprimer($id)
    {
        $userId = Auth::id();

        $panier = PanierOnline::where('id', $id)
            ->where('online_id', $userId)
            ->where('statut', 'actif')
            ->first();

        if ($panier) {
            $panier->delete();
        }

        return back()->with('success', 'Produit supprimé du panier.');
    }

    /**
     * Valider le panier → créer la commande_online
     */
    public function valider()
    {
        $userId = Auth::id();
        $paniers = PanierOnline::where('online_id', $userId)
            ->where('statut', 'actif')
            ->get();

        if ($paniers->isEmpty()) {
            return back()->with('error', 'Votre panier est vide.');
        }

        // Calcul des montants
        $total_ht = $paniers->sum(fn($item) => $item->quantite * $item->prix_unitaire_ht);
        $total_ttc = $total_ht * 1.18;

        // Créer la commande principale
        $commande = CommandeOnline::create([
            'online_id' => $userId,
            'numero_commande' => 'CMD-' . time(),
            'total_ht' => $total_ht,
            'total_ttc' => $total_ttc,
            'etat' => 'en_cours',
        ]);

        // Créer les lignes de commande
        foreach ($paniers as $item) {
            CommandeProduitOnline::create([
                'commande_online_id' => $commande->id,
                'produit_id' => $item->produit_id,
                'quantite' => $item->quantite,
                'prix_unitaire_ht' => $item->prix_unitaire_ht,
                'montant_ht' => $item->quantite * $item->prix_unitaire_ht,
                'montant_ttc' => $item->quantite * $item->prix_unitaire_ht * 1.18,
            ]);

            $item->update(['statut' => 'converti']);
        }

        return redirect()->route('panier')->with('success', 'Commande validée avec succès !');



    }




}
