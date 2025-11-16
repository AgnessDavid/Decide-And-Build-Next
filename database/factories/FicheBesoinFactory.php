<?php

namespace Database\Factories;

use App\Models\FicheBesoin;
use App\Models\Produit;
use App\Models\Client; // AJOUTÉ
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FicheBesoinFactory extends Factory
{
    protected $model = FicheBesoin::class;

    public function definition(): array
    {
        $typeStructure = $this->faker->randomElement(['societe', 'organisme', 'particulier']);

        $nomStructure = match ($typeStructure) {
            'societe' => $this->faker->company() . ' SARL',
            'organisme' => $this->faker->randomElement([
                'Ministère de l’Intérieur',
                'Direction Générale des Impôts',
                'ONEM',
                'SODECI',
                'CIE',
                'Université Félix Houphouët-Boigny'
            ]),
            'particulier' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            default => $this->faker->company(),
        };

        $produitsSouhaites = [
            'Carte Topographique 1/50 000',
            'Plan Urbain d’Abidjan',
            'Carte Hydrographique du Bandama',
            'Carte Routière Nationale',
            'Plan de Développement Urbain',
            'Carte Géologique Régionale',
            'Carte Touristique du Comoé'
        ];

        $produitSouhaite = $this->faker->randomElement($produitsSouhaites);

        $produit = Produit::firstOrCreate(
            ['nom_produit' => $produitSouhaite],
            [
                'titre' => $this->faker->words(2, true),
                'reference_produit' => 'REF-' . $this->faker->unique()->bothify('###-???'),
                'slug' => Str::slug($produitSouhaite),
                'prix_unitaire_ttc' => $this->faker->numberBetween(5000, 100000),
                'etat_conservation' => 'neuf',
                'notes_conservation' => 'RAS',
                'est_actif' => true,
                'est_en_promotion' => false,
                'orientation' => $this->faker->randomElement(['Portrait', 'Paysage']),
                'categorie' => $this->faker->randomElement(['carte', 'plan', 'rapport']),
                'echelle' => $this->faker->optional()->randomElement(['1/5000', '1/25000', '1/50000']),
            ]
        );

        $latitude = $this->faker->optional(0.8)->latitude(4.5, 10.5);
        $longitude = $this->faker->optional(0.8)->longitude(-8.5, -2.5);

        return [
            // === RELATIONS ===
            'client_id' => Client::factory(), // CORRIGÉ
            'produit_id' => $produit->id,
            'produit_souhaite' => $produitSouhaite,

            // === GÉNÉRAL ===
            'nom_fiche_besoin' => 'FICHE-' . $this->faker->unique()->numerify('####'),

            // === STRUCTURE ===
            'nom_structure' => $nomStructure,
            'type_structure' => $typeStructure,
            'nom_interlocuteur' => $this->faker->name(),
            'fonction' => $this->faker->optional(0.7)->jobTitle(),
            'quantite_demandee' => $this->faker->numberBetween(1, 50),

            // === CONTACTS ===
            'telephone' => $this->faker->optional(0.6)->numerify('## ## ## ##'),
            'cellulaire' => $this->faker->optional(0.9)->e164PhoneNumber(),
            'fax' => $this->faker->optional(0.3)->numerify('## ## ## ##'),
            'email' => $this->faker->unique()->safeEmail(),

            // === ENTRETIEN ===
            'nom_agent_bnetd' => $this->faker->name(),
            'date_entretien' =>$this->faker->date('Y-m-d', '+3 months'), // ou avec dateTimeBetween + format
            'objectifs_vises' => $this->faker->optional(0.8)->paragraph(2),

            // === OPTIONS ===
            'commande_ferme' => $this->faker->boolean(40),
            'demande_facture_proforma' => $this->faker->boolean(60),

            // === LIVRAISON ===
            'delai_souhaite' => $this->faker->optional(0.7)->date('Y-m-d', '+3 months'),
            'date_livraison_prevue' => $this->faker->optional(0.5)->date('Y-m-d', '+6 months'),
            'date_livraison_reelle' => $this->faker->optional(0.3)->date('Y-m-d', 'now'),







            
            // === SIGNATURES ===
            'signature_client' => $this->faker->optional(0.4)->name(),
            'signature_agent_bnetd' => $this->faker->optional(0.4)->name(),

            // === PRODUIT ===
            'titre' => $this->faker->sentence(3),
            'echelle' => $this->faker->optional(0.8)->randomElement(['1/5000', '1/25000', '1/50000', '1/100000']),
            'orientation' => $this->faker->optional(0.7)->randomElement(['Portrait', 'Paysage']),
            'auteur' => $this->faker->optional(0.6)->name(),
            'symbole' => $this->faker->optional(0.5)->lexify('???-##'),
            'type_element' => $this->faker->optional(0.7)->randomElement(['route', 'rivière', 'ville', 'forêt', 'montagne']),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'nom_zone' => $latitude && $longitude ? $this->faker->city() . ' et environs' : null,
            'type_zone' => $latitude && $longitude ? $this->faker->randomElement(['urbaine', 'rurale', 'côtière', 'forestière']) : null,
        ];
    }

    // === STATES ===
    public function pourSociete()
    {
        return $this->state(fn() => ['type_structure' => 'societe', 'nom_structure' => $this->faker->company() . ' SARL']);
    }
    public function pourOrganisme()
    {
        return $this->state(fn() => ['type_structure' => 'organisme', 'nom_structure' => $this->faker->randomElement(['Ministère de l’Intérieur', 'ONEM', 'SODECI'])]);
    }
    public function pourParticulier()
    {
        return $this->state(fn() => ['type_structure' => 'particulier', 'nom_structure' => $this->faker->firstName() . ' ' . $this->faker->lastName()]);
    }
    public function avecLivraison()
    {
        return $this->state(fn() => ['date_livraison_reelle' => $this->faker->dateTimeBetween('-1 year', 'now')]); 
    }
    public function commandeFerme()
    {
        return $this->state(fn() => ['commande_ferme' => true]);
    }
    public function avecFactureProforma()
    {
        return $this->state(fn() => ['demande_facture_proforma' => true]);
    }
}


