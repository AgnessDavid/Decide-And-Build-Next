<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('panier_online', function (Blueprint $table) {
            $table->id();
            $table->foreignId('online_id')->constrained('onlines')->onDelete('cascade');
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');
            $table->integer('quantite')->default(1);
            $table->decimal('prix_unitaire_ht', 10, 2);
            $table->string('session_id')->nullable(); // pour client non connecté
            $table->enum('statut', ['actif', 'converti', 'abandonné'])->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panier_online');
    }
};
