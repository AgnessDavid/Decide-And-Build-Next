<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('validations', function (Blueprint $table) {
            $table->id();

            // Relation polymorphe
            $table->unsignedBigInteger('document_id')->nullable();
            $table->enum('type', ['demande_impression']);

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('statut', ['en_attente', 'validée'])->default('en_attente');
           
            $table->foreignId('imprimerie_id')
                ->nullable()
                ->constrained('imprimeries') // si vous avez une table imprimeries
                ->onDelete('cascade'); // ou 'set null' selon vos besoins


            $table->date('date_visa_chef_service')->nullable();
            $table->string('nom_visa_chef_service')->nullable();
            $table->date('date_autorisation')->nullable();
            $table->boolean('est_autorise_chef_informatique')->default(false);
            $table->string('nom_visa_autorisateur')->nullable();
            $table->date('date_impression')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['type', 'document_id']); // pour filtrer facilement
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('validations');
    }
};