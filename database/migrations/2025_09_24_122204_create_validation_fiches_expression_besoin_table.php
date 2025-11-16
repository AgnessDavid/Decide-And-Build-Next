<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('validation_fiches_expression_besoin', function (Blueprint $table) {
            $table->id();

            // ================= RELATIONS =================
            $table->foreignId('fiche_besoin_id')
                ->constrained('fiches_besoin')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // ================= INFORMATIONS STRUCTURE =================
            $table->string('num_validation')->unique()->index();
            $table->string('nom_structure');
            $table->enum('type_structure', ['societe', 'organisme', 'particulier'])->default('societe');
            $table->string('nom_interlocuteur');
            $table->string('fonction')->nullable();

            // ================= ENTRETIEN =================
            $table->string('nom_agent_bnetd');
            $table->date('date_entretien');
            $table->text('objectifs_vises')->nullable();

            // ================= VALIDATION =================
            $table->boolean('valide')->default(false)->index();
            $table->text('commentaire')->nullable();

            // ================= INFORMATIONS PRODUIT / CARTE =================
            $table->string('type_carte', 100)->nullable();     // ex. Ville, Région, Pays...
            $table->string('echelle', 50)->nullable();         // ex. 1:50000
            $table->string('orientation', 50)->nullable();     // ex. Nord
            $table->string('auteur', 255)->nullable();         // Auteur ou source
            $table->string('symbole', 100)->nullable();        // Nom du symbole
            $table->string('type_element', 50)->nullable();    // ex. Relief, Hydrographie, etc.
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->integer('quantite_demandee')->default(0);
            $table->string('nom_zone', 255)->nullable();
            $table->string('type_zone', 50)->nullable();

            // ================= TIMESTAMPS =================
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('validation_fiches_expression_besoin');
    }
};