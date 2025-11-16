<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commande_online', function (Blueprint $table) {
            
            $table->id();
            $table->foreignId('online_id')->constrained('onlines')->onDelete('cascade');
            $table->string('numero_commande')->unique()->default(''); // peut être généré automatiquement
            $table->decimal('total_ht', 10, 2)->default(0);
            $table->decimal('total_ttc', 10, 2)->default(0);
            $table->enum('etat', ['en_cours', 'validee', 'annulee'])->default('en_cours');
            $table->timestamp('date_commande')->useCurrent();
   
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commande_online');
    }
};
