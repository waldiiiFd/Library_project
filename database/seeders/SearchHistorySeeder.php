<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Search_history;
use App\Models\User;
use Illuminate\Support\Carbon;

class SearchHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('active', true)->get();

        $searchTerms = [
            'novela', 'ciencia ficción', 'matemáticas', 'historia', 'programación',
            'García Márquez', 'Stephen King', 'Harry Potter', 'filosofía', 'poesía',
            'Tokio Blues', 'Cien años de soledad', '1984', 'El alquimista', 'Python',
            'Informática', 'Física cuántica', 'Literatura española', 'biografías', 'arte',
            'Orwell', 'Murakami', 'Borges', 'Cortázar', 'Woolf'
        ];

        // Crear 200 registros de historial de búsqueda
        for ($i = 0; $i < 200; $i++) {
            $user = $users->random();
            $searchTerm = $searchTerms[array_rand($searchTerms)];

            Search_history::create([
                'user_id' => $user->id,
                'search_term' => $searchTerm,
                'searched_at' => Carbon::now()->subDays(rand(1, 90))->subHours(rand(1, 24)),
            ]);
        }
    }
}
