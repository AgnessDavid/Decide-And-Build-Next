<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Produit;

class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    public function definition(): array
    {
        $nomsProduits = [
            'Sociétés minières industrielles et artisanales',
            'Secteur public',
            'Secteur administratif',
            'Préfectures',
            'sous-préfectures',
            'directions régionales',
            'ministères',
            'mairies',
            'Grand public',
            'Diversifiés',
            'Citoyens',
            'touristes',
            'voyageurs',
            'personnes intéressées par la géographie',
            'Urbanisme',
            'BTP',
            'foncier',
            'Sociétés immobilières',
            'bureaux d\'études',
            'topographes',
            'aménageurs fonciers',
            'Secteur académique',
            'Universités',
            'laboratoires de recherche',
            'étudiants',
            'Secteur agricole',
            'Secteur rural',
            'Coopératives agricoles',
            'ONG rurales',
            'structures d\'aménagement agricole'
        ];

        $titres = [
            'Carte minière détaillée',
            'Plan administratif complet',
            'Carte des préfectures',
            'Plan des sous-préfectures',
            'Cartographie régionale',
            'Atlas ministériel',
            'Plan municipal',
            'Guide grand public',
            'Cartes diverses',
            'Carte citoyenne',
            'Guide touristique',
            'Atlas du voyageur',
            'Cartes géographiques',
            'Plan d\'urbanisme',
            'Carte des chantiers BTP',
            'Document foncier',
            'Cartes immobilières',
            'Plans d\'études',
            'Cartes topographiques',
            'Plans d\'aménagement',
            'Atlas académique',
            'Cartes universitaires',
            'Documents de recherche',
            'Cartes étudiantes',
            'Atlas agricole',
            'Atlas rural',
            'Cartes des coopératives',
            'Plans ruraux',
            'Cartes d\'aménagement agricole'
        ];

        $prixHT = $this->faker->numberBetween(20000, 1000000);
        $tva = $this->faker->randomElement([0, 10, 12, 18]);
        $estPromo = $this->faker->boolean(30);

        return [
            // --- Informations de base ---
            'reference_produit' => strtoupper($this->faker->unique()->bothify('CARTO-###??')),

            'nom_produit' => $this->faker->randomElement($titres) . ' - ' . $this->faker->randomElement($nomsProduits),

            'description' => $this->faker->paragraph(3),
            'photo' => $this->faker->imageUrl(640, 480, 'map', true, 'Carte'),

            // --- Stock ---
            'stock_minimum' => $this->faker->numberBetween(5, 50),
            'stock_maximum' => $this->faker->numberBetween(100, 500),
            'stock_actuel' => $this->faker->numberBetween(10, 200),

            // --- Carte géographique ---
            'titre' => $this->faker->randomElement($titres),
            'type_carte' => $this->faker->randomElement(['carte', 'plan']), // Limité aux valeurs sûres

            'echelle' => '1:' . $this->faker->numberBetween(1000, 50000),
            'orientation' => $this->faker->randomElement(['Nord', 'Sud', 'Est', 'Ouest']),
            'date_creation' => $this->faker->date(),
            'auteur' => $this->faker->name(),
            'symbole' => $this->faker->randomElement(['Montagne', 'Rivière', 'Route', 'Ville', 'Mine', 'Bâtiment', 'Culture', 'Champ']),
            'type_element' => $this->faker->randomElement(['Relief', 'Hydrographie', 'Transport', 'Urbain', 'Administratif', 'Agricole', 'Minier']),
            'latitude' => $this->faker->latitude(4, 10),
            'longitude' => $this->faker->longitude(-8, -2),
            'nom_zone' => $this->faker->city(),
            'type_zone' => $this->faker->randomElement(['Région', 'Pays', 'Département', 'Commune', 'Zone minière', 'Périmètre agricole', 'Zone urbaine']),

            // --- E-commerce ---
            'categorie' => $this->faker->randomElement(['Topographique', 'Administrative', 'Touristique', 'Routière', 'Minière', 'Agricole', 'Universitaire', 'Urbaine']),
            'marque' => $this->faker->randomElement(['CartoGN', 'GeoData', 'MapSolutions', 'TopoPro', 'AtlasPlus']),
            'disponible' => $this->faker->boolean(90),
            'produit_non_disponible' => !$this->faker->boolean(80),
            'prix_unitaire_ht' => $prixHT,
            'taux_tva' => $tva,
            'prix_unitaire_ttc' => $prixHT * (1 + $tva / 100),
            'est_en_promotion' => $estPromo,
            'prix_promotion' => $estPromo ? $prixHT * $this->faker->randomFloat(2, 0.5, 0.9) : null,
            'est_actif' => true,
            'nombre_vues' => $this->faker->numberBetween(0, 500),
            'nombre_ventes' => $this->faker->numberBetween(0, 200),
            'largeur_cm' => $this->faker->randomFloat(2, 30, 120),
            'hauteur_cm' => $this->faker->randomFloat(2, 30, 120),
            'format' => $this->faker->randomElement(['A4', 'A3', 'A2', 'A1', 'A0']), // Retirer "Sur mesure"
            'etat_conservation' => $this->faker->randomElement(['neuf', 'excellent', 'bon', 'moyen', 'usage']), // Retirer "restaure"
            'tva' => $tva,
            'prix_ttc' => $prixHT * (1 + $tva / 100),
            'slug' => Str::slug($this->faker->unique()->words(2, true) . '-' . time()),
            'tags' => implode(',', $this->faker->randomElements(['géologie', 'touristique', 'administratif', 'agricole', 'minier', 'universitaire', 'urbanisme', 'topographique', 'BTP', 'foncier'], $this->faker->numberBetween(1, 3))),
        ];
    }
}