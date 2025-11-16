<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Caisse;
use App\Observers\CaisseObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }



    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

 Caisse::observe(CaisseObserver::class);

        // Définir le morphMap pour les validations
        Relation::morphMap([
            'fiche_besoin' => \App\Models\FicheBesoin::class,
            'demande_impression' => \App\Models\DemandeImpression::class,
        ]);
    }
}
