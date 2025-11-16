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
        Schema::create('mouvements_stock', function (Blueprint $table) {
            $table->id();

            // ================= RELATIONS =================
            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->cascadeOnDelete();

            $table->foreignId('imprimerie_id')
                ->nullable()
                ->constrained('imprimeries')
                ->cascadeOnDelete()
                ->index();

            $table->foreignId('demande_impression_id')
                ->nullable()
                ->constrained('demandes_impression')
                ->cascadeOnDelete();

            // ================= MOUVEMENT =================
            $table->string('numero_Mstock')->nullable()->index();

            $table->integer('quantite_entree')->nullable()->default(0);
            $table->integer('quantite_sortie')->nullable()->default(0);

            $table->date('date_mouvement')->index();
            $table->enum('type_mouvement', ['entree', 'sortie'])->index();

            $table->integer('stock_resultant')->nullable()->default(0);

            $table->text('details')->nullable();

            // ================= TIMESTAMPS =================
            $table->timestamps();

            // Optionnel : index combiné pour filtrer rapidement par produit et date
            $table->index(['produit_id', 'date_mouvement']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvements_stock');
    }
};