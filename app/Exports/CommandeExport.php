<?php

namespace App\Exports;

use App\Models\Commande;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommandeExport implements FromCollection, WithHeadings
{
    protected $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function collection()
    {
        // Retourne les produits de la commande par exemple
        return collect($this->commande->produits)->map(function ($ligne) {
            return [
                'Produit' => $ligne->produit->nom_produit,
                'Quantité' => $ligne->quantite,
                'Prix unitaire (HT)' => $ligne->prix_unitaire_ht,
                'Montant (HT)' => $ligne->montant_ht,
            ];
        });
    }

    public function headings(): array
    {
        return ['Produit', 'Quantité', 'Prix unitaire (HT)', 'Montant (HT)'];
    }
}
