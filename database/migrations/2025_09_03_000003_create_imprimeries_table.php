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
        Schema::create('imprimeries', function (Blueprint $table) {
            $table->id();

            // ================= RELATIONS =================
            $table->foreignId('validation_id')
                ->nullable()
                ->constrained('validations')
                ->cascadeOnDelete();

            $table->foreignId('demande_id')
                ->nullable()
                ->constrained('demandes_impression')
                ->cascadeOnDelete();

            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->cascadeOnDelete();

            // ================= INFORMATIONS PRODUIT =================
            $table->string('numero_impression')->nullable();
            $table->string('nom_produit')->nullable();
            $table->integer('quantite_demandee')->default(0)->index();
            $table->integer('quantite_imprimee')->default(0)->index();

            $table->string('valide_par')->nullable()->index();
            $table->string('operateur')->nullable()->index();
            $table->date('date_impression')->nullable()->index();

            $table->enum('type_impression', ['simple', 'specifique'])->default('simple');
            $table->enum('statut', ['en_cours', 'terminee'])->default('en_cours')->index();

            // ================= INFORMATIONS DEMANDE =================
            $table->string('agent_commercial')->nullable()->index();
            $table->string('service')->nullable()->index();
            $table->string('objet')->nullable();
            $table->date('date_demande')->nullable()->index();

            // ================= TIMESTAMPS =================
            $table->timestamps();

            // ================= CONTRAINTES =================
            // Empêche les doublons de produit dans la même demande
            $table->unique(['demande_id', 'produit_id'], 'unique_demande_produit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imprimeries');
    }
};