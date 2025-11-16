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

        Schema::create('session_caisses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->unsignedBigInteger('caisse_id')->nullable(); // juste la colonne, pas de FK ici

            $table->string('numero_session_caisse')->unique();
            $table->double('solde_initial')->default(0);
            $table->double('entrees')->default(0);
            $table->double('sorties')->default(0);
            $table->double('solde_final')->nullable();
            $table->enum('statut', ['ouvert', 'fermé'])->default('ouvert')->index();
            $table->timestamp('ouvert_le')->useCurrent();
            $table->dateTime('ferme_le')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_caisses');
    }
};