<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use Illuminate\Support\Carbon;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Gabriel García Márquez',
                'nacionality' => 'Colombiano',
                'birth_date' => '1927-03-06',
            ],
            [
                'name' => 'J.K. Rowling',
                'nacionality' => 'Británica',
                'birth_date' => '1965-07-31',
            ],
            [
                'name' => 'Stephen King',
                'nacionality' => 'Estadounidense',
                'birth_date' => '1947-09-21',
            ],
            [
                'name' => 'Isabel Allende',
                'nacionality' => 'Chilena',
                'birth_date' => '1942-08-02',
            ],
            [
                'name' => 'Haruki Murakami',
                'nacionality' => 'Japonés',
                'birth_date' => '1949-01-12',
            ],
            [
                'name' => 'Julio Cortázar',
                'nacionality' => 'Argentino',
                'birth_date' => '1914-08-26',
            ],
            [
                'name' => 'Virginia Woolf',
                'nacionality' => 'Británica',
                'birth_date' => '1882-01-25',
            ],
            [
                'name' => 'Jorge Luis Borges',
                'nacionality' => 'Argentino',
                'birth_date' => '1899-08-24',
            ],
            [
                'name' => 'Mario Vargas Llosa',
                'nacionality' => 'Peruano',
                'birth_date' => '1936-03-28',
            ],
            [
                'name' => 'Albert Camus',
                'nacionality' => 'Francés',
                'birth_date' => '1913-11-07',
            ],
            [
                'name' => 'Octavio Paz',
                'nacionality' => 'Mexicano',
                'birth_date' => '1914-03-31',
            ],
            [
                'name' => 'Franz Kafka',
                'nacionality' => 'Checo',
                'birth_date' => '1883-07-03',
            ],
            [
                'name' => 'Paulo Coelho',
                'nacionality' => 'Brasileño',
                'birth_date' => '1947-08-24',
            ],
            [
                'name' => 'Agatha Christie',
                'nacionality' => 'Británica',
                'birth_date' => '1890-09-15',
            ],
            [
                'name' => 'George Orwell',
                'nacionality' => 'Británico',
                'birth_date' => '1903-06-25',
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
