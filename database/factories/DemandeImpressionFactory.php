<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Produit;

class DemandeImpressionFactory extends Factory
{
    protected $model = \App\Models\DemandeImpression::class;

    public function definition(): array
    {
        // Liste de noms de produits (tu peux les synchroniser avec ProduitFactory si besoin)
        $nomsProduits = [
            'Carte Topographique Côte d’Ivoire',
            'Plan de la ville d’Abidjan',
            'Carte Hydrographique du Bandama',
            'Carte Routière Nationale',
            'Carte Administrative des Régions',
            'Plan Urbain de Bouaké',
            'Carte Agricole du Cavally',
            'Carte Minéralogique de l’Indénié',
            'Carte Touristique du Bas-Sassandra',
            'Carte des Ressources Naturelles',
        ];

        $titres = [
            'Carte Topographique',
            'Plan Urbain',
            'Carte Hydrographique',
            'Carte Routière',
            'Carte Administrative',
            'Plan de Ville',
            'Carte Agricole',
            'Carte Minéralogique',
            'Carte Touristique',
            'Carte des Ressources',
        ];

        $index = $this->faker->numberBetween(0, count($nomsProduits) - 1);
        $nomProduit = $nomsProduits[$index];
        $titreProduit = $titres[$index];

        // Créer ou récupérer un produit existant
        $produit = Produit::firstOrCreate(
            ['nom_produit' => $nomProduit],
            [
                'titre' => $titreProduit,
                'reference_produit' => 'REF-' . $this->faker->unique()->bothify('###-???'),
                'slug' => \Str::slug($nomProduit),
                'prix_unitaire_ttc' => $this->faker->numberBetween(1000, 50000),
                'etat_conservation' => 'neuf',
                'notes_conservation' => 'RAS',
                'est_actif' => true,
                'est_en_promotion' => false,
                'orientation' => $this->faker->randomElement(['Portrait', 'Paysage']),
                'categorie' => $this->faker->randomElement(['carte', 'plan', 'rapport']),
                'echelle' => $this->faker->optional()->randomElement(['1/5000', '1/10000', '1/25000']),
            ]
        );

        return [
            // Relations
            'produit_id' => $produit->id,
           
            // Demande
            'nom_imprimerie' => $this->faker->optional(0.3)->company(),
            'type_impression' => 'simple', // SEULE VALEUR AUTORISÉE

            'nom_demandes' => $this->faker->unique()->words(3, true),
            'numero_ordre' => $this->faker->unique()->numerify('ORD-IMP-####'),
            'designation' => $nomProduit,
            'quantite_demandee' => $this->faker->numberBetween(10, 200),
            'quantite_imprimee' => $this->faker->numberBetween(0, 100),
            'date_demande' => $this->faker->date(),

            // Demandeur
            'agent_commercial' => $this->faker->name(),
            'service' => $this->faker->randomElement(['Cartographie', 'Impression', 'Commercial', 'Technique']),
            'objet' => $this->faker->sentence(),

            // Validation
            'date_visa_chef_service' => $this->faker->optional(0.7)->date(),
            'nom_visa_chef_service' => $this->faker->optional(0.7)->name(),

            'date_autorisation' => $this->faker->optional(0.6)->date(),
            'est_autorise_chef_informatique' => $this->faker->boolean(70), // 70% de chance d'être true
            'nom_visa_autorisateur' => $this->faker->optional(0.6)->name(),

 
            'validation_id' => null,  // ← Utilisez validation_id à la place
        
            // Impression
            'date_impression' => $this->faker->optional(0.4)->date(),
        ];
    }
}