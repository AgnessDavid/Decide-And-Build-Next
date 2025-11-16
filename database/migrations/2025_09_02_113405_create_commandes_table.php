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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();

            // ================= RELATIONS =================
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();

            // ================= ETAT =================
            $table->enum('etat', ['en_cours', 'validee', 'annulee'])->default('en_cours')->index();

            // ================= COMMANDE =================
            $table->string('numero_commande')->unique();
            $table->date('date_commande')->index();

            // ================= MONTANTS =================
            $table->decimal('montant_ht', 10, 2)->default(0);
            $table->decimal('tva', 5, 2)->default(18.00);
            $table->decimal('montant_ttc', 10, 2)->default(0);
            $table->integer('produit_non_satisfait')->default(0);

            // ================= PAIEMENT =================
            $table->enum('moyen_de_paiement', ['en_ligne', 'especes', 'cheque', 'virement_bancaire'])
                ->nullable()
                ->comment('Moyen de paiement prévu')
                ->index();

            $table->enum('statut_paiement', ['payé', 'impayé'])->default('impayé')->index();

            // ================= NOTES =================
            $table->text('notes_internes')->nullable();

            // ================= TIMESTAMPS =================
            $table->timestamps();

            // Optionnel : index combiné pour recherches fréquentes
            $table->index(['client_id', 'etat', 'date_commande']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};