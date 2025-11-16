<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('caisse_online', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_online_id')->constrained('commande_online')->onDelete('cascade');
            $table->foreignId('online_id')->constrained('onlines')->onDelete('cascade');
            $table->decimal('montant_ht', 10, 2);
            $table->decimal('tva', 10, 2)->default(0);
            $table->decimal('montant_ttc', 10, 2);
            $table->decimal('entree', 10, 2)->default(0);
            $table->decimal('sortie', 10, 2)->default(0);
            $table->enum('statut_paiement', ['impayé', 'partiellement payé', 'payé'])->default('impayé');
            $table->enum('methode_paiement', ['carte', 'paypal', 'mobile_money', 'mixed'])->nullable(); // ajouté
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caisse_online');
    }
};
