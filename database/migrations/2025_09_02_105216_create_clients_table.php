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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // ================= IDENTIFICATION =================
            $table->string('nom')->index(); // nom du client ou structure
            $table->enum('type', ['societe', 'organisme', 'particulier'])->default('societe')->index();

            // ================= CONTACT =================
            $table->string('nom_interlocuteur')->nullable()->index();
            $table->string('fonction')->nullable();
            $table->string('telephone')->nullable()->index();
            $table->string('cellulaire')->nullable()->index();
            $table->string('fax')->nullable();
            $table->string('email')->nullable()->unique();

            // ================= LOCALISATION =================
            $table->string('ville')->nullable()->index();
            $table->string('quartier_de_residence')->nullable();
            $table->enum('usage', ['personnel', 'professionnel'])->nullable()->index();
            $table->string('domaine_activite')->nullable()->index();

            // ================= TIMESTAMPS =================
            $table->timestamps();

            // Optionnel : index combiné pour recherches fréquentes
            $table->index(['nom', 'ville']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
