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
        Schema::create('commande_produit', function (Blueprint $table) {
            $table->id();

            // ================= RELATIONS =================
            $table->foreignId('commande_id')
                ->constrained('commandes')
                ->cascadeOnDelete();

            $table->foreignId('produit_id')
                ->constrained('produits')
                ->cascadeOnDelete();

            // ================= IDENTIFIANT =================
            $table->string('numero_com_prod')->unique()->comment('Identifiant unique de la ligne commande-produit');

            // ================= QUANTITE & PRIX =================
            $table->integer('quantite')->unsigned()->default(1)->index();
            $table->decimal('prix_unitaire_ht', 10, 2);

            // ================= MONTANTS CALCULES =================
            $table->decimal('montant_ht', 10, 2)->storedAs('quantite * prix_unitaire_ht');
            $table->decimal('montant_ttc', 10, 2)->storedAs('quantite * prix_unitaire_ht * 1.18');


            // ================= TIMESTAMPS =================
            $table->timestamps();

            // ================= CONTRAINTES =================
            // Empêche le doublon d'un produit dans une même commande
            $table->unique(['commande_id', 'produit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_produit');
    }
};