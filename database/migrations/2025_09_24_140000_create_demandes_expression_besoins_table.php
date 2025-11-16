<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes_expression_besoins', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('fiche_besoin_id')->nullable()->constrained('fiches_besoin')->nullOnDelete();
            $table->foreignId('produit_id')->nullable()->constrained('produits')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Infos principales
            $table->enum('type_impression', ['simple'])->default('simple');
            $table->string('numero_ordre')->nullable()->index();
            $table->string('num_demanExp')->nullable()->index();
            $table->integer('quantite_demandee')->default(0);
            $table->integer('quantite_imprimee')->default(0);
            $table->date('date_demande')->nullable();

            // Suivi
            $table->enum('statut', ['en_attente', 'en_cours', 'validee', 'refusee'])->default('en_attente');

            // Informations supplémentaires
            $table->string('agent_commercial')->nullable();
            $table->string('service')->nullable();
            $table->string('objet')->nullable();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('demandes_expression_besoins');
    }
};
