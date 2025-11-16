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
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();

            // ================= IDENTIFIANT UNIQUE =================
            $table->string('numero_depense')
                ->unique()
                ->comment('Numéro unique de la dépense, ex: DP-0001');

            // ================= INFORMATIONS PRINCIPALES =================
            $table->string('nom_depense')->index();       // Nom ou intitulé
            $table->decimal('montant', 10, 2);            // Montant de la dépense
            $table->decimal('montant_total', 10, 2)
                ->default(0)
                ->comment('Cumul des montants si applicable');

            $table->date('date_depense')->index();        // Date de la dépense
            $table->string('categorie')->nullable()->index(); // Catégorie (ex: fournitures, transport, etc.)
            $table->text('details')->nullable();          // Notes supplémentaires

            // ================= RELATION AVEC L'AGENT =================
            $table->foreignId('user_id')
                ->nullable()
                ->comment('Agent ayant enregistré la dépense')
                ->constrained('users')
                ->nullOnDelete();

            // ================= RELATION AVEC LA CAISSE =================
            $table->foreignId('caisse_id')
                ->nullable()
                ->comment('Caisse d\'où provient la dépense')
                ->constrained('caisses')
                ->nullOnDelete();

            // ================= STATUT =================
            $table->enum('statut', ['enregistrée', 'validée', 'annulée'])
                ->default('enregistrée')
                ->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depenses');
    }
};