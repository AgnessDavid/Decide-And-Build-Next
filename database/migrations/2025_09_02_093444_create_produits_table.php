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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();

            // Identifiants uniques
            $table->string('reference_produit', 100)->unique();
            $table->string('nom_produit', 255)->unique();

            // Description et stock
            $table->text('description')->nullable();
            $table->integer('stock_minimum')->nullable();
            $table->integer('stock_maximum')->nullable();
            $table->integer('stock_actuel')->default(0)->index();
            $table->decimal('prix_unitaire_ht', 10, 2)->default(0);
            $table->string('photo')->nullable();
            $table->text('notes_conservation')->nullable();
            // Colonnes carte géographique
            $table->string('titre', 255)->nullable();
            $table->enum('type_carte', ['carte', 'plan'])->default('carte');
            $table->string('echelle', 50)->nullable();
            $table->string('orientation', 50)->nullable();
            $table->date('date_creation')->nullable();
            $table->string('auteur', 255)->nullable();
            $table->string('symbole', 100)->nullable();
            $table->string('type_element', 50)->nullable()->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('nom_zone', 255)->nullable()->index();
            $table->string('type_zone', 50)->nullable()->index();

            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};