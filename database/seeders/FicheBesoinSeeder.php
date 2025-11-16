<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FicheBesoin;

class FicheBesoinSeeder extends Seeder
{
    public function run()
    {
        // Créer 20 fiches de besoin
        FicheBesoin::factory()->count(20)->create();

        // Ou avec des états personnalisés
        FicheBesoin::factory()
            ->count(5)
            ->pourSociete()
            ->commandeFerme()
            ->create();

        FicheBesoin::factory()
            ->count(5)
            ->pourOrganisme()
            ->avecFactureProforma()
            ->create();

        FicheBesoin::factory()
            ->count(5)
            ->pourParticulier()
            ->avecLivraison()
            ->create();
    }
}