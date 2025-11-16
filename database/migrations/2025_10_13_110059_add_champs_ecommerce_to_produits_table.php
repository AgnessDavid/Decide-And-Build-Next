<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            // --- Colonnes e-commerce ---
            $table->string('categorie')->nullable()->after('photo')->index();
            $table->string('marque')->nullable()->after('categorie')->index();
            $table->boolean('disponible')->default(true)->after('marque')->index();

            // ✅ Nouvelle colonne produit_non_disponible
            $table->boolean('produit_non_disponible')->default(false)->after('disponible')->index();

            // --- Prix et taxes ---
            $table->decimal('prix_unitaire_ttc', 10, 2)->default(0)->after('produit_non_disponible')->index();
            $table->decimal('taux_tva', 5, 2)->default(20.00)->after('prix_unitaire_ttc');
            $table->boolean('est_en_promotion')->default(false)->after('taux_tva')->index();
            $table->decimal('prix_promotion', 10, 2)->nullable()->after('est_en_promotion');

            // --- Visibilité et suivi ---
            $table->boolean('est_actif')->default(true)->after('prix_promotion')->index();
            $table->integer('nombre_vues')->default(0)->after('est_actif')->index();
            $table->integer('nombre_ventes')->default(0)->after('nombre_vues');

            // --- Dimensions et format ---
            $table->decimal('largeur_cm', 6, 2)->nullable()->after('nombre_ventes');
            $table->decimal('hauteur_cm', 6, 2)->nullable()->after('largeur_cm');
            $table->string('format', 50)->nullable()->after('hauteur_cm');

            // --- État de conservation ---
            $table->enum('etat_conservation', [
                'neuf',
                'excellent',
                'bon',
                'moyen',
                'usage',
                'restaure'
            ])->default('neuf')->after('format')->index();

            // --- Autres infos ---
            $table->decimal('tva', 5, 2)->default(0.00)->after('etat_conservation');
            $table->decimal('prix_ttc', 10, 2)->nullable()->after('tva');
            $table->string('slug')->unique()->nullable()->after('prix_ttc');
            $table->string('tags')->nullable()->after('slug');

        
            // --- Index pour les cartes (géographie) ---
            if (Schema::hasColumn('produits', 'type')) {
                $table->index('type', 'produits_type_carte_index');
            }

         
            if (Schema::hasColumn('produits', 'nom_zone')) {
                $table->index('nom_zone', 'produits_nom_zone_index');
            }

            // --- Index composites pour recherches avancées ---
            $table->index(['est_actif', 'type', 'prix_unitaire_ttc'], 'produits_recherche_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            // Suppression des contraintes uniques
            $table->dropUnique(['nom_produit']);
            $table->dropUnique(['reference_produit']);
            $table->dropUnique(['slug']);

            // Suppression des index
            $table->dropIndex(['categorie']);
            $table->dropIndex(['marque']);
            $table->dropIndex(['disponible']);
            $table->dropIndex(['produit_non_disponible']);
            $table->dropIndex(['prix_unitaire_ttc']);
            $table->dropIndex(['est_en_promotion']);
            $table->dropIndex(['est_actif']);
            $table->dropIndex(['nombre_vues']);
            $table->dropIndex(['etat_conservation']);
            $table->dropIndex(['produits_recherche_index']);
            $table->dropIndex(['produits_type_carte_index']);
            $table->dropIndex(['produits_nom_zone_index']);

            // Suppression des colonnes
            $table->dropColumn([
                'categorie',
                'marque',
                'disponible',
                'produit_non_disponible',
                'prix_unitaire_ttc',
                'taux_tva',
                'est_en_promotion',
                'prix_promotion',
                'est_actif',
                'nombre_vues',
                'nombre_ventes',
                'largeur_cm',
                'hauteur_cm',
                'format',
                'etat_conservation',
                'tva',
                'prix_ttc',
                'slug',
                'tags',
            ]);
        });
    }
};
