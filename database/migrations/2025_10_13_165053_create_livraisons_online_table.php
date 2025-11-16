<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('livraison_online', function (Blueprint $table) {
            $table->id();
            $table->foreignId('online_id')->constrained('onlines')->onDelete('cascade');
            $table->enum('type', ['facturation', 'livraison']);
            $table->string('adresse');
            $table->string('ville');
            $table->string('numero_tel')->nullable(); // <-- plus de "after"
            $table->string('code_postal');
            $table->string('pays');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('livraison_online');
    }
};
