<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'code' => 'ADMIN001',
            'name' => 'Administrador Sistema',
            'email' => 'admin@biblioteca.com',
            'type' => 'admin',
            'active' => true,
            'registration_date' => Carbon::now(),
            'password' => Hash::make('password123'),
        ]);

        // Generate 50 random users
        $userTypes = ['estudiante', 'docente', 'externo'];

        for ($i = 1; $i <= 50; $i++) {
            $userType = $userTypes[array_rand($userTypes)];
            $isActive = rand(0, 10) > 1; // 90% are active

            User::create([
                'code' => strtoupper($userType) . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'type' => $userType,
                'active' => $isActive,
                'registration_date' => Carbon::now()->subDays(rand(1, 365)),
                'password' => Hash::make('password123'),
            ]);
        }
    }
}
