<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        // Crée 50 produits réalistes
        Produit::factory()->count(15)->create();
    }
}
