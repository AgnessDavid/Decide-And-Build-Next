<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DemandeImpression;

class DemandeImpressionSeeder extends Seeder
{
    public function run(): void
    {
        // Crée 50 demandes d'impression factices
        DemandeImpression::factory()->count(15)->create();
    }
}
