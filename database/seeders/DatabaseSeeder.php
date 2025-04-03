<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PublisherSeeder::class,
            AuthorSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
            LoanSeeder::class,
            FineSeeder::class,
            ReservationSeeder::class,
            SearchHistorySeeder::class,
        ]);
    }
}
