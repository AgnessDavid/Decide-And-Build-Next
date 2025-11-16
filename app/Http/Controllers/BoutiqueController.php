<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class BoutiqueController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer toutes les catégories distinctes
        $categories = Produit::select('categorie')->distinct()->get();

        // Construire la requête
        $query = Produit::query();

        // Filtrer par catégorie si sélectionnée
        if ($request->categorie) {
            $query->where('categorie', $request->categorie);
        }

        // Tri par prix si demandé
        if ($request->tri) {
            if ($request->tri === 'prix_croissant') {
                $query->orderByRaw('COALESCE(prix_promotion, prix_unitaire_ttc) ASC');
            } elseif ($request->tri === 'prix_decroissant') {
                $query->orderByRaw('COALESCE(prix_promotion, prix_unitaire_ttc) DESC');
            }
        }

   
        // Pagination
        $produits = $query->paginate(12)->withQueryString();

        return view('boutique.index', compact('produits', 'categories'));
    }



/* Pour la landing page */ 

    public function landing()
    {
        // Récupérer les 3 derniers produits
        $produits = Produit::latest()->take(5)->get();

        return view('accueil', compact('produits'));
    }




}
