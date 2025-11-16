<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('caisses', function (Blueprint $table) {
            $table->id();

            // ================= RELATIONS =================
            $table->foreignId('commande_id')
                ->constrained('commandes')
                ->cascadeOnDelete();

            $table->foreignId('session_caisse_id')->nullable(); // colonne déclarée

            $table->foreign('session_caisse_id')
                ->references('id')
                ->on('session_caisses') // ← corrige le nom de la table
                ->nullOnDelete(); // ou cascadeOnDelete selon ton besoin

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            // ================= MONTANTS =================
            $table->string('numero_caisse')->unique();
            $table->decimal('montant_ht', 15, 2);
            $table->decimal('tva', 5, 2)->default(18.00);
            $table->decimal('montant_ttc', 15, 2);

            $table->decimal('entree', 15, 2)->comment('Montant payé par le client');
            $table->decimal('sortie', 15, 2)->comment('Monnaie rendue');

            // ================= STATUT =================
            $table->enum('statut', ['payé', 'impayé'])->default('impayé')->index();

            // ================= TIMESTAMPS =================
            $table->timestamps();

            // ================= CONTRAINTES =================
            $table->unique(['commande_id', 'session_caisse_id'], 'unique_commande_session');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('caisses');
    }
};