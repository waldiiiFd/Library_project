<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Novela',
                'description' => 'Obras de ficción en prosa con desarrollo de personajes y trama.',
            ],
            [
                'name' => 'Poesía',
                'description' => 'Obras literarias que utilizan la expresión artística de la belleza por medio de la palabra.',
            ],
            [
                'name' => 'Ciencia Ficción',
                'description' => 'Textos basados en avances científicos y tecnológicos posibles o imaginarios.',
            ],
            [
                'name' => 'Fantasía',
                'description' => 'Historias que incluyen elementos mágicos, sobrenaturales o imposibles.',
            ],
            [
                'name' => 'Historia',
                'description' => 'Obras que narran o analizan hechos del pasado.',
            ],
            [
                'name' => 'Biografía',
                'description' => 'Relatos de la vida de una persona narrados por otra.',
            ],
            [
                'name' => 'Autoayuda',
                'description' => 'Libros que buscan ayudar al lector a resolver problemas personales.',
            ],
            [
                'name' => 'Ciencias',
                'description' => 'Obras sobre matemáticas, física, química, biología y otras ciencias naturales.',
            ],
            [
                'name' => 'Informática',
                'description' => 'Libros sobre programación, redes, bases de datos y otras tecnologías informáticas.',
            ],
            [
                'name' => 'Filosofía',
                'description' => 'Obras que exploran cuestiones fundamentales sobre el conocimiento, la existencia y la moral.',
            ],
            [
                'name' => 'Terror',
                'description' => 'Historias diseñadas para provocar miedo o aprensión en el lector.',
            ],
            [
                'name' => 'Drama',
                'description' => 'Obras con situaciones de conflicto entre personajes, generalmente con desenlaces negativos.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
