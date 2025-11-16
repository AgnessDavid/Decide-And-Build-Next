<?php

namespace App\Exports;

use App\Models\Facture;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FactureExport implements FromCollection, WithHeadings
{
    protected $facture;

    public function __construct(Facture $facture)
    {
        $this->facture = $facture;
    }

    public function collection()
    {
        return collect([$this->facture])->map(function ($facture) {
            return [
                'Numéro facture' => $facture->numero_facture,
                'Date facturation' => $facture->date_facturation->format('d/m/Y'),
                'Client' => $facture->client->nom ?? 'Inconnu',
                'Agent' => $facture->user->name ?? 'Inconnu',
                'Montant HT' => $facture->montant_ht,
                'TVA' => $facture->tva,
                'Montant TTC' => $facture->montant_ttc,
                'Statut paiement' => $facture->statut_paiement,
                'Notes' => $facture->notes,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Numéro facture',
            'Date facturation',
            'Client',
            'Agent',
            'Montant HT',
            'TVA',
            'Montant TTC',
            'Statut paiement',
            'Notes',
        ];
    }
}
