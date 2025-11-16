<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();

            // ================= NUMÉRO DE LIVRAISON =================
            $table->string('num_livraison')->unique()->index(); // Numéro unique pour identifier chaque livraison

            // ================= RELATIONS =================
            $table->foreignId('fiche_besoin_id')
                ->constrained('fiches_besoin')
                ->onDelete('cascade');

            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->onDelete('set null');

            // ================= QUANTITÉS =================
            $table->integer('quantite_demandee')->default(0)->index();
            $table->integer('quantite_delivree')->default(0)->index();

            // ================= INFOS LIVRAISON =================
            $table->string('livreur')->nullable()->index();          // Nom du livreur
            $table->date('date_livraison')->nullable()->index();     // Date de la livraison
            $table->enum('statut', ['en_attente', 'en_cours', 'livree', 'incomplete'])
                ->default('en_attente')
                ->index();

            $table->text('observation')->nullable();                 // Notes ou remarques

            $table->timestamps();

            // ================= CONTRAINTES / INDEX =================
            $table->index(['fiche_besoin_id', 'produit_id'], 'idx_fiche_produit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livraisons');
    }
};