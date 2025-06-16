<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador por defecto
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrador del Sistema',
                'email' => 'admin@gmail.com',
                'phone' => '1234567890',
                'occupation' => 'Administrador',
                'age' => 30,
                'role' => 'admin',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

    }
}