<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Depense>
 */
class DepenseFactory extends Factory
{
    protected $model = \App\Models\Depense::class;

    public function definition(): array
    {
        $categories = ['Fournitures', 'Salaires', 'Maintenance', 'Marketing', 'Transport'];

        return [
            'designation' => $this->faker->sentence(3),
            'montant' => $this->faker->numberBetween(10000, 500000), // montants élevés
            'montant_total' => 0, // sera calculé si besoin dans le seeder
            'date_depense' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'categorie' => $this->faker->randomElement($categories),
            'details' => $this->faker->paragraph(),
        ];
    }
}
