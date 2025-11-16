<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('demandes_impression', function (Blueprint $table) {
            $table->id();

            // ================= RELATIONS =================
            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->nullOnDelete();

            $table->foreignId('validation_fiche_id')
                ->nullable()
                ->constrained('validations')
                ->nullOnDelete()
                ->comment('La validation qui a généré cette demande');

            // ================= DEMANDE =================
            $table->string('nom_imprimerie')->nullable()->index();
            $table->enum('type_impression', ['simple'])->default('simple')->index();

            $table->string('nom_demandes')->nullable()->unique();
            $table->string('numero_ordre')->nullable()->index();
            $table->string('designation')->nullable()->index();
            $table->integer('quantite_demandee')->default(0)->index();
            $table->integer('quantite_imprimee')->default(0);
            $table->date('date_demande')->nullable()->index();

            // ================= DEMANDEUR =================
            $table->string('agent_commercial')->nullable()->index();
            $table->string('service')->nullable()->index();
            $table->string('objet')->nullable();

            // ================= VALIDATION =================
            $table->date('date_visa_chef_service')->nullable()->index();
            $table->string('nom_visa_chef_service')->nullable();

            $table->date('date_autorisation')->nullable()->index();
            $table->boolean('est_autorise_chef_informatique')->default(false)->index();
            $table->string('nom_visa_autorisateur')->nullable();

            // ================= IMPRESSION =================
            $table->date('date_impression')->nullable()->index();

            // ================= TIMESTAMPS =================
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes_expression_besoins');
    }
};
