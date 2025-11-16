<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    public function definition(): array
    {
        $types = ['societe', 'organisme', 'particulier'];
        $usages = ['personnel', 'professionnel'];

        $type = $this->faker->randomElement($types);

        // Définir un nom selon le type
        $nom = match ($type) {
            'societe' => $this->faker->company(),
            'organisme' => 'Ministère de ' . $this->faker->word(),
            default => $this->faker->name(),
        };

        return [
            'nom' => $nom,
            'type' => $type,
            'nom_interlocuteur' => $this->faker->name(),
            'fonction' => $this->faker->optional()->jobTitle(),
            'telephone' => $this->faker->numerify('21#######'),
            'cellulaire' => $this->faker->numerify('07########'),
            'fax' => $this->faker->optional()->numerify('21#######'),
            'email' => $this->faker->unique()->safeEmail(),
            'ville' => $this->faker->randomElement(['Abidjan', 'Bouaké', 'Yamoussoukro', 'Daloa', 'San Pedro', 'Korhogo', 'Man']),
            'quartier_de_residence' => $this->faker->optional()->word(),
            'usage' => $this->faker->randomElement($usages),
            'domaine_activite' => $this->faker->randomElement([
                'Informatique',
                'Commerce',
                'Éducation',
                'Santé',
                'BTP',
                'Mode',
                'Artisanat',
                'Communication',
                'Transport',
                'Finance'
            ]),
        ];
    }
}
