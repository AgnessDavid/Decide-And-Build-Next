<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un Super Administrateur par défaut

        // Vérifie que l'utilisateur connecté n'est pas admin

        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
        // Créer un Super Administrateur par défaut
         User::firstOrCreate(
           ['email' => 'superadmin@example.com'], // Email caché / fictif
            [
         'name' => 'Super Admin',
         'password' => Hash::make('123456789'),
         'role' => 'superadmin',
         'is_active' => true,
         'email_verified_at' => now(),
         ]
          );
//}
        // Créer un Administrateur par défaut
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

            User::firstOrCreate(
                ['email' => 'chefservicecommercial@example.com'],
                [
                    'name' => 'Chef service commercial',
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );


            User::firstOrCreate(
                ['email' => 'Chefserviceinformatique@example.com'],
                [
                    'name' => 'Chef service informatique',
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );


               User::firstOrCreate(
            ['email' => 'agentinformatique@example.com'],
            [
                'name' => 'Agent informatique',
                'password' => Hash::make('password'),
                'role' => 'agent',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

            User::firstOrCreate(
                ['email' => 'gestionnairestock@example.com'],
                [
                    'name' => 'Gestionnaire de stock',
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );


               User::firstOrCreate(
            ['email' => 'Responsablecaisse@example.com'],
            [
                'name' => 'Responsable de la caisse',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );


            User::firstOrCreate(
                ['email' => 'Agentcaisse@example.com'],
                [
                    'name' => 'Agent de caisse',
                    'password' => Hash::make('password'),
                    'role' => 'agent',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );



        // Créer un Gestionnaire par défaut
        User::firstOrCreate(
            ['email' => 'agentcommercial@example.com'],
            [
                'name' => 'Agent commercial',
                'password' => Hash::make('password'),
                'role' => 'agent',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Créer quelques utilisateurs de test si on est en développement
        if (app()->environment('local')) {
            // Utilisateurs gestionnaires supplémentaires
            for ($i = 1; $i <= 3; $i++) {
                User::firstOrCreate(
                    ['email' => "agent{$i}@example.com"],
                    [
                        'name' => "agent{$i}",
                        'password' => Hash::make('password'),
                        'role' => 'agent',
                        'is_active' => true,
                        'email_verified_at' => now(),
                        'last_login_at' => now()->subDays(rand(1, 30)),
                    ]
                );
            }

            // Quelques utilisateurs inactifs pour tester les filtres
            User::firstOrCreate(
                ['email' => 'inactive@example.com'],
                [
                    'name' => 'Utilisateur Inactif',
                    'password' => Hash::make('password'),
                    'role' => 'agent',
                    'is_active' => false,
                    'email_verified_at' => now(),
                ]
            );
        }
    }


    //


}
}
