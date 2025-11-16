<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Depense;

class DepenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Générer 15 dépenses avec le factory
        Depense::factory()->count(15)->create()->each(function ($depense) {
            // Calculer le montant total cumulé si nécessaire
            $depense->montant_total = Depense::sum('montant');
            $depense->save();
        });
    }
}
