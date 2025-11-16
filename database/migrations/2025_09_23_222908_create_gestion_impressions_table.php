<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gestion_impressions', function (Blueprint $table) {
            $table->id();

            // ================= RELATIONS =================
            $table->foreignId('imprimerie_id')
                ->nullable()
                ->constrained('imprimeries')
                ->nullOnDelete();

            $table->foreignId('demande_imprimerie_id')
                ->nullable()
                ->constrained('demandes_impression')
                ->nullOnDelete();

            $table->foreignId('produit_id')
                ->constrained('produits')
                ->cascadeOnDelete();

            // ================= INFORMATIONS GENERALES =================
            $table->string('numero_gestion')
                ->unique()
                ->comment('Numéro unique pour identifier chaque gestion d\'impression');

            $table->string('nom_gestion_imprimerie')->nullable()->index();
            $table->string('nom_produit')->nullable()->index();
            $table->integer('quantite_demandee')->default(0)->index();
            $table->integer('quantite_imprimee')->default(0)->index();

            // ================= SUIVI DE L’IMPRESSION =================
            $table->enum('type_impression', ['simple', 'specifique'])->nullable()->index();
            $table->enum('statut', ['en_cours', 'terminee'])->default('en_cours')->index();
            $table->date('date_impression')->nullable()->index();
            $table->date('date_demande')->nullable()->index();

            // ================= RESPONSABLES ET SERVICES =================
            $table->string('valide_par')->nullable()->index();
            $table->string('operateur')->nullable()->index();
            $table->string('agent_commercial')->nullable()->index();
            $table->string('service')->nullable()->index();
            $table->string('objet')->nullable();

            // ================= TIMESTAMPS =================
            $table->timestamps();

            // ================= CONTRAINTES =================
            // Empêche le doublon d’un même produit sur la même demande
           // $table->unique(['demande_id', 'produit_id'], 'unique_demande_produit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gestion_impressions');
    }
};