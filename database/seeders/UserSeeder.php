<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuário Master
        User::create([
            'name' => 'Master',
            'email' => 'master@example.com',
            'password' => Hash::make('password123'),
            'role' => 'master',
        ]);

        // Usuário Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Usuário Padrão
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'usuario',
        ]);

        User::create([
            'name' => 'Lucas',
            'email' => 'abreulucas952@gmail.com',
            'password' => Hash::make('Lucas123'),
            'role' => 'master',
        ]);
    }
}
