<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filament Path
    |--------------------------------------------------------------------------
    |
    | This is the path where Filament will be accessible from.
    |
    */

    'path' => env('FILAMENT_PATH', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | Authentication Guard
    |--------------------------------------------------------------------------
    |
    | This is the guard that Filament will use to authenticate users.
    | You can change it to match the guard used in `config/auth.php`.
    |
    */

    'auth' => [
        'guard' => 'web', // Filament doit utiliser le guard "web"
        'pages' => [
            'login' => \Filament\Http\Livewire\Auth\Login::class,
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Les middlewares que Filament appliquera à toutes les routes.
    |
    */

    'middleware' => [
        'auth' => [
            'filament',
            \Illuminate\Session\Middleware\AuthenticateSession::class,
        ],
        'base' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Filament\Http\Middleware\DispatchServingFilamentEvent::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Model (Admin)
    |--------------------------------------------------------------------------
    |
    | Ici, on définit le modèle utilisateur utilisé par Filament.
    | Comme tu veux que Filament gère uniquement les utilisateurs "physiques"
    | (admins / agents), on laisse `App\Models\User`.
    |
    */

    'auth_provider' => [
        'model' => App\Models\User::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Branding
    |--------------------------------------------------------------------------
    |
    | Personnalisation du panneau Filament (nom, logo, couleurs...).
    |
    */

    'brand' => [
        'name' => 'Tableau de Bord - Bonovapro',
        'logo' => null,
        'favicon' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Sidebar & Navigation
    |--------------------------------------------------------------------------
    */

    'navigation' => [
        'groups' => [
            'Gestion des utilisateurs' => [
                'App\Filament\Resources\UserResource',
            ],
            'Gestion des connexions' => [
                'App\Filament\Resources\OnlineResource',
            ],
        ],
    ],

];
