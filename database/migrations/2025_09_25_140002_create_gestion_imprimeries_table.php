<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gestion_imprimeries', function (Blueprint $table) {
            $table->id();

            // 🔹 Numéro unique de gestion d'impression
            $table->string('num_impreGest')->unique()->index();

            // 🔹 Relations
            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->onDelete('set null');

            // ⚠️ Correction ici : le nom exact de la table est au pluriel
            $table->foreignId('imprimeries_expression_besoin_id')
                ->nullable()
                ->constrained('imprimeries_expression_besoins') // ✅ ici
                ->nullOnDelete();

            // 🔹 Informations produit et mouvements
            $table->string('designation')->nullable();
            $table->integer('quantite_entree')->nullable();
            $table->integer('quantite_sortie')->nullable();
            $table->integer('quantite_demandee')->nullable();
            $table->integer('quantite_imprimee')->nullable();
            $table->date('date_mouvement')->index();
            $table->string('numero_bon')->nullable()->index();
            $table->string('type_mouvement')->index(); // entrée / sortie
            $table->integer('stock_resultant')->default(0);
            $table->integer('stock_minimum')->nullable();
            $table->integer('stock_maximum')->nullable();
            $table->integer('stock_actuel')->nullable();
            $table->text('details')->nullable();

            // 🔹 Timestamps
            $table->timestamps();

            // 🔹 Index supplémentaires utiles
            $table->index(['produit_id', 'imprimeries_expression_besoin_id'], 'idx_produit_impression');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gestion_imprimeries');
    }
};
