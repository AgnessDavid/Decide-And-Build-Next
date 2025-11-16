<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commande_produit_online', function (Blueprint $table) {
            $table->id();

            $table->foreignId('panier_id')
                ->nullable()
                ->constrained('panier_online')
                ->onDelete('set null');

            $table->foreignId('commande_online_id')
                ->constrained('commande_online')
                ->onDelete('cascade');

            $table->foreignId('produit_id')
                ->constrained('produits')
                ->onDelete('cascade');

            $table->integer('quantite')->default(1);
            $table->decimal('prix_unitaire_ht', 10, 2);

            // Colonnes montant à créer correctement
            $table->decimal('montant_ht', 15, 2)->default(0);
            $table->decimal('montant_ttc', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commande_produit_online');
    }
};
