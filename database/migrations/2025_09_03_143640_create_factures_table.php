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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();

            // ================= RELATIONS =================
            $table->foreignId('commande_id')
                ->constrained('commandes')
                ->cascadeOnDelete()

                ->comment('La commande originale');

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete()
            ;

            $table->foreignId('caisse_id')
                ->nullable()
                ->after('user_id')
                ->constrained('caisses')
                ->onDelete('set null')
                ->comment('La caisse associée à la facture');

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()

                ->comment('Agent qui a créé la facture');

            // ================= IDENTIFIANT =================
            $table->string('numero_facture')->unique()->comment('Identifiant unique de la facture');

            // ================= DATES =================
            $table->date('date_facturation')->index();

            // ================= MONTANTS =================
            $table->decimal('montant_ht', 10, 2)->default(0);
            $table->decimal('tva', 5, 2)->default(18.00);
            $table->decimal('montant_ttc', 10, 2)->default(0);

            // ================= PAIEMENT =================
            $table->enum('statut', ['payé', 'impayé'])->default('impayé')->index();

            // ================= NOTES =================
            $table->text('notes')->nullable();

            // ================= TIMESTAMPS =================
            $table->timestamps();

            // ================= INDEX COMBINE =================
            // Accélérer les recherches par client et statut
            $table->index(['client_id', 'statut', 'date_facturation']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};