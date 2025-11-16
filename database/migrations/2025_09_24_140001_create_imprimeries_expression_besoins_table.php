<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('imprimeries_expression_besoins', function (Blueprint $table) {
            $table->id();

            // 🔗 Relations
            $table->unsignedBigInteger('demande_expression_besoin_id')->nullable();

            $table->foreignId('produit_id')->nullable();

            // 📝 Informations principales
            $table->string('numero_ImEx')->unique()->index();
            $table->string('nom_produit')->index();
            $table->integer('quantite_demandee')->default(0);
            $table->integer('quantite_imprimee')->default(0);

            // 👥 Suivi et validation
            $table->string('valide_par')->nullable()->index();
            $table->string('operateur')->nullable()->index();

            // 🕒 Dates et type
            $table->date('date_impression')->nullable()->index();
            $table->date('date_demande')->nullable()->index();
            $table->enum('type_impression', ['simple', 'complexe'])->default('simple')->index();

            // 📦 Statut et détails
            $table->enum('statut', ['en_attente', 'en_cours', 'terminee', 'annulee'])->default('en_attente')->index();
            $table->string('agent_commercial')->nullable();
            $table->string('service')->nullable();
            $table->string('objet')->nullable();
            $table->text('observations')->nullable();

            $table->timestamps();

            // 🔒 Clé unique
            $table->unique(['demande_expression_besoin_id', 'produit_id'], 'unique_demande_produit_imprimerie');
        });

        // 🔧 Ajout manuel des contraintes pour éviter noms trop longs
        Schema::table('imprimeries_expression_besoins', function (Blueprint $table) {
            $table->foreign('demande_expression_besoin_id', 'fk_impr_expr_demande')
                ->references('id')->on('demandes_expression_besoins')
                ->nullOnDelete();

            $table->foreign('produit_id', 'fk_impr_expr_produit')
                ->references('id')->on('produits')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imprimeries_expression_besoins');
    }
};
