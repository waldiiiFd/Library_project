<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        $categories = Category::all();

        $books = [
            [
                'title' => 'Cien años de soledad',
                'isbn' => '9780307476463',
                'year_published' => 1967,
                'edition' => 1,
                'stock_total' => 10,
                'stock_available' => 8,
            ],
            [
                'title' => 'Harry Potter y la piedra filosofal',
                'isbn' => '9788478888566',
                'year_published' => 1997,
                'edition' => 3,
                'stock_total' => 15,
                'stock_available' => 12,
            ],
            [
                'title' => 'El resplandor',
                'isbn' => '9788497593793',
                'year_published' => 1977,
                'edition' => 2,
                'stock_total' => 8,
                'stock_available' => 6,
            ],
            [
                'title' => 'La casa de los espíritus',
                'isbn' => '9788401352898',
                'year_published' => 1982,
                'edition' => 1,
                'stock_total' => 7,
                'stock_available' => 5,
            ],
            [
                'title' => 'Tokio blues',
                'isbn' => '9788483835043',
                'year_published' => 1987,
                'edition' => 4,
                'stock_total' => 6,
                'stock_available' => 6,
            ],
            [
                'title' => 'Rayuela',
                'isbn' => '9788420406794',
                'year_published' => 1963,
                'edition' => 5,
                'stock_total' => 5,
                'stock_available' => 3,
            ],
            [
                'title' => 'Al faro',
                'isbn' => '9788426418067',
                'year_published' => 1927,
                'edition' => 2,
                'stock_total' => 4,
                'stock_available' => 4,
            ],
            [
                'title' => 'Ficciones',
                'isbn' => '9788426405456',
                'year_published' => 1944,
                'edition' => 3,
                'stock_total' => 6,
                'stock_available' => 5,
            ],
            [
                'title' => 'La ciudad y los perros',
                'isbn' => '9788420483269',
                'year_published' => 1963,
                'edition' => 2,
                'stock_total' => 7,
                'stock_available' => 6,
            ],
            [
                'title' => 'El extranjero',
                'isbn' => '9788420669786',
                'year_published' => 1942,
                'edition' => 1,
                'stock_total' => 5,
                'stock_available' => 4,
            ],
            [
                'title' => 'El laberinto de la soledad',
                'isbn' => '9788437507613',
                'year_published' => 1950,
                'edition' => 3,
                'stock_total' => 4,
                'stock_available' => 4,
            ],
            [
                'title' => 'La metamorfosis',
                'isbn' => '9788437604722',
                'year_published' => 1915,
                'edition' => 4,
                'stock_total' => 8,
                'stock_available' => 7,
            ],
            [
                'title' => 'El alquimista',
                'isbn' => '9788408144335',
                'year_published' => 1988,
                'edition' => 6,
                'stock_total' => 10,
                'stock_available' => 9,
            ],
            [
                'title' => 'Asesinato en el Orient Express',
                'isbn' => '9788427298064',
                'year_published' => 1934,
                'edition' => 2,
                'stock_total' => 6,
                'stock_available' => 5,
            ],
            [
                'title' => '1984',
                'isbn' => '9788499890944',
                'year_published' => 1949,
                'edition' => 5,
                'stock_total' => 9,
                'stock_available' => 7,
            ],
            [
                'title' => 'Rebelión en la granja',
                'isbn' => '9788499890951',
                'year_published' => 1945,
                'edition' => 3,
                'stock_total' => 7,
                'stock_available' => 6,
            ],
            [
                'title' => 'El amor en los tiempos del cólera',
                'isbn' => '9788497592451',
                'year_published' => 1985,
                'edition' => 2,
                'stock_total' => 5,
                'stock_available' => 4,
            ],
            [
                'title' => 'La sombra del viento',
                'isbn' => '9788408043645',
                'year_published' => 2001,
                'edition' => 1,
                'stock_total' => 8,
                'stock_available' => 7,
            ],
            [
                'title' => 'Don Quijote de la Mancha',
                'isbn' => '9788424118389',
                'year_published' => 1605,
                'edition' => 10,
                'stock_total' => 10,
                'stock_available' => 9,
            ],
            [
                'title' => 'Crónica de una muerte anunciada',
                'isbn' => '9788437604947',
                'year_published' => 1981,
                'edition' => 3,
                'stock_total' => 6,
                'stock_available' => 5,
            ],
        ];

        foreach ($books as $bookData) {
            $publisher = $publishers->random();

            $book = Book::create([
                'title' => $bookData['title'],
                'isbn' => $bookData['isbn'],
                'publisher_id' => $publisher->id,
                'year_published' => $bookData['year_published'],
                'edition' => $bookData['edition'],
                'stock_total' => $bookData['stock_total'],
                'stock_available' => $bookData['stock_available'],
            ]);

            // Asignar autores (1 a 3 autores por libro)
            $randomAuthors = $authors->random(rand(1, 3));
            foreach ($randomAuthors as $author) {
                $book->authors()->attach($author->id);
            }

            // Asignar categorías (1 a 3 categorías por libro)
            $randomCategories = $categories->random(rand(1, 3));
            foreach ($randomCategories as $category) {
                $book->categories()->attach($category->id);
            }
        }
    }
}
