<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publishers = [
            [
                'name' => 'Penguin Random House',
                'address' => 'Calle Gran Vía 71, Madrid, España',
            ],
            [
                'name' => 'Editorial Planeta',
                'address' => 'Avenida Diagonal 662, Barcelona, España',
            ],
            [
                'name' => 'McGraw-Hill',
                'address' => '1221 Avenue of the Americas, New York, USA',
            ],
            [
                'name' => 'Pearson Education',
                'address' => '80 Strand, London, UK',
            ],
            [
                'name' => 'Oxford University Press',
                'address' => 'Great Clarendon Street, Oxford, UK',
            ],
            [
                'name' => 'Ediciones SM',
                'address' => 'Calle Impresores 2, Madrid, España',
            ],
            [
                'name' => 'Santillana',
                'address' => 'Avenida de los Artesanos 6, Madrid, España',
            ],
            [
                'name' => 'Anagrama',
                'address' => 'Calle de la Montaner 45, Barcelona, España',
            ],
            [
                'name' => 'Alfaguara',
                'address' => 'Calle Torrelaguna 60, Madrid, España',
            ],
            [
                'name' => 'Siglo XXI Editores',
                'address' => 'Calle Amorós 15, Ciudad de México, México',
            ],
        ];

        foreach ($publishers as $publisher) {
            Publisher::create($publisher);
        }
    }
}
