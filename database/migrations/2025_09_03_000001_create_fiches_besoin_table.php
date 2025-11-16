<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fiches_besoin', function (Blueprint $table) {
            $table->id();

            // ================= PRODUIT =================
            $table->unsignedBigInteger('produit_id')->nullable()->index();
            $table->string('produit_souhaite')->nullable()->index();

            // === NOUVEAU ===
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->string('titre')->nullable()->index(); // <-- AJOUTÉ

            $table->string('nom_fiche_besoin')->nullable()->unique();

            // ================= STRUCTURE =================
            $table->string('nom_structure')->index();
            $table->enum('type_structure', ['societe', 'organisme', 'particulier'])->index();
            $table->string('nom_interlocuteur');
            $table->string('fonction')->nullable();
            $table->integer('quantite_demandee')->default(0);

            // ================= CONTACTS =================
            $table->string('telephone')->nullable()->index();
            $table->string('cellulaire')->nullable()->index();
            $table->string('fax')->nullable();
            $table->string('email')->nullable()->unique();

            // ================= ENTRETIEN =================
            $table->string('nom_agent_bnetd');
            $table->date('date_entretien')->index();
            $table->text('objectifs_vises')->nullable();

            // ================= OPTIONS =================
            $table->boolean('commande_ferme')->default(false)->index();
            $table->boolean('demande_facture_proforma')->default(false)->index();

            // ================= LIVRAISON =================
            $table->date('delai_souhaite')->nullable()->index();
            $table->date('date_livraison_prevue')->nullable()->index();
            $table->date('date_livraison_reelle')->nullable()->index();

            // ================= SIGNATURES =================
            $table->string('signature_client')->nullable();
            $table->string('signature_agent_bnetd')->nullable();

            // ================= INFORMATIONS CARTE =================
            $table->string('type_carte', 100)->nullable()->index();
            $table->string('echelle', 50)->nullable();
            $table->string('orientation', 50)->nullable();
            $table->string('auteur', 255)->nullable();
            $table->string('symbole', 100)->nullable();
            $table->string('type_element', 50)->nullable()->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('nom_zone', 255)->nullable()->index();
            $table->string('type_zone', 50)->nullable()->index();

            // ================= TIMESTAMPS =================
            $table->timestamps();

            // ================= FOREIGN KEYS =================
            $table->foreign('produit_id')
                ->references('id')
                ->on('produits')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fiches_besoin');
    }
};