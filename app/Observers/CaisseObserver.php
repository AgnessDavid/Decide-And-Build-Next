<?php

namespace App\Observers;

use App\Models\Caisse;
namespace App\Observers;

use App\Models\Caisse;

class CaisseObserver
{
    public function saved(Caisse $caisse): void
    {
        if ($caisse->statut_paiement === 'Payé' && $caisse->commande) {
            $caisse->commande->update([
                'statut_paiement' => 'Payé',
            ]);
        }
    }
}
