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
        // 1. Usuario Administrador Principal
        User::create([
            'code' => 'ADMIN001',
            'name' => 'Administrador Sistema',
            'email' => 'admin@biblioteca.com',
            'type' => 'admin',
            'active' => true,
            'registration_date' => Carbon::now()->subYears(2),
            'password' => Hash::make('password123'),
            'email_verified_at' => Carbon::now(),
        ]);

        // 2. Usuario Administrador Secundario
        User::create([
            'code' => 'ADMIN002',
            'name' => 'María González',
            'email' => 'maria.gonzalez@biblioteca.com',
            'type' => 'admin',
            'active' => true,
            'registration_date' => Carbon::now()->subYear(),
            'password' => Hash::make('password123'),
            'email_verified_at' => Carbon::now(),
        ]);

        // 3. Usuarios Docentes (15 usuarios)
        $docenteNames = [
            'Dr. Juan Pérez',
            'Dra. Ana Martínez',
            'Prof. Carlos Rodríguez',
            'Profa. Laura Sánchez',
            'Dr. Miguel Torres',
            'Dra. Patricia López',
            'Prof. Roberto García',
            'Profa. Isabel Fernández',
            'Dr. Alberto Ramírez',
            'Dra. Carmen Díaz',
            'Prof. Francisco Morales',
            'Profa. Beatriz Ruiz',
            'Dr. Eduardo Jiménez',
            'Dra. Silvia Castro',
            'Prof. Daniel Ortiz',
        ];

        foreach ($docenteNames as $index => $name) {
            $firstName = explode(' ', $name)[1] ?? 'Docente';
            $lastName = explode(' ', $name)[2] ?? str_pad($index + 1, 2, '0', STR_PAD_LEFT);
            
            User::create([
                'code' => 'DOCENTE' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'name' => $name,
                'email' => strtolower(str_replace([' ', '.'], ['', ''], $firstName . '.' . $lastName)) . '@universidad.edu',
                'type' => 'docente',
                'active' => $index < 14, // Un docente inactivo
                'registration_date' => Carbon::now()->subMonths(rand(3, 24)),
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now()->subMonths(rand(1, 12)),
            ]);
        }

        // 4. Usuarios Estudiantes (30 usuarios)
        for ($i = 1; $i <= 30; $i++) {
            $isActive = rand(0, 10) > 1; // 90% activos
            $name = fake()->name();
            $registrationDate = Carbon::now()->subDays(rand(1, 730)); // Últimos 2 años
            
            User::create([
                'code' => 'ESTUDIANTE' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => $name,
                'email' => 'estudiante' . $i . '@universidad.edu',
                'type' => 'estudiante',
                'active' => $isActive,
                'registration_date' => $registrationDate,
                'password' => Hash::make('password123'),
                'email_verified_at' => $isActive ? $registrationDate->addDays(rand(1, 7)) : null,
            ]);
        }

        // 5. Usuarios Externos (8 usuarios)
        $externalNames = [
            'Investigador Externo 1',
            'Visitante Académico',
            'Consultor Especializado',
            'Investigador Colaborador',
            'Profesor Visitante',
            'Investigador Invitado',
            'Especialista Externo',
            'Colaborador Internacional',
        ];

        foreach ($externalNames as $index => $name) {
            $isActive = $index < 6; // 2 inactivos
            $registrationDate = Carbon::now()->subDays(rand(30, 365));
            
            User::create([
                'code' => 'EXTERNO' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'name' => $name,
                'email' => 'externo' . ($index + 1) . '@correo.com',
                'type' => 'externo',
                'active' => $isActive,
                'registration_date' => $registrationDate,
                'password' => Hash::make('password123'),
                'email_verified_at' => $isActive ? $registrationDate->addDays(rand(1, 5)) : null,
            ]);
        }

        // 6. Usuario de prueba genérico para desarrollo
        if (app()->environment('local', 'development')) {
            User::create([
                'code' => 'TEST001',
                'name' => 'Usuario de Prueba',
                'email' => 'test@test.com',
                'type' => 'estudiante',
                'active' => true,
                'registration_date' => Carbon::now(),
                'password' => Hash::make('test123'),
                'email_verified_at' => Carbon::now(),
            ]);
        }
    }
}