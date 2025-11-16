<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();

            // Clés étrangères
            $table->foreignId('facture_id')->comment('La facture qui est payée')->constrained('factures')->cascadeOnDelete();
            $table->foreignId('user_id')->comment('L\'agent qui a reçu le paiement')->constrained('users')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            // Informations du reçu
            $table->string('numero_recu')->unique();
            $table->date('date_paiement');
            $table->decimal('montant_paye', 10, 2);

            // Détails du paiement
            $table->enum('moyen_de_paiement', ['especes', 'cheque', 'virement_bancaire', 'en_ligne']);
            $table->string('reference_paiement')->nullable()->comment('Ex: Numéro du chèque, ID de transaction en ligne');
            $table->text('objet')->nullable()->comment('Objet du paiement, ex: "Paiement Facture N° XXX"');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};

