<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Online;

class OnlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Client 1',
                'email' => 'client1@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Client 2',
                'email' => 'client2@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Client 3',
                'email' => 'client3@example.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $user) {
            Online::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        // Pour l'environnement local, créer des utilisateurs supplémentaires
        if (app()->environment('local')) {
            for ($i = 4; $i <= 6; $i++) {
                Online::firstOrCreate(
                    ['email' => "client{$i}@example.com"],
                    [
                        'name' => "Client {$i}",
                        'password' => Hash::make('password123'),
                    ]
                );
            }
        }
    }
}
