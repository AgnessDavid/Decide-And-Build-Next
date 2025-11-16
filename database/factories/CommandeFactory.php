<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commande>
 */
class CommandeFactory extends Factory
{
    public function definition(): array
    {
        $montant_ht = $this->faker->randomFloat(2, 10000, 500000); // Montant HT entre 10 000 et 500 000
        $tva = 18.00;
        $montant_ttc = $montant_ht + ($montant_ht * $tva / 100);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'client_id' => Client::inRandomOrder()->first()?->id ?? Client::factory(),
            'numero_commande' => strtoupper('CMD-' . $this->faker->unique()->bothify('####??')),
            'date_commande' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'montant_ht' => $montant_ht,
            'tva' => $tva,
            'montant_ttc' => $montant_ttc,
            'produit_non_satisfait' => $this->faker->numberBetween(0, 3),
            'moyen_de_paiement' => $this->faker->randomElement(['en_ligne', 'especes', 'cheque', 'virement_bancaire']),
            'statut_paiement' => $this->faker->randomElement(['payé', 'impayé']),
            'notes_internes' => $this->faker->optional()->sentence(10),
        ];
    }
}
